<?php session_start(); ?>
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
    <link href="css/general.css" rel="stylesheet"  type="text/css"/>
    <link href="vendor/font_awesome/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet">
    <link href="vendor/select2/css/select2.css" rel="stylesheet"/>
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
    #div_t_montos_nomina{
        height:170px;
        overflow:auto;
    }
    #td_descripcion{
        width:30%;
    }
    #td_clave{
        width:10%;
    }

    .izquierda { 
        text-align: right; 
    }

    .tr_totales th{
        border:none;
        background:rgba(231,243,245,0.6);
        font-weight:bold;
        font-size:11px;
        text-align:right;
    }
    .tr_totales th input{
        font-weight:bold;
        font-size:11px;
        text-align:right;
        margin-right:10px;
        padding-right:10px;
    }

    #d_estatus{
       padding-top:7px;
       text-align:center;
       font-weight:bold;
       font-size:15px;
       height:40px;
       vertical-align:middle;
   }

    /* Responsive Web Design */
    @media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_t_montos_nomina{
            height:auto;
            overflow:auto;
        }
        #td_descripcion{
            width:100%;
        }
        #td_clave{
            width:100%;
        }
    }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">
<form id="f_requisiciones" name="f_requisiciones">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Cancelar Ordenes de Compra</div>
                    </div>
                    <div class="col-sm-12 col-md-5"></div>
                    <div class="col-sm-12 col-md-3">
                        <button type="button" class="btn btn-danger btn-sm form-control" id="b_cancelar"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar Orden de Compra</button>
                    </div>
                </div>

                <br>

                <div class="row">

                    <div class="col-sm-12 col-md-3">
                        <input type="hidden"  id="i_id_orden_compra" name="i_id_orden_compra">
                        <table>
                            <tr>
                                <td>
                                    <b><label for="i_folio" class="col-sm-2 col-md-2 col-form-label">Folio</label></b>
                                </td>
                                <td>
                                    <div class="col-sm-12 col-md-12">
                                        <input type="text" id="i_folio" name="i_folio" class="form-control izquierda" readonly autocomplete="off"/>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-sm-12 col-md-1">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_buscar"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;</button>
                    </div>  

                    <div class="col-sm-12 col-md-4">
                        <div id="d_estatus" class="alert"></div>
                    </div>

                    <div class="col-sm-12 col-md-5"></div>

                </div>    

                <div class="row">

                    <div class="col-sm-12 col-md-3">
                        <label for="i_fecha_pedido" class="col-sm-2 col-md-12 col-form-label ">Fecha de Pedido</label>
                        <div class="col-sm-12 col-md-12">
                            <input type="text"  id="i_fecha_pedido" name="i_fecha_pedido" class="form-control" autocomplete="off" readonly>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <label for="i_proveedor" class="col-sm-2 col-md-12 col-form-label ">Proveedor</label>
                        <div class="col-sm-12 col-md-12">
                            <input type="text"  id="i_proveedor" name="i_proveedor" class="form-control" autocomplete="off" readonly>
                        </div>
                    </div>

                    
                    <div class="col-sm-12 col-md-3">
                        <label for="i_solicito" class="col-sm-2 col-md-12 col-form-label ">Solicito</label>
                        <div class="col-sm-12 col-md-12">
                            <input type="text"  id="i_solicito" name="i_solicito" class="form-control" autocomplete="off" readonly>
                        </div>
                    </div>
                    
                </div>

                <br>

                <div class="row">                    

                    <div class="col-sm-12 col-md-12">
                        <table class="tablon" id="t_partidas">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Partida</th>
                                    <th scope="col">Familia</th>
                                    <th scope="col">Linea</th>
                                    <th scope="col">Concepto</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Costo Unitario</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Surtida</th>
                                    <th scope="col">Pendiente</th>
                                    <th width="40" scope="col"></th>
                                    <th width="40s" scope="col"></th>
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


