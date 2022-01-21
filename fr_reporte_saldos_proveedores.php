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

    .renglonE th{
        background:#CCE5FF;
    }

    .renglonP td{
        background:#D4EDDA;
    }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-11" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Reportes Saldos Proveedores</div>
                    </div>
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-12 col-md-2">
                        <div class="row">
                            <label for="i_fecha" class="col-sm-12 col-md-3 col-form-label">Fecha </label>
                            <div class="col-md-9">
                                <input type="text" id="i_fecha" name="i_fecha" class="form-control form-control-sm" autocomplete="off" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-info btn-sm form-control"  id="b_pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Saldos</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel" disabled><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                    </div>
                </div>

                <div class="row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>
                <br>

                <div class="row">
                         <label for="i_proveedor" class="col-2 col-md-2 col-form-label">Proveedor </label>
                        
                        <div class="col-sm-12 col-md-6">
                            <div class="row">
                                
                                <div class="input-group col-sm-12 col-md-10">
                                    <input type="text" id="i_proveedor" name="i_proveedor" class="form-control" readonly autocomplete="off">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_buscar_proveedor" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-info" type="button" id="b_detalle_proveedor" style="margin:0px;">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-2">
                            <button type="button" class="btn btn-dark btn-sm form-control"  id="b_limpiar"><i class="fa fa-refresh" aria-hidden="true"></i> Limpiar Busqueda</button>
                        </div>
                </div>        

                <div class="row" id="div_resgitros">
                    <div class="col-sm-12 col-md-12">
                        <div id="div_t_registros">
                           
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
</body>
<div id="dialog_buscar_proveedores" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Proveedores</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_proveedores" id="i_filtro_proveedores" class="form-control filtrar_renglones" alt="renglon_proveedores" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_proveedores">
                      <thead>
                        <tr class="renglon">
                          <th scope="col" width="10%">ID</th>
                          <th scope="col" width="10%">RFC</th>
                          <th scope="col" width="30%">Nombre</th>
                          <th scope="col" width="10%">Grupo</th>
                          <th scope="col" width="10%">Estatus</th>
                          <th scope="col" width="20%">Usuario</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>  
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

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
    


