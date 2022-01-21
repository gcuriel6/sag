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

    #fondo_cargando {
        position: absolute;
        top: 1%;
        background-image:url('imagenes/3.svg');

        background-repeat:no-repeat;
        background-size: 500px 500px; 
        background-position:center;
        /*background-color:#000;*/
        left: 1%;
        width: 98%;
        bottom:3%;
        /*border: 2px solid #6495ed;*/
        /*opacity: .1;*/
        /*filter:Alpha(opacity=10);*/
        border-radius: 5px;
        z-index:2;
        display:none;
    }

    body{
        background-color:rgb(238,238,238);
    }
    #div_contenedor{
        background-color: #ffffff;
        padding-bottom:10px;
    }
    #div_t_facturas{
        max-height:200px;
        min-height:200px;
        overflow-y:auto;
        border: 1px solid #ddd;
        overflow-x:hidden;
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
    #div_radio_iva{
        padding-top:38px;
    }
    .boton_eliminar{
        width:50px;
    }
    #dialog_buscar_facturas > .modal-lg{
        min-width: 80%;
        max-width: 80%;
    } 
    #div_b_timbrar,.secundarios,#div_b_verificar_estatus,#div_b_descargar_acuse{
        display:none;
    }

    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_t_facturas{
            height:auto;
            overflow:auto;
        }
        #div_principal{
            margin-left:0%;
        }
        #div_radio_iva{
            padding-top:10px;
        }
        .boton_eliminar{
            width:100%;
        }
        #dialog_buscar_facturas > .modal-lg{
            max-width: 100%;
        }
    }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">
        <div class="row">
            <div class="col-md-12" id="div_contenedor">

            <br>

                <div class="form-group row">
                    <div class="col-sm-12 col-md-2">
                        <div class="titulo_ban">Facturación</div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-12">

                        <div class="card-header badge-secondary" role="tab" id="heading_semana">
                          <h4 class="mb-0">
                            <a id="link_semana" class="collapsed" data-toggle="collapse" href="#collapse_semana" aria-expanded="true" aria-controls="collapse_semana">
                                <span class="badge badge-secondary">Facturas para la Semana</span>
                            </a>
                          </h4>
                        </div>
                        <div id="collapse_semana" class="collapse collapsed" role="tabpanel" aria-labelledby="heading_semana" data-parent="#accordion">
                            <div class="card-body">
                                
                                <table class="tablon" id="t_semana">
                                    <thead>
                                        <tr class="renglon">
                                            <th scope="col">Unidad de Negocio</th>
                                            <th scope="col">Sucursal</th>
                                            <th scope="col">Empresa Fiscal (Emisor)</th>
                                            <th scope="col">Cliente</th>
                                            <th scope="col">Razon Social (Receptor)</th>
                                            <th scope="col">RFC(Receptor)</th>
                                            <th scope="col">Fecha de Factura</th>
                                            <th scope="col">Periodo</th>
                                            <th scope="col" width="40px"></th>
                                            <th scope="col" width="40px"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    
                    </div>

                </div>

                <br>

                <div class="row">

                    <div class="col-md-12">

                        <div class="card-header badge-secondary" role="tab" id="heading_siguiente">
                          <h4 class="mb-0">
                            <a id="link_siguiente" class="collapsed" data-toggle="collapse" href="#collapse_siguiente" aria-expanded="false" aria-controls="collapse_siguiente">
                                <span class="badge badge-secondary">Facturas para la Siguiente Semana</span>
                            </a>
                          </h4>
                        </div>
                        <div id="collapse_siguiente" class="collapse" role="tabpanel" aria-labelledby="heading_siguiente" data-parent="#accordion">
                            <div class="card-body">
                                
                                <table class="tablon" id="t_siguiente">
                                    <thead>
                                        <tr class="renglon">
                                            <th scope="col">Unidad de Negocio</th>
                                            <th scope="col">Sucursal</th>
                                            <th scope="col">Empresa Fiscal (Emisor)</th>
                                            <th scope="col">Cliente</th>
                                            <th scope="col">Razon Social (Receptor)</th>
                                            <th scope="col">RFC(Receptor)</th>
                                            <th scope="col">Fecha de Factura</th>
                                            <th scope="col">Periodo</th>
                                            <th scope="col" width="40px"></th>
                                            <th scope="col" width="40px"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    
                    </div>

                </div>

                <br>

                <div class="row">

                    <div class="col-md-12">

                        <div class="card-header badge-danger" role="tab" id="heading_vencidas">
                          <h4 class="mb-0">
                            <a id="link_vencidas" class="collapsed" data-toggle="collapse" href="#collapse_vencidas" aria-expanded="false" aria-controls="collapse_vencidas">
                                <span class="badge badge-danger">Facturas Vencidas</span>
                            </a>
                          </h4>
                        </div>
                        <div id="collapse_vencidas" class="collapse" role="tabpanel" aria-labelledby="heading_vencidas" data-parent="#accordion">
                            <div class="card-body">
                                
                                <table class="tablon" id="t_vencidas">
                                    <thead>
                                        <tr class="renglon">
                                            <th scope="col">Unidad de Negocio</th>
                                            <th scope="col">Sucursal</th>
                                            <th scope="col">Empresa Fiscal (Emisor)</th>
                                            <th scope="col">Cliente</th>
                                            <th scope="col">Razon Social (Receptor)</th>
                                            <th scope="col">RFC(Receptor)</th>
                                            <th scope="col">Fecha de Factura</th>
                                            <th scope="col">Periodo</th>
                                            <th scope="col" width="20px"></th>
                                            <th scope="col" width="20px"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    
                    </div>

                </div>

            </div> <!--div_contenedor-->
        </div>      
    </div> <!--div_principal-->