<div id="dialog_ordenes_compra" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Búsqueda de Órdenes de Compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                <label for="s_filtro_unidad" class="col-sm-12 col-md-3 col-form-label">Unidad Negocio </label>
                        
                    <div class="col-md-6">
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-10">
                                <select id="s_filtro_unidad" name="s_filtro_unidad" class="form-control" autocomplete="off" style="width:100%;"></select>
                            </div>
                        </div>
                    </div> 
                </div>    
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group row">
                            <div class="input-group col-sm-12 col-md-12">
                                <select id="s_filtro_sucursal" name="s_filtro_sucursal" class="form-control filtros" placeholder="Sucursal" autocomplete="off" style="width:100%;"></select>
                            </div>
                        </div> 
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div class="row">
                            <div class="col-sm-12 col-md-1">Del: </div>
                            <div class="input-group col-sm-12 col-md-5">
                                <input type="text" name="i_fecha_inicio" id="i_fecha_inicio" class="form-control fecha" autocomplete="off" readonly>
                                <div class="input-group-addon input_group_span">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-1">Al: </div>
                            <div class="input-group col-sm-12 col-md-5">
                                <input type="text" name="i_fecha_fin" id="i_fecha_fin" class="form-control fecha" autocomplete="off" readonly disabled>
                                <div class="input-group-addon input_group_span">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <input type="text" name="i_filtro" id="i_filtro" alt="renglon_orden_compra" class="form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off">
                    </div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_ordenes_compra">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Sucursal</th>
                                    <th scope="col">Folio</th>
                                    <th scope="col">Fecha Pedido</th>
                                    <th scope="col">Proveedor</th>
                                    <th scope="col">Partidas</th>
                                    <th scope="col">Total</th>
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

<div id="dialog_confirm" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">CANCELAR ORDEN DE COMPRA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-primary btn-lg" data-dismiss="modal"> NO </button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" id="b_cancelar_orden" class="btn btn-danger btn-lg"> SI </button>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                </div>
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
<script src="vendor/select2/js/select2.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>