<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
  
    var modulo='REPORTES_SALDOS_PROVEEDORES';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var nombreReporte='';

    var matriz = <?php echo $_SESSION['sucursales']?>;
    $(function(){
        mostrarBotonAyuda(modulo);
        //muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);

        /*$('#i_fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true,
        });*/

        $('#i_fecha').val(hoy);

        buscaSaldosProvedores(0);

        function buscaSaldosProvedores(idProveedor){
           
            $('#div_t_registros').html('');

            $.ajax({
                type: 'POST',
                url: 'php/cxp_reporte_saldos_proveedores_generar.php',
                data:{
                    'idProveedor':idProveedor
                },
                success: function(data) {
                   
                    if(data != ''){
                        $('#div_t_registros').html(data);
                        $("#b_excel").prop('disabled',false);
                    }

                },
                error: function (xhr) 
                {
                    console.log('php/cxp_reporte_saldos_proveedores.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de saldos');
                }
            });
        }


        $('#b_buscar_proveedor').on('click',function(){
           
            $('#forma').validationEngine('hide');
            $('#i_filtro_proveedores').val('');
            $('.renglon_proveedores').remove();

            $.ajax({

                type: 'POST',
                url: 'php/proveedores_buscar.php',
                dataType:"json", 
                data:{'estatus':2},

                success: function(data) {
                
                if(data.length != 0){

                        $('.renglon_proveedores').remove();
                
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var inactivo='';
                            
                            if(parseInt(data[i].inactivo) == 1){

                                inactivo='Inactivo';
                            }else{
                                inactivo='Activo';
                            }


                            var html='<tr class="renglon_proveedores" alt="'+data[i].id+'"  alt2="' + data[i].nombre+ '">\
                                        <td data-label="ID" class="editar">' + data[i].id+ '</td>\
                                        <td data-label="RFC" class="editar">' + data[i].rfc+ '</td>\
                                        <td data-label="Nombre" class="editar">' + data[i].nombre+ '</td>\
                                        <td data-label="Grupo" class="editar">' + data[i].grupo+ '</td>\
                                        <td data-label="Estatus" class="editar">' + inactivo+ '</td>\
                                        <td data-label="Usuario" class="editar">' + data[i].usuario+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_proveedores tbody').append(html);   
                            
                        }
                        $('#dialog_buscar_proveedores').modal('show');
                }else{

                        mandarMensaje('No se encontró información');
                }

                },
                error: function (xhr) {
                    console.log('php/proveedores_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        });

        $('#t_proveedores').on('click', '.renglon_proveedores', function() {
            
            var idProveedor = $(this).attr('alt');
            var nombre = $(this).attr('alt2');

            $('#i_proveedor').attr('alt',idProveedor).val(nombre);
            $('#b_pdf').attr('alt',idProveedor);

            buscaSaldosProvedores(idProveedor);
            $('#dialog_buscar_proveedores').modal('hide');

        });

        $('#b_limpiar').on('click',function(){

            $('#i_proveedor').attr('alt',0).val('');
            $('#b_pdf').attr('alt',0);
            buscaSaldosProvedores(0);
        });

        $('#b_detalle_proveedor').click(function(){
            if($('#i_proveedor').val() != '')
            {
                var idProveedor = $('#i_proveedor').attr('alt');
               
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
                        mandarMensaje('Error en el sistema');
                    }
                });
            }else{
                mandarMensaje('Primero debes selecionar un proveedor');
            }
        });

        /*$("#t_registros tbody").on('click',".renglon_saldo",function()
        {

            var idProveedor = $(this).attr('alt');
            $('#renglon_'+idProveedor).toggle();
            muestraDetalleCuenta(idProveedor);
        });*/

        function muestraDetalleCuenta(idProveedor){
            $('#t_provvedor_'+idProveedor+' tbody').empty(); 
           
            $.ajax({
                type: 'POST',
                url: 'php/cxp_reporte_saldos_proveedores_detalle.php',
                dataType:"json", 
                data:{
                    'idProveedor' : idProveedor
                },
                success: function(data) {
                    if(data.length != 0){
                        var saldo=0;
                        for(var i=0;data.length>i;i++){
                            ///llena la tabla con renglones de registros
                            saldo= saldo + parseFloat(data[i].cargos) - parseFloat(data[i].abonos)
                            var html='<tr class="renglon_detalle_p '+data[i].vencida+ data[i].estatus+'" alt="'+data[i].id_proveedor+'">\
                                        <td data-label="Cuenta">'+data[i].fecha+'</td>\
                                        <td data-label="Cuenta">'+data[i].referencia+'</td>\
                                        <td data-label="Cuenta">'+data[i].concepto+'</td>\
                                        <td data-label="Vencido">'+formatearNumero(data[i].cargos)+'</td>\
                                        <td data-label="Saldo">'+formatearNumero(data[i].abonos)+'</td>\
                                        <td data-label="Saldo">'+formatearNumero(saldo)+'</td>\
                                     </tr>\
                                     <tr class="renglon_detalle r_proveedor_'+data[i].proveedor+'" style="display:none;">\
                                     </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_provvedor_'+idProveedor+' tbody').append(html); 

                        }
                    }else{
                        var html='<tr class="renglon_detalle_p">\
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

        $('#b_pdf').click(function(){

            var idProveedor = $(this).attr('alt');
            if($(document).find('.renglonP').length>0){
                var datos = {
                        'path':'formato_saldos_proveedores',
                        'idRegistro':idProveedor,
                        'fechaInicio':$('#i_fecha_inicio').val(),
                        'fechaFin':$('#i_fecha_fin').val(),
                        'nombreArchivo':'cxp_saldos_proveedores',
                        'tipo':3
                    };
                let objJsonStr = JSON.stringify(datos);
                let datosJ = datosUrl(objJsonStr);

                window.open("php/convierte_pdf.php?D="+datosJ,'_new');
            }else{
                mandarMensaje('No se encontró infromacion de saldos de proveedores');
            }
        });

        //-->NJES November/04/2020 exportar html a excel
        $("#b_excel").click(function(e) {
            //var aux = new Date();
            //var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
            filename = 'Saldos_Proveedores';
            var downloadLink;
            var dataType = 'application/vnd.ms-excel';
            var tableSelect = document.getElementById('div_t_registros');
            var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');  //'&nbsp;'
            // Specify file name
            filename = filename?filename+'.xls':'excel_data.xls';
            // Create download link element
            downloadLink = document.createElement("a");
            document.body.appendChild(downloadLink);
            if(navigator.msSaveOrOpenBlob){
                var blob = new Blob(['ufeff', tableHTML], {
                    type: dataType
                });
                navigator.msSaveOrOpenBlob( blob, filename);
            }else{
                // Create a link to the file
                downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
                // Setting the file name
                downloadLink.download = filename;
                //triggering the function
                downloadLink.click();
            }
        });
        
    });

</script>

</html>