</body>

<div id="fondo_cargando"></div>


<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
  
    var modulo='FACTURACION';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var usuario='<?php echo $_SESSION['usuario']?>';

    var matriz = <?php echo $_SESSION['sucursales']?>;

    $(function()
    {

        cargarFacturasSemana();
        cargarFacturasSiguiente();    

        function cargarFacturasSemana()
        {

            //
            $.ajax({
                type: 'POST',
                url: 'php/facturacion_buscar_semana.php',
                dataType:"json", 
                data : {},
                success: function(data)
                {

                    if(data.length != 0)
                    {

                        for(var i=0;data.length>i;i++)
                        {


                            var html = "<tr></tr>";
                            html += "<td data-label='Unidad de Negocio'>" + data[i].unidad + "</td>";
                            html += "<td data-label='Sucursal'>" + data[i].sucursal + "</td>";
                            html += "<td data-label='Empresa Fiscal (Emisor)'>" + data[i].empresa_fiscal + "</td>";
                            html += "<td data-label='Cliente'>" + data[i].cliente + "</td>";
                            html += "<td data-label='Razon Social (Receptor)'>" + data[i].razon_social_receptor + "</td>";
                            html += "<td data-label='RFC (Receptor)'>" + data[i].rfc_receptor + "</td>";
                            //html += "<td data-label='Tipo de Facturación'>" + data[i].tipo_facturacion + "</td>";
                            html += "<td data-label='Fecha de Factura'>" + data[i].fecha_facturar + "</td>";
                            html += "<td data-label='Periodo'>" + (data[i].periodicidad == 1 ? 'Semanal' : (data[i].periodicidad == 2 ? 'Quincenal' : 'Mensual')) + "</td>";
                            html += "<td data-label=''><button type='button' class='btn btn-success btn-sm form-control' id='b_plantilla' id_contrato='" + data[i].id_contrato + "' id_unidad_negocio='" + data[i].id_unidad_negocio + "' id_sucursal='" + data[i].id_sucursal + "' id_empresa_fiscal='" + data[i].id_empresa_fiscal + "' id_razon_social='" + data[i].id_razon_social + "' razon_social_receptor='" + data[i].razon_social_receptor + "' rfc_receptor='" + data[i].rfc_receptor + "' id_cliente='" + data[i].id_cliente + "' correo_facturas='" + data[i].correo_facturas + "' fecha_facturar='" + data[i].fecha_facturar + "' id_cfdi='" + data[i].id_cfdi + "' ><i class='fa fa-bell' style='font-size:10px;' aria-hidden='true'></i></button></td>";
                            html += "<td data-label=''></td>";
                            html += "</tr>";
                            ///agrega la tabla creada al div 
                            $('#t_semana tbody').append(html);   
                        }

                    }
                    else
                    {

                        var html = '<tr class="renglon_fact">\
                            <td colspan="7">No se encontró información</td>\
                        </tr>';

                        $('#t_semana tbody').append(html);

                    }

                },
                error: function (xhr) {
                    console.log('php/facturacion_buscar_semana.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar facturas s.');
                }
            });

        }

        function cargarFacturasSiguiente()
        {

            //
            $.ajax({
                type: 'POST',
                url: 'php/facturacion_buscar_siguiente.php',
                dataType:"json", 
                data : {},
                success: function(data)
                {

                    if(data.length != 0)
                    {

                        for(var i=0;data.length>i;i++)
                        {


                            var html = "<tr></tr>";
                            html += "<td data-label='Unidad de Negocio'>" + data[i].unidad + "</td>";
                            html += "<td data-label='Sucursal'>" + data[i].sucursal + "</td>";
                            html += "<td data-label='Empresa Fiscal (Emisor)'>" + data[i].empresa_fiscal + "</td>";
                            html += "<td data-label='Cliente'>" + data[i].cliente + "</td>";
                            html += "<td data-label='Razon Social (Receptor)'>" + data[i].razon_social_receptor + "</td>";
                            html += "<td data-label='RFC (Receptor)'>" + data[i].rfc_receptor + "</td>";
                            //html += "<td data-label='Tipo de Facturación'>" + data[i].tipo_facturacion + "</td>";
                            html += "<td data-label='Fecha de Factura'>" + data[i].fecha_facturar + "</td>";
                            html += "<td data-label='Periodo'>" + (data[i].periodicidad == 1 ? 'Semanal' : (data[i].periodicidad == 2 ? 'Quincenal' : 'Mensual')) + "</td>";
                            html += "<td data-label=''><button type='button' class='btn btn-success btn-sm form-control' id='b_plantilla' id_contrato='" + data[i].id_contrato + "' id_unidad_negocio='" + data[i].id_unidad_negocio + "' id_sucursal='" + data[i].id_sucursal + "' id_empresa_fiscal='" + data[i].id_empresa_fiscal + "' id_razon_social='" + data[i].id_razon_social + "' razon_social_receptor='" + data[i].razon_social_receptor + "' rfc_receptor='" + data[i].rfc_receptor + "' id_cliente='" + data[i].id_cliente + "' correo_facturas='" + data[i].correo_facturas + "' fecha_facturar='" + data[i].fecha_facturar + "' id_cfdi='" + data[i].id_cfdi + "' ><i class='fa fa-bell' style='font-size:10px;' aria-hidden='true'></i></button></td>";
                            html += "<td data-label=''></td>";
                            html += "</tr>";
                            ///agrega la tabla creada al div 
                            $('#t_siguiente tbody').append(html);   
                        }

                    }
                    else
                    {

                        var html = '<tr class="renglon_fact">\
                            <td colspan="7">No se encontró información</td>\
                        </tr>';

                        $('#t_siguiente tbody').append(html);

                    }

                },
                error: function (xhr) {
                    console.log('php/facturacion_buscar_semana.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar facturas s.');
                }
            });

        }

        $(document).on('click','#b_plantilla',function()
        {

            alert($(this).attr('id_contrato'));

        });
        
    });

</script>

</html>