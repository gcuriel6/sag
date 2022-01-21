<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GINTHERCORP</title>
    <!-- Hojas de estilo -->
    <link href="css/css/bootstrap.css" rel="stylesheet"  type="text/css" media="all">
    <link href="css/validationEngine.jquery.css" rel="stylesheet" />
    <link href="css/bootstrap-datepicker.standalone.min.css" rel="stylesheet"/>
    <link href="vendor/font_awesome/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet">
    <link href="vendor/select2/css/select2.css" rel="stylesheet"/>
    <link href="css/general.css" rel="stylesheet"  type="text/css"/>
</head>

<style> 
    body{
        background-color:rgb(238,238,238);
        overflow-x:hidden;

    }
    #div_principal{
        padding-top:20px;
        margin-left:4%;
    }
    #div_contenedor{
        background-color: #ffffff;
    }
    #div_t_registros{
        max-height:400px;
        overflow:auto;
    }
    .titulo_tabla{
        width:100%;
        background: #f8f8f8;
        border: 1px solid #ddd;
        padding: .15em;
        font-weight:bold;
    }
    .tablon {
        font-size: 10px;
    }

    .Vencida td{
        color:orange;
    }
    .Cancelada td{
        color:red;
    }

    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_t_registros{
            height:auto;
            overflow:auto;
        }
        #div_principal{
            margin-left:0%;
        }
    }
    
    .abono td{
        background:#D1ECF1;
        color:#004085;
    }


    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-11" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Reportes CXP Facturas </div>
                    </div>
                    
                    <div class="col-sm-12 col-md-6"></div>
                    <div class="col-sm-12 col-md-2">
                       <!-- <button type="button" class="btn btn-info btn-sm form-control"  id="b_pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Facturas Saldadas</button>-->
                    </div>
                </div>
                <BR>
                <div class="row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>

                <div class="row">
                    <div class="col-md-6">
                    <input type="text" name="i_filtro" id="i_filtro" class="form-control form-control-sm filtrar_renglones" alt="renglon_registro" placeholder="Filtrar" autocomplete="off">
                    </div>
                    <div class="col-md-6">
                          
                        <div class="form-group row">
                        <div class="col-sm-12 col-md-1">Del: </div>
                        <div class="input-group col-sm-12 col-md-5">
                            <input type="text" name="i_fecha_inicio" id="i_fecha_inicio" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                            <div class="input-group-addon input_group_span">
                                <span class="input-group-text">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-1">Al: </div>
                        <div class="input-group col-sm-12 col-md-5">
                            <input type="text" name="i_fecha_fin" id="i_fecha_fin" class="form-control form-control-sm fecha" autocomplete="off" readonly disabled>
                            <div class="input-group-addon input_group_span">
                                <span class="input-group-text">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                   
                    </div>   
                </div>
                <hr><!--linea gris-->
                <br>

                <div class="row" id="div_resgitros">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Factura</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Proveedor/Empleado</th>
                                    <th scope="col">Banco</th>
                                    <th scope="col">Cuenta</th>
                                    <th scope="col">Cargo</th>
                                    <th scope="col">Abono</th>
                                    <th scope="col">Documentos</th>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_t_registros">
                            <table class="tablon"  id="t_registros">
                                <tbody>
                                    
                                </tbody>
                            </table>  
                        </div>  
                    </div>
                </div>

                <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
                    <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
                    <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
                    <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
                    <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
                </form>

            <br>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->

    <div id="dialog_proveedores_datos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Datos Proveedor: <span id="nombre_proveedor"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div id="div_datos_proveedor"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="dialog_empleado_datos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Datos Empleado: <span id="nombre_empleado"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div id="div_datos_empleado"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="dialog_detalles" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle CxP Factura: <span id="dato_factura"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div id="div_datos_detalle"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="dialog_visor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Archivo</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			    
			</div>
			<div class="modal-body">
					<div style="width:100%" id="div_archivo"></div>
			</div>
		
		</div>
	</div>
</div>
    
</body>