<script>
    
    var modulo = 'CANCELAR_OC';
    var idUnidadActual = <?php echo $_SESSION['id_unidad_actual']; ?>;
    var idUsuario = <?php echo $_SESSION['id_usuario']; ?>;
    var matriz = <?php echo $_SESSION['sucursales']; ?>;
    $(function()
    {

        mostrarBotonAyuda(modulo);
        $('#b_cancelar').prop('disabled', true);
        muestraSucursalesPermiso('s_filtro_sucursal', idUnidadActual,modulo,idUsuario);

        $('#i_fecha_inicio,#i_fecha_fin').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        });

        function buscarOrden()
        {

            $('.renglon_orden_compra').remove();

            $.ajax({

                type: 'POST',
                url: 'php/orden_compra_buscar.php',
                dataType:"json", 
                data:{
                    'fechaInicio':$('#i_fecha_inicio').val(),
                    'fechaFin':$('#i_fecha_fin').val(),
                    'idUnidadNegocio': $('#s_filtro_unidad').val(),
                    'idSucursal':$('#s_filtro_sucursal').val()
                },
                success: function(data)
                {

                    if(data.length != 0)
                    {

                        $('.renglon_orden_compra').remove();
                
                        for(var i=0;data.length>i;i++)
                        {

                            ///llena la tabla con renglones de registros
                            //-->NJES November/11/2020 agregar atributo fam_fletes
                            var html='<tr class="renglon_orden_compra" i_id_orden_compra="' + data[i].id + '" id_unidad="' + data[i].id_unidad_negocio + '" id_sucursal="' + data[i].id_sucursal + '" id_area="' + data[i].id_area +'" estatus="' + data[i].estatus + '" proveedor="' + data[i].proveedor + '"  solicito="' + data[i].solicito + '"  fecha_pedido="' + data[i].fecha_pedido + '" folio="' + data[i].folio + '" fam_fletes="'+data[i].fam_fletes+'">\
                                        <td data-label="Orden" class="i_filtro1">' + data[i].sucursal+ '</td>\
                                        <td data-label="Orden" class="i_filtro1">' + data[i].folio+ '</td>\
                                        <td data-label="Fecha Pedido">' + data[i].fecha_pedido+ '</td>\
                                        <td data-label="Proveedor" class="i_filtro2">' + data[i].proveedor+ '</td>\
                                        <td data-label="Partidas">' + data[i].partidas+ '</td>\
                                        <td data-label="Total">' + formatearNumero(data[i].total)+ '</td>\
                                        <td data-label="Estatus">' + data[i].estatus+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_ordenes_compra tbody').append(html);   

                             
                              
                        }
                    }
                    else
                         mandarMensaje('No se encontró información');

                },
                error: function (xhr) 
                {
                    console.log('php/orden_compra_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        $('#t_ordenes_compra').on('click', '.renglon_orden_compra', function()
        {

            var idOrdenCompra = $(this).attr('i_id_orden_compra');
            var proveedor = $(this).attr('proveedor');
            var solicito = $(this).attr('solicito');
            var fechaPedido = $(this).attr('fecha_pedido');
            var folio = $(this).attr('folio');
            var estatus = $(this).attr('estatus');

            //-->NJES November/11/2020 identificar si la orden de compra tiene requis con familia gastoa FLETES Y LOGISTICA
            //para bloquear los botones de cancelar en cada partida
            //Solo se puede cancelar la orden compra completa
            var fam_fletes = $(this).attr('fam_fletes');

            if(fam_fletes > 0)
                var b_disabled = 'disabled';
            else
                var b_disabled = '';

            if(estatus == 'Cancelada')
            {
                $('#b_cancelar').prop('disabled', true);
                $('#d_estatus').addClass('alert alert-sm alert-danger').text('CANCELADA');
            }
            else
            {
                $('#d_estatus').removeAttr('class');
                $('#d_estatus').text('').removeAttr('class');

                $('#b_cancelar').prop('disabled', false);
            }

            $('#t_partidas >tbody tr').remove();

            $('#i_id_orden_compra').val(idOrdenCompra);
            $('#i_folio').val(folio);
            $('#i_proveedor').val(proveedor);
            $('#i_solicito').val(solicito);
            $('#i_fecha_pedido').val(fechaPedido);
            $('#dialog_ordenes_compra').modal('hide');

            var totalPendiente = 0;
            var totalSurtidos = 0;

            $.ajax({
                type: 'POST',
                url: 'php/orden_compra_buscar_detalle.php',
                dataType:"json", 
                data:{
                    'idOrdenCompra':idOrdenCompra
                },
                success: function(data)
                {
                    
                    totalPartidas = 0;
                    for(var i=0; data.length>i; i++)
                    {

                        var detalle = data[i];

                        totalPartidas++;
                        
                        var pendiente = (parseInt(detalle.cantidad) - parseInt(detalle.entregados));
                        if(detalle.estatus=='L')
                        pendiente=0;

                        totalSurtidos=parseFloat(totalSurtidos)+parseFloat(detalle.entregados);
                        var html = "<tr class='partida-orden' id_partida='" + detalle.id + "' >";
                        html += "<td>" + totalPartidas + "</td>";
                        html += "<td>" + detalle.familia + "</td>";
                        html += "<td>" + detalle.linea + "</td>";
                        html += "<td>" + detalle.concepto + "</td>";
                        html += "<td>" + detalle.descripcion + "</td>";
                        html += "<td align='right'>" + formatearNumero(detalle.costo) + "</td>";
                        html += "<td align='right'>" + detalle.cantidad + "</td>";
                        html += "<td align='right'>" + detalle.entregados + "</td>";
                        html += "<td align='right'>" + pendiente + "</td>";

                        if(detalle.estatus == 'C')
                            html += "<td colspan='2' valign='center'><h6><span class='badge badge-danger'>CANCELADA</span></h6></td>"
                        else
                        {


                           //--MGFS 27-01-2020 SE AGREGA VALIDACIÓN PARA QUE SOLO SE PUEDAN LIQUIDAR PARTIDAS QUE TIENEN PRODUCTO RECIBIDO 
                            if(detalle.estatus == 'I' && parseFloat(detalle.entregados)>0 && (parseFloat(detalle.cantidad) > parseFloat(detalle.entregados)))
                            {
                                totalPendiente++;
                                html += "<td colspan='2'><button "+b_disabled+" type='button' class='btn btn-danger btn-sm form-control' id='b_cancelar_restante' alt='" + detalle.id + "' alt2='"+detalle.entregados+"' anticipo='"+detalle.b_anticipo+"'><i class='fa fa-list' aria-hidden='true'></i></button></td>"
                            }else{
                                if(detalle.estatus=='L'){
                                    html += "<td colspan='2' valign='center'><h6><span class='badge badge-warning'>LIQUIDADA</span></h6></td>";
                                }else{
                                    if(detalle.estatus == 'I' && (parseFloat(detalle.cantidad) == parseFloat(detalle.entregados))){
                                        html += "<td colspan='2' valign='center'><h6><span class='badge badge-success'>SURTIDA</span></h6></td>";
                                    }else{
                                        html += "<td colspan='2'><button "+b_disabled+" type='button' class='btn btn-danger btn-sm form-control' id='b_cancelar_partida' alt='" + detalle.id + "' anticipo='"+detalle.b_anticipo+"' id_requisicion='"+detalle.idRequi+"'><i class='fa fa-remove' aria-hidden='true'></i></button></td>";
                                    }
                                   
                                }
                            }

                        }

                        //--MGFS se cambia la condición si no se a surtido nada se puede cancelar la orden completa
                        if(totalSurtidos > 0 )
                            $('#b_cancelar').prop('disabled', true);

                        html += "</tr>";

                        $('#t_partidas tbody').append(html);
                    
                    }

         
                },
                error: function (xhr)
                {
                    console.log('php/orden_compra_buscar_detalle.php --> '+JSON.stringify(xhr));
                    mandarMensaje(xhr.responseText);
                }
            });

        });

        $(document).on('click','#b_cancelar_restante',function()
        {

            var idOrdenCompra = $('#i_id_orden_compra').val();
            var idPartida = $(this).attr('alt');
            var entregados = $(this).attr('alt2');
            var anticipo = $(this).attr('anticipo');
            //-->NJES March/12/2020 se valida si la requisicion tiene anticipo porque no se podra cancelar
            if(anticipo == 0)
            {
                $.ajax({

                    type: 'POST',
                    url: 'php/orden_compra_cancelar_restante.php',
                    data:{
                        'id_partida': idPartida,
                        'entregados' : entregados
                    },
                    success: function(data)
                    {

                        if(data == true)
                        {
                            mandarMensaje('La Partida se liquido de Forma Correcta');
                            limpiarBuscarOrden(idOrdenCompra);
                        }

                    },
                    error: function (xhr) 
                    {
                        console.log('php/orden_compra_cancelar_restante.php --> '+JSON.stringify(xhr));
                        mandarMensaje('* Error en el sistema');
                    }
                });
            }else{
                mandarMensaje('Esta partida no puede ser cancelada porque pertenece a una requisición con anticipo.');
            }

        });

        $(document).on('click','#b_cancelar_partida',function()
        {
            $('#b_cancelar_partida').prop('disabled',true);
            var idOrdenCompra = $('#i_id_orden_compra').val();
            var idPartida = $(this).attr('alt');
            var anticipo = $(this).attr('anticipo');
            var id_requisicion = $(this).attr('id_requisicion');
            //-->NJES March/12/2020 se valida si la requisicion tiene anticipo porque no se podra cancelar
            //if(anticipo == 0)
            //-->NJES August/14/2020 si la requisicion no tiene abonos se podra cancelar
            if(existeCxpRequisicion(id_requisicion) == 0)
            {
                $.ajax({

                    type: 'POST',
                    url: 'php/orden_compra_cancelar_partida.php',
                    data:{
                        'idOrdenCompra' : idOrdenCompra,
                        'id_partida': idPartida,
                        'idRequisicion':id_requisicion
                    },
                    success: function(data)
                    {

                        if(data == true)
                        {
                            mandarMensaje('La Partida se cancelo de Forma Correcta');
                            limpiarBuscarOrden(idOrdenCompra);
                            $('#b_cancelar_partida').prop('disabled',false);
                        }else{
                            mandarMensaje('Error al cancelar partida');
                            $('#b_cancelar_partida').prop('disabled',false);
                        }

                    },
                    error: function (xhr) 
                    {
                        console.log('php/orden_compra_cancelar_partida.php --> '+JSON.stringify(xhr));
                        mandarMensaje('* Error en el sistema al cancelar');
                        $('#b_cancelar_partida').prop('disabled',false);
                    }
                });
            }else{
                //mandarMensaje('Esta partida no puede ser cancelada porque pertenece a una requisición con anticipo.');
                mandarMensaje('Esta partida no puede ser cancelada porque pertenece a una requisición con anticipo con abonos.');
                $('#b_cancelar_partida').prop('disabled',false);
            }

        });

        function existeCxpRequisicion(idRequisicion)
        { // verificando el cxp
            var dato = 0;

            $.ajax({
                type: 'POST',
                url: 'php/autorizar_buscar_cxp_requisicion.php',
                dataType:"json", 
                data:{'idRequisicion' : idRequisicion},
                async: false, //-->quita asincrono para que pueda returnar el valor cuando ya se haya terminado el proceso ajax
                success: function(data) {
                    dato = data;
                },
                error: function (xhr) {
                    console.log('autorizar_buscar_cxp_requisicion.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontro información al buscar si la requisición registro anticipo en cxp');
                }
            });

            return dato;
        }

        function limpiarBuscarOrden(idOrdenCompra)
        {
            var totalPendiente=0;
            $('#t_partidas >tbody tr').remove();
            $('#d_estatus').removeAttr('class');
            $('#d_estatus').text('').removeAttr('class');

            $.ajax({
                type: 'POST',
                url: 'php/orden_compra_buscar_detalle.php',
                dataType:"json", 
                data:{
                    'idOrdenCompra':idOrdenCompra
                },
                success: function(data)
                {
                    
                    totalPartidas = 0;
                    for(var i=0; data.length>i; i++)
                    {

                        var detalle = data[i];

                        totalPartidas++;
                        
                        var pendiente = (parseInt(detalle.cantidad) - parseInt(detalle.entregados));
                        if(detalle.estatus=='L')
                        pendiente=0;
                        var html = "<tr class='partida-orden' id_partida='" + detalle.id + "' >";
                        html += "<td>" + totalPartidas + "</td>";
                        html += "<td>" + detalle.familia + "</td>";
                        html += "<td>" + detalle.linea + "</td>";
                        html += "<td>" + detalle.concepto + "</td>";
                        html += "<td>" + detalle.descripcion + "</td>";
                        html += "<td align='right'>" + formatearNumero(detalle.costo) + "</td>";
                        html += "<td align='right'>" + detalle.cantidad + "</td>";
                        html += "<td align='right'>" + detalle.entregados + "</td>";
                        html += "<td align='right'>" + pendiente + "</td>";

                        if(detalle.estatus == 'C')
                            html += "<td colspan='2' valign='center'><h6><span class='badge badge-danger'>CANCELADA</span></h6></td>"
                        else
                        {


                           //--MGFS 27-01-2020 SE AGREGA VALIDACIÓN PARA QUE SOLO SE PUEDAN LIQUIDAR PARTIDAS QUE TIENEN PRODUCTO RECIBIDO 
                            if(detalle.estatus == 'I' && parseFloat(detalle.entregados)>0 && (parseFloat(detalle.cantidad) > parseFloat(detalle.entregados)))
                            {
                                totalPendiente++;
                                html += "<td colspan='2'><button type='button' class='btn btn-danger btn-sm form-control' id='b_cancelar_restante' alt='" + detalle.id + "' alt2='"+detalle.entregados+"'><i class='fa fa-list' aria-hidden='true'></i></button></td>"
                            }else{
                                if(detalle.estatus=='L'){
                                    html += "<td colspan='2' valign='center'><h6><span class='badge badge-warning'>LIQUIDADA</span></h6></td>";
                                }else{
                                    if(detalle.estatus == 'I' && (parseFloat(detalle.cantidad) == parseFloat(detalle.entregados))){
                                        html += "<td colspan='2' valign='center'><h6><span class='badge badge-success'>SURTIDA</span></h6></td>";
                                    }else{
                                        html += "<td colspan='2'><button type='button' class='btn btn-danger btn-sm form-control' id='b_cancelar_partida' alt='" + detalle.id + "' ><i class='fa fa-remove' aria-hidden='true'></i></button></td>";
                                    }
                                   
                                }
                            }

                        }


                        if(totalPendiente == 0 )
                            $('#b_cancelar').prop('disabled', true);

                        html += "</tr>";

                        $('#t_partidas tbody').append(html);
                    
                    }

         
                },
                error: function (xhr)
                {
                    console.log('php/orden_compra_buscar_detalle.php --> '+JSON.stringify(xhr));
                    mandarMensaje(xhr.responseText);
                }
            });

        }

        $('#b_buscar').click(function()
        {   
            muestraSelectUnidades(matriz, 's_filtro_unidad', idUnidadActual);
            muestraSucursalesPermiso('s_filtro_sucursal',idUnidadActual,modulo,idUsuario);
            $('#i_fecha_inicio').val('');
            $('#i_fecha_fin').val('');
            $('#dialog_ordenes_compra').modal('show');
            $('#t_ordenes_compra tbody').empty();

        });

        $(document).on('change','#s_filtro_unidad',function(){
            var idUnidad=$(this).val();
            if(idUnidad!= ''){
                $('.img-flag').css({'width':'50px','height':'20px'});
            }
            muestraSucursalesPermiso('s_filtro_sucursal',idUnidad,modulo,idUsuario);
            $('#i_filtro_2').val('');
            $('#i_fecha_inicio').val('');
            $('#i_fecha_fin').val('');
            $('.renglon_orden_compra').remove();
        });


        $('#i_fecha_inicio').change(function()
        {

            if($('#s_filtro_sucursal').val() > 0 || $('#s_filtro_sucursal').val() != null)
            {
                if($('#i_fecha_inicio').val() != '')
                {
                    $('#i_fecha_fin').prop('disabled',false);
                    buscarOrden();
                }
            }else
                mandarMensaje('Selecciona una sucursal');

        });

        $('#i_fecha_fin').change(function()
        {
            if($('#s_filtro_sucursal').val() > 0 || $('#s_filtro_sucursal').val() != null)
            {
                buscarOrden();
            }else
                mandarMensaje('Selecciona una sucursal');
        });


       $(document).on('change','#s_filtro_sucursal',function()
       {
            buscarOrden();
       });

       $('#b_cancelar').click(function(){

            var idOrdenCompra = $('#i_id_orden_compra').val();

            $.ajax({

                type: 'POST',
                url: 'php/orden_compra_buscar_requis_con_anticipos.php',
                data:{
                    'idOrdenCompra':idOrdenCompra
                },
                success: function(data)
                {console.log("resulado"+data);

                    if(parseInt(data) == 0)
                    {
                        $('#dialog_confirm').modal('show');
                    }else{
                        mandarMensaje('Esta orden no puede ser cancelada porque tiene requisiciones con anticipos y abonos en cxp');
                    }
                },
                error: function (xhr)
                {   
                    console.log('php/orden_compra_buscar_requis_con_anticipos.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al verificar anticipos de requisiciones de orden de compra.');
                }
            });

        });

       $('#b_cancelar_orden').click(function()
        {
            $('#b_cancelar').prop('disabled', true);
            var idOrdenCompra = $('#i_id_orden_compra').val();

            $.ajax({

                type: 'POST',
                url: 'php/orden_compra_cancelar.php',
                data:{
                    'id_orden_compra': idOrdenCompra,
                },
                success: function(data)
                {
                    console.log('data: '+data);
                    if(data == true)
                    {
                        mandarMensaje('La Orden de Compra se cancelo de Forma Correcta');
                        limpiarBuscarOrden(idOrdenCompra);
                        $('#b_cancelar').prop('disabled', true);
                        $('#d_estatus').addClass('alert alert-sm alert-danger').text('CANCELADA');
                        $('#dialog_confirm').modal('hide');
                    }else{
                        mandarMensaje('Error al cancelar la orden');
                        $('#b_cancelar').prop('disabled', false);
                        $('#dialog_confirm').modal('hide');
                    }

                },
                error: function (xhr) 
                {
                    console.log('php/orden_compra_cancelar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al cancelar la orden');
                    $('#b_cancelar').prop('disabled', false);
                }
            });

        });
        
    });

</script>

</html>