<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
  
    var modulo='REPORTE_CXP_DOCS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var nombreReporte='';

    var matriz = <?php echo $_SESSION['sucursales']?>;
    $(function(){
        mostrarBotonAyuda(modulo);
        //muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);

        $('#i_fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true,
        });

        $('#i_fecha').val(hoy);

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        });

        $('#i_fecha_inicio').change(function(){
            if($('#i_fecha_inicio').val() != '')
            {
                $('#i_fecha_fin').prop('disabled',false);
                buscaReporteFacturas();
            }
        });

        $('#i_fecha_fin').change(function(){
            buscaReporteFacturas();
        });


       

        buscaReporteFacturas();

        function buscaReporteFacturas(){
            $('#t_registros .renglon').remove();

            $.ajax({
                type: 'POST',
                url: 'php/cxp_reporte_facturas.php',
                dataType:"json", 
                data:{
                    'fechaDe':$('#i_fecha_inicio').val(),
                    'fechaA':$('#i_fecha_fin').val(),
                },
                success: function(data) {
                    console.log("resultado:"+data);
                    if(data.length != 0){
                
                        for(var i=0;data.length>i;i++){
                            ///llena la tabla con renglones de registros
                            if(data[i].id_proveedor == 0){
                                var tipo='empleado';
                            }else{
                                var tipo='proveedor';
                            }

                            var botonVerXml='';
                            var botonVerPdf='';
                            var rutaXML = '';
                            var rutaPDF ='';
                            var botonVerXmlPagos='';
                            var botonDetalle='';
                            var cargoAbono='abono';

                            if(data[i].cargo>0){

                                cargoAbono='cargo';
                                var rutas = data[i].rutas;
                                botonDetalle='<button type="button" class="btn btn-success btn-sm b_detalle" alt="'+data[i].id+'" alt="'+data[i].no_factura+'" tipo="'+data[i].tipo+'">\
                                                        <i class="fa fa-eye" aria-hidden="true"></i>\
                                                    </button>';
                     
                                if(data[i].tipo=='cxp_oc'){

                                    var nombreXml="xml_"+data[i].id_proveedor+"_"+data[i].id_entrada_compra+".xml"; //-- obtengo el nombre del archivo guardado
                                    rutaXML = "portal_proveedores/XML/"+nombreXml;

                                    var nombrePDF="pdf_"+data[i].id_proveedor+"_"+data[i].id_entrada_compra+".pdf"; //-- obtengo el nombre del archivo guardado
                                    rutaPDF = "portal_proveedores/PDF/"+nombrePDF;

                                    botonVerXml='<a style="text-decoration: none;" border="0" type="button" title="xml" class="btn btn-info btn-sm"  href="'+rutaXML+'" download="'+nombreXml+'"><i class="fa fa-download" aria-hidden="true"></i></a>';
                                    
                                    botonVerPdf='<button type="button" title="Factura"class="btn btn-danger btn-sm b_ver_pdf" alt="'+data[i].id_proveedor+'"   alt2="'+data[i].id_entrada_compra+'" tipo="'+data[i].tipo+'"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>';
                                 
                                    if(rutas!=''){

                                        var ruta = rutas.split(',');
                                       
                                        for(var j=0; j < ruta.length; j++){

                                            var rutaPago = "portal_proveedores/"+ruta[i];
                                            
                                            botonVerXmlPagos+='<a style="text-decoration: none;" border="0" type="button" class="btn btn-info btn-sm" title="XML complemento Pago"  href="'+rutaPago+'" download="Pago"><i class="fa fa-file-text" aria-hidden="true"></i></a>';
                                        }
                                      
                                    }
                                                                       
                                    botonDetalle='';
                                }

                            }

                            var vImpresiones = botonDetalle + ' ' + botonVerXml + ' ' + botonVerPdf + ' ' + botonVerXmlPagos;
                            if(data[i].estatus == 'L')
                                vImpresiones = botonDetalle;

                            var html='<tr class="renglon renglon_registro '+cargoAbono+'" alt="'+data[i].id_cxp+'">\
                                        <td data-label="Factura">'+data[i].tipo+'</td>\
                                        <td data-label="Factura">'+data[i].no_factura  + '</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Proveedor" title="Da click aqui para ver la información del Proveedor o Empleado" class="rProveedor" alt='+data[i].id_proveedor+' alt2='+data[i].id_empleado+'>'+data[i].proveedor+'/'+data[i].empleado+'</td>\
                                        <td data-label="Banco">'+data[i].banco+'</td>\
                                        <td data-label="Cuenta">'+data[i].cuenta+'</td>\
                                        <td data-label="Cargo">'+formatearNumero(data[i].cargo)+'</td>\
                                        <td data-label="Abono">'+formatearNumero(data[i].abono)+'</td>\
                                        <td data-label="Factura">' + vImpresiones + '</td>\
                                     </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros tbody').append(html); 

                        }
                    }else{
                        var html='<tr class="renglon">\
                                        <td colspan="3">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros tbody').append(html);
                    }

                },
                error: function (xhr) 
                {
                    console.log('php/cxp_reporte_saldos_proveedores.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de saldos');
                }
            });
        }


        $(document).on('click','.b_ver_pdf',function(){
            
            var idProveedor=$(this).attr('alt');
            var idE01=$(this).attr('alt2');
            var nombrePdf="pdf_"+idProveedor+"_"+idE01+".pdf"; //-- obtengo el nombre del archivo guardado
            var rutaPDF = "portal_proveedores/PDF/"+nombrePdf;
           
            $("#div_archivo").empty(); 
           
            var fil="<embed width='100%' height='500px' src='"+rutaPDF+"'>";
            $("#div_archivo").append(fil);  

            $('#dialog_visor').modal('show');
        });

        $(document).on('click','.rProveedor',function(){
            var idProveedor = $(this).attr('alt');
            var idEmpleado = $(this).attr('alt2');
            if(idProveedor>0){
                muestraInfoProveedor(idProveedor);
            }
            if(idEmpleado>0){
                muestraInfoEmpleado(idEmpleado);
            }
        });


        function muestraInfoProveedor(idProveedor){
            $.ajax({
                type: 'POST',
                url: 'php/proveedores_buscar_id.php',
                dataType:"json", 
                data:{
                    'idProveedor':idProveedor
                },
                success: function(data) {
                    if(data.length > 0){
                        if(data[0].num_int != '')
                        {
                            var num_int=' Int.'+data[0].num_int;
                        }else{
                            var num_int='';
                        }

                        $('#nombre_proveedor').text(data[0].nombre);

                        var detalles = '<p>Nombre: '+data[0].nombre+'</p>';
                            detalles += '<p>RFC: '+data[0].rfc+'</p>';
                            detalles += '<p>Domicilio: '+data[0].domicilio+' '+data[0].num_ext+' '+num_int+'. '+data[0].colonia+', '+data[0].municipio+', '+data[0].estado+', '+data[0].pais+'</p>';
                            detalles += '<p>Código Postal: '+data[0].cp+'</p>';
                            detalles += '<p>Telefono: '+data[0].telefono+'</p>';
                            detalles += '<p>Dias Credito: '+data[0].dias_credito+'</p>';
                            detalles += '<p>Web: '+data[0].web+'</p>';
                            detalles += '<p>Contacto: '+data[0].contacto+'</p>';
                            detalles += '<p>Condiciones: '+data[0].condiciones+'</p>';

                        $('#div_datos_proveedor').html(detalles);

                    }

                    $('#dialog_proveedores_datos').modal('show');
                    
                },
                error: function (xhr) 
                {
                    console.log('php/proveedores_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar proveedor');
                }
            });
        }

        function muestraInfoEmpleado(idEmpleado){
            $.ajax({
                type: 'POST',
                url: 'php/empleados_buscar_id.php',
                dataType:"json", 
                data:{
                    'idEmpleado':idEmpleado
                },
                success: function(data) {
                    if(data.length > 0){
                        $('#nombre_empleado').text(data[0].empleado);

                        var detalles = '<p>Nombre: '+data[0].empleado+'</p>';
                            detalles += '<p>Iniciales: '+data[0].iniciales+'</p>';
                            detalles += '<p>Domicilio: '+data[0].direccion+'. '+data[0].colonia+', '+data[0].municipio+', '+data[0].estado+'</p>';
                            detalles += '<p>Telefono: '+data[0].telefono+'</p>';
                            detalles += '<p>Email: '+data[0].correo+'</p>';

                        $('#div_datos_empleado').html(detalles);

                    }

                    $('#dialog_empleado_datos').modal('show');
                    
                },
                error: function (xhr) 
                {
                    console.log('php/empleados_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar empleado');
                }
            });
        }

        function mostrarDetalleViatico(id,factura){
            $.ajax({
                type: 'POST',
                url: 'php/viaticos_buscar_id.php',
                dataType:"json", 
                data:{
                    'idViatico':id
                },
                success: function(data) {
                    if(data.length > 0){
                        $('#dato_factura').text(factura);

                        var detalles = '<p><b>Unidad de Negocio:</b> '+data[0].unidad+'</p>';
                            detalles += '<p><b>Sucursal:</b> '+data[0].sucursal+'</p>';
                            detalles += '<p><b>Área:</b> '+data[0].are+'</p>';
                            detalles += '<p><b>Departamento:</b> '+data[0].departamento+'</p>';
                            detalles += '<p><b>Solicitó:</b> '+data[0].solicito+'</p>';
                            detalles += '<p><b>Destino:</b> '+data[0].destino+'</p>';
                            detalles += '<p><b>Distancia:</b> '+data[0].distancia+'</p>';
                            detalles += '<p><b>Motivos del Viaje:</b> '+data[0].motivos+'</p>';
                            detalles += '<p><b>Del:</b> '+data[0].fecha_inicio+' <b>Al:</b> '+data[0].fecha_fin+'</p>';
                            detalles += '<p><b>Días:</b> '+data[0].dias+' <b>Noches:</b> '+data[0].noches+'</p>';
                            detalles += '<p><b>Monto:</b> $'+formatearNumero(data[0].total)+'</p>';
                            detalles += '<p><b>Autorizó:</b> '+data[0].autorizo+'</p>';
                            detalles += '<p><b>Empleado:</b> '+data[0].empleado+'</p>';

                        $('#div_datos_detalle').html(detalles);

                    }

                    $('#dialog_detalles').modal('show');
                    
                },
                error: function (xhr) 
                {
                    console.log('php/viaticos_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar detalle del registro');
                }
            });
        }

         $(document).on('click','.b_detalle',function(){
            var id = $(this).attr('alt');
            var factura = $(this).attr('alt2');
            var tipo = $(this).attr('tipo');
            mostrarDetalleCxP(id,factura,tipo)
        });

        function mostrarDetalleCxP(id,factura,tipo){
            $.ajax({
                type: 'POST',
                url: 'php/cxpPagos_buscar_id.php',
                dataType:"json", 
                data:{
                    'id':id,
                    'tipo':tipo
                },
                success: function(data) {
                    if(data.length > 0){
                        $('#dato_factura').text(factura);

                        var detalles = '<p><b>Unidad de Negocio:</b> '+data[0].unidad+'</p>';
                            detalles += '<p><b>Sucursal:</b> '+data[0].sucursal+'</p>';
                            detalles += '<p><b>Área:</b> '+data[0].are+'</p>';
                            detalles += '<p><b>Departamento:</b> '+data[0].departamento+'</p>';
                            detalles += '<p><b>Solicitó:</b> '+data[0].solicito+'</p>';
                            detalles += '<p><b>Destino:</b> '+data[0].destino+'</p>';
                            detalles += '<p><b>Distancia:</b> '+data[0].distancia+'</p>';
                            detalles += '<p><b>Motivos del Viaje:</b> '+data[0].motivos+'</p>';
                            detalles += '<p><b>Del:</b> '+data[0].fecha_inicio+' <b>Al:</b> '+data[0].fecha_fin+'</p>';
                            detalles += '<p><b>Días:</b> '+data[0].dias+' <b>Noches:</b> '+data[0].noches+'</p>';
                            detalles += '<p><b>Monto:</b> $'+formatearNumero(data[0].total)+'</p>';
                            detalles += '<p><b>Autorizó:</b> '+data[0].autorizo+'</p>';
                            detalles += '<p><b>Empleado:</b> '+data[0].empleado+'</p>';

                        $('#div_datos_detalle').html(detalles);

                    }

                    $('#dialog_detalles').modal('show');
                    
                },
                error: function (xhr) 
                {
                    console.log('php/cxpPagos_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar detalle del registro');
                }
            });
        }

        $(document).on('click','.b_ver_pagos',function(){

        });


      

        $('#b_pdf').click(function(){
            var datos = {
                    'path':'formato_cxp_facturas_saldadas',
                    'nombreArchivo':'cxp_facturas_saldadas',
                    'tipo':1
                };
            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);
            window.open("php/convierte_pdf.php?D="+datosJ,'_new')
        });
        
    });

</script>

</html>