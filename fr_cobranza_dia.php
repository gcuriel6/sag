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
    <link href="vendor/font_awesome/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet">
    <link href="vendor/select2/css/select2.css" rel="stylesheet"/>
    <link href="css/general.css" rel="stylesheet"  type="text/css"/>
</head>

<style>
    #fondo_cargando{

        position: absolute;
        top: 1%;
        background-image:url('imagenes/3.svg');
        background-repeat:no-repeat;
        background-size: 500px 500px; 
        background-position:center;
        left: 1%;
        width: 98%;
        bottom:3%;
        border-radius: 5px;
        z-index:2000;
        display:none;
        
    }

    .modal-xl {
        max-width: 1140px;
    }

    #mapDetalleMonitoreo{
        height: 450px;
        width: 100%;
    }
</style>

<body class="mt-4">

    <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
        <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
        <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
        <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
        <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
    </form>

    <div class="container-fluid bg-white">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h1 class="h1">Cobranza del día</h1>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-center">
                                    <h2>Total del dia <span id="totalDia">XXX</span></h2>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-md-center">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="i_fecha_inicio">Fecha Inicio</label>
                                    <input type="date" class="form-control fecha" id="i_fecha_inicio">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="i_fecha_fin">Fecha Fin</label>
                                    <input type="date" class="form-control fecha" id="i_fecha_fin">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-md-center">
                            <div class="col-md-4">
                                <div class="btn-group w-100" role="group" aria-label="Basic example">
                                    <button class="btn btn-primary w-100" id="btnBuscar">Buscar</button>
                                    <button class="btn btn-success" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
                                    <button class="btn btn-warning" id="b_excel2"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Pendiente</button>
                                </div>
                                
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-12">
                                <input type="text" name="i_filtro_cxc" id="i_filtro_cxc" alt="renglon_cxc" class="filtrar_renglones form-control" placeholder="Filtrar" autocomplete="off">
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-hover " id="tableCotizaciones">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Cliente</th>
                                            <th scope="col">No. Cuenta</th>
                                            <th scope="col">Folio</th>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Saldo</th>
                                            <th scope="col">Telefono</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!--div_principal-->
    
</body>

<div class="modal" tabindex="-1" role="dialog" id="modalDetalleMonitoreo">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detalle Monitoreo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <!-- LAS NAVS -->
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-detalle-cuenta-tab" data-toggle="tab" href="#nav-detalle-cuenta" role="tab" aria-controls="nav-detalle-cuenta" aria-selected="true">Detalle Cuenta</a>
                    <a class="nav-item nav-link" id="nav-detalle-cobros-tab" data-toggle="tab" href="#nav-detalle-cobros" role="tab" aria-controls="nav-detalle-cobros" aria-selected="false">Detalle Cobros</a>
                    <a class="nav-item nav-link" id="nav-detalle-comentarios-tab" data-toggle="tab" href="#nav-detalle-comentarios" role="tab" aria-controls="nav-detalle-comentarios" aria-selected="false">Comentarios</a>
                    <a class="nav-item nav-link" id="nav-detalle-pagar-tab" data-toggle="tab" href="#nav-detalle-pagar" role="tab" aria-controls="nav-detalle-pagar" aria-selected="false">Registrar Pago</a>
                </div>
            </nav>

            <!-- CONTENIDO DE CADA NAV -->
            <div class="tab-content" id="nav-tabContent">
                <!-- PRIMERA TAB -->
                <div class="tab-pane show active" id="nav-detalle-cuenta" role="tabpanel" aria-labelledby="nav-detalle-cuenta">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtCuentaNombre">Cuenta</label>
                                <input type="text" class="form-control" id="txtCuentaNombre" readonly>
                            </div>
                            <div class="form-group">
                                <label for="txtCuentaNum">No. Cuenta</label>
                                <input type="text" class="form-control" id="txtCuentaNum" readonly>
                            </div>
                            <div class="form-group">
                                <label for="txtCuentaPlan">Plan</label>
                                <input type="text" class="form-control" id="txtCuentaPlan" readonly>
                            </div>
                            <div class="form-group">
                                <label for="txtCuentaTel">Telefono</label>
                                <input type="text" class="form-control" id="txtCuentaTel" readonly>
                            </div>
                            <div class="form-group">
                                <label for="txtCuentaDirec">Direccion</label>
                                <input type="text" class="form-control" id="txtCuentaDirec" readonly>
                            </div>
                            <div class="form-group">
                                <label for="txtCuentaCol">Colonia</label>
                                <input type="text" class="form-control" id="txtCuentaCol" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="mapDetalleMonitoreo"></div>   
                        </div>
                    </div>
                </div>
                <!-- SEGUNDA TAB -->
                <div class="tab-pane" id="nav-detalle-cobros" role="tabpanel" aria-labelledby="nav-detalle-cobros">
                    <table class="table table-hover " id="tableHistorialCuenta">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Fecha Corte</th>
                                <th scope="col">Fecha Captura</th>
                                <th scope="col">Fecha Pago</th>
                                <th scope="col">Importe</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- TERCERA TAB -->
                <div class="tab-pane" id="nav-detalle-comentarios" role="tabpanel" aria-labelledby="nav-detalle-comentarios">
                    <div class="form-group">
                        <label for="txtComentariosCuenta">Nuevo comentario</label>
                        <textarea class="form-control" id="txtComentariosCuenta" rows="3"></textarea>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-warning" id="btnGuardarComentario">Guardar</button>
                    </div>
                    <hr>
                    <table class="table table-hover " id="tableComentariosCuenta">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Usuario</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Comentario</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- CUARTA TAB -->
                <div class="tab-pane" id="nav-detalle-pagar" role="tabpanel" aria-labelledby="nav-detalle-pagar">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="txtImporte">Importe</label>
                                <input type="number" class="form-control" id="txtImporte">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="selTipo">Tipo</label>
                                <select class="form-control" id="selTipo">
                                    <option value="0" disabled selected>...</option>
                                    <option value="R">Recibo</option>
                                    <option value="F">Factura</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="selCuentaBanco">Cuenta de Banco</label>
                                <select class="form-control" id="selCuentaBanco">

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="selFormaPago">Forma de Pago</label>
                                <select class="form-control" id="selFormaPago">

                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="txtReferencia">Referencia</label>
                                <input type="text" class="form-control" id="txtReferencia">
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-success" id="btnGuardarPago">Aplicar Pago</button>
                    </div>
                </div>
            </div>

        </div>
        <!-- <div class="modal-footer">
            <button type="button" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div> -->
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modalDetalleInstalacion">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detalle Instalacion</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <!-- LAS NAVS -->
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-detalle-pdf-tab" data-toggle="tab" href="#nav-detalle-pdf" role="tab" aria-controls="nav-detalle-pdf" aria-selected="true">Detalle Cuenta</a>
                    <a class="nav-item nav-link" id="nav-detalle-pagar2-tab" data-toggle="tab" href="#nav-detalle-pagar2" role="tab" aria-controls="nav-detalle-pagar2" aria-selected="false">Registrar Pago</a>
                    <a class="nav-item nav-link" id="nav-detalle-comentarios2-tab" data-toggle="tab" href="#nav-detalle-comentarios2" role="tab" aria-controls="nav-detalle-comentarios2" aria-selected="false">Comentarios</a>
                </div>
            </nav>

            <!-- CONTENIDO DE CADA NAV -->
            <div class="tab-content" id="nav-tabContent2">
                <!-- PRIMERA TAB -->
                <div class="tab-pane show active" id="nav-detalle-pdf" role="tabpanel" aria-labelledby="nav-detalle-pdf">
                    <div class="row">
                        <div class="col-12">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" id="framePdf" src=""></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- TERCERA TAB -->
                <div class="tab-pane" id="nav-detalle-comentarios2" role="tabpanel" aria-labelledby="nav-detalle-comentarios2">
                    <div class="form-group">
                        <label for="txtComentariosCuenta2">Nuevo comentario</label>
                        <textarea class="form-control" id="txtComentariosCuenta2" rows="3"></textarea>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-warning" id="btnGuardarComentario2">Guardar</button>
                    </div>
                    <hr>
                    <table class="table table-hover " id="tableComentariosCuenta2">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Usuario</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Comentario</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- CUARTA TAB -->
                <div class="tab-pane" id="nav-detalle-pagar2" role="tabpanel" aria-labelledby="nav-detalle-pagar2">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="txtImporte2">Importe</label>
                                <input type="number" class="form-control" id="txtImporte2">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="selTipo2">Tipo</label>
                                <select class="form-control" id="selTipo2">
                                    <option value="0" disabled selected>...</option>
                                    <option value="R">Recibo</option>
                                    <option value="F">Factura</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="selCuentaBanco2">Cuenta de Banco</label>
                                <select class="form-control" id="selCuentaBanco2">

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="selFormaPago2">Forma de Pago</label>
                                <select class="form-control" id="selFormaPago2">

                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="txtReferencia2">Referencia</label>
                                <input type="text" class="form-control" id="txtReferencia2">
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-success" id="btnGuardarPago2">Aplicar Pago</button>
                    </div>
                </div>
            </div>

        </div>
        <!-- <div class="modal-footer">
            <button type="button" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div> -->
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modalDetalleServicio">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detalle de Servicio</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <!-- LAS NAVS -->
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-detalle-pdf2-tab" data-toggle="tab" href="#nav-detalle-pdf2" role="tab" aria-controls="nav-detalle-pdf2" aria-selected="true">Detalle Cuenta</a>
                    <a class="nav-item nav-link" id="nav-detalle-pagar3-tab" data-toggle="tab" href="#nav-detalle-pagar3" role="tab" aria-controls="nav-detalle-pagar3" aria-selected="false">Registrar Pago</a>
                    <a class="nav-item nav-link" id="nav-detalle-comentarios3-tab" data-toggle="tab" href="#nav-detalle-comentarios3" role="tab" aria-controls="nav-detalle-comentarios3" aria-selected="false">Comentarios</a>
                </div>
            </nav>

            <!-- CONTENIDO DE CADA NAV -->
            <div class="tab-content" id="nav-tabContent3">
                <!-- PRIMERA TAB -->
                <div class="tab-pane show active" id="nav-detalle-pdf2" role="tabpanel" aria-labelledby="nav-detalle-pdf2">
                    <div class="row">
                        <div class="col-12">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" id="framePdf2" src=""></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- TERCERA TAB -->
                <div class="tab-pane" id="nav-detalle-comentarios3" role="tabpanel" aria-labelledby="nav-detalle-comentarios3">
                    <div class="form-group">
                        <label for="txtComentariosCuenta3">Nuevo comentario</label>
                        <textarea class="form-control" id="txtComentariosCuenta3" rows="3"></textarea>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-warning" id="btnGuardarComentario3">Guardar</button>
                    </div>
                    <hr>
                    <table class="table table-hover " id="tableComentariosCuenta3">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Usuario</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Comentario</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- CUARTA TAB -->
                <div class="tab-pane" id="nav-detalle-pagar3" role="tabpanel" aria-labelledby="nav-detalle-pagar3">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="txtImporte3">Importe</label>
                                <input type="number" class="form-control" id="txtImporte3">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="selTipo3">Tipo</label>
                                <select class="form-control" id="selTipo3">
                                    <option value="0" disabled selected>...</option>
                                    <option value="R">Recibo</option>
                                    <option value="F">Factura</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="selCuentaBanco3">Cuenta de Banco</label>
                                <select class="form-control" id="selCuentaBanco3">

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="selFormaPago3">Forma de Pago</label>
                                <select class="form-control" id="selFormaPago3">

                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="txtReferencia3">Referencia</label>
                                <input type="text" class="form-control" id="txtReferencia3">
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-success" id="btnGuardarPago3">Aplicar Pago</button>
                    </div>
                </div>
            </div>

        </div>
        <!-- <div class="modal-footer">
            <button type="button" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div> -->
    </div>
  </div>
</div>

<div id="fondo_cargando"></div>

<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="vendor/select2/js/select2.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>

<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoD4mBMwf4boXGnAKMeC_-VK9NaON_W2w"
    defer
></script>

<script>

    var idUnidadActual = <?php echo $_SESSION['id_unidad_actual']; ?>;
    var idUsuario = <?php echo $_SESSION['id_usuario']; ?>;
    var modulo = 'REPORTES_GERENCIALES';
    var matriz = <?php echo $_SESSION['sucursales']; ?>;
    var months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    $(function(){

        // mostrarBotonAyuda(modulo);
        // muestraSelectUnidades(matriz, 's_id_unidad', idUnidadActual);
        // muestraSucursalesPermiso('s_id_sucursal', idUnidadActual,modulo,idUsuario);

        let yourDate = new Date();
        let mesActual = ('0' + (yourDate.getMonth()+1)).slice(-2);
        let anoActual = yourDate.getFullYear();
        let reporte="";

        let fechaInicio = anoActual+"-01-01";
        const fechaHoy = yourDate.toISOString().split('T')[0];
        
        $("#i_fecha_inicio").val(fechaInicio);
        $("#i_fecha_fin").val(fechaHoy);

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        });

        const traerCotizaciones = () => {
            const fechaInicio = $("#i_fecha_inicio").val();
            const fechaFin = $("#i_fecha_fin").val();

            $('#fondo_cargando').show();

            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_buscar.php',
                data:{   
                    fechaInicio,
                    fechaFin             
                },
                success: function(data){
                    let result = JSON.parse(data);
                    $("#tableCotizaciones tbody").html("");
                    let totalDia = 0;

                    const formatoMoneda = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' });

                    result.map(c=>{
                        let folio = "";
                        let tipo = "";
                        let button = "";

                        totalDia += parseFloat(c.total);

                        if(c.id_orden_servicio > 0){
                            folio = c.id_orden_servicio;
                            tipo = "Servicio";
                            button = `<button value="${c.id_orden_servicio}" idCotiz="${c.id}" class="btn btn-success btnDetallesServicio"><i class="fa fa-eye" aria-hidden="true"></i></button>`;
                        }
                        
                        if(c.folio_venta > 0){
                            folio = c.folio_venta;
                            tipo = "Instalacion";
                            button = `<button value="${c.id_venta}" idCotiz="${c.id}" class="btn btn-success btnDetallesInstalacion"><i class="fa fa-eye" aria-hidden="true"></i></button>`;
                        }

                        if(c.folio_recibo > 0){
                            folio = c.folio_recibo;
                            tipo = "Monitoreo";
                            button = `<button value="${c.id}" class="btn btn-success btnDetallesMonitoreo"><i class="fa fa-eye" aria-hidden="true"></i></button>`;
                        }

                        const row = `<tr class="renglon_cxc">
                                        <th scope="row">${c.nombre_corto}</th>
                                        <td>${c.cuenta}</td>
                                        <td>${folio}</td>
                                        <td>${tipo}</td>
                                        <th>${formatoMoneda.format(c.total)}</th>
                                        <td>${c.telefonos}</td>
                                        <td>${c.fecha}</td>
                                        <td>${button}</td>
                                    </tr>`;

                        $("#tableCotizaciones tbody").append(row);

                    });

                    $("#totalDia").html(formatoMoneda.format(totalDia));

                    $('#fondo_cargando').hide();

                    // initMap();

                },
                error: function (xhr){
                    console.log('php/cotizaciones_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('*Error en el sistema');
                }
            });
        }

        traerCotizaciones();

        $("body").on("click",".btnDetallesMonitoreo",function(){
            const idCotiz = $(this).val();
            abrirModalDetallesMonitoreo(idCotiz);
        });

        $("body").on("click", ".btnDetallesInstalacion", function(){
            const idCotiz = $(this).attr("idCotiz");
            const idVenta = $(this).val();
            abrirModalDetallesInstalacion(idCotiz, idVenta);
        });

        $("body").on("click", ".btnDetallesServicio", function(){
            const idCotiz = $(this).attr("idCotiz");
            const idServicio = $(this).val();
            abrirModalDetallesServicio(idCotiz, idServicio);
        });

        const abrirModalDetallesMonitoreo = idCotiz => {
            $('#fondo_cargando').show(); 

            const detalle = $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_buscar_cuenta.php',
                data:{idCotiz}
            });

            const historial = $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_buscar_cuenta_historial.php',
                data:{idCotiz}
            });

            const comentarios = $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_buscar_cuenta_comentarios.php',
                data:{idCotiz}
            });

            const formas = $.ajax({
                type: 'POST',
                url: 'php/combos_buscar.php',
                data:{
                    'tipoSelect' : 'CONCEPTOS_CXP_PAGOS',
                    "tipo": 5
                }
            });

            const cuentas = $.ajax({
                type: 'POST',
                url: 'php/cuentas_bancos_buscar_cuentas_por_unidad.php',
                data:{'idUnidadNegocio':2}
            });

            const peticiones = [detalle, historial, comentarios, formas, cuentas];

            $.when(...peticiones).then((d1, h1, c1, f1, c2)=>{
                const r1 = JSON.parse(d1[0]);
                const r2 = JSON.parse(h1[0]);
                const r3 = JSON.parse(c1[0]);
                const r4 = JSON.parse(f1[0]);
                const r5 = JSON.parse(c2[0]);

                $("#tableHistorialCuenta tbody").html("");
                $("#tableComentariosCuenta tbody").html("");
                $("#selFormaPago").html("<option value='0' disabled selected>...</option>");
                $("#selCuentaBanco").html("<option value='0' disabled selected>...</option>");

                $("#txtCuentaNombre").val(r1[0].cuentaNombre);
                $("#txtCuentaNum").val(r1[0].cuentaNum);
                $("#txtCuentaTel").val(r1[0].cuentaTel);
                $("#txtCuentaPlan").val(r1[0].cuentaPlan);
                $("#txtCuentaCol").val(r1[0].cuentaCol);
                $("#txtCuentaDirec").val(r1[0].cuentaDirec);

                $("#txtImporte").val(r1[0].importe);
                $("#txtImporte").attr('max', r1[0].importe);
                $("#txtImporte").attr('min', 0);

                r2.map(h=>{
                    const row = `<tr>
                                    <td>${h.fecha_corte_recibo}</td>
                                    <td>${h.fecha_captura}</td>
                                    <td>${h.fecha_pago}</td>
                                    <th>${h.importe}</th>
                                </tr>`;

                    $("#tableHistorialCuenta tbody").append(row);
                });

                r3.map(c=>{
                    const row = `<tr>
                                    <td>${c.usuario}</td>
                                    <td>${c.fecha}</td>
                                    <td>${c.comentario}</td>
                                </tr>`;

                    $("#tableComentariosCuenta tbody").append(row);
                });

                r4.map(f=>{
                    if(f.clave != "" && f.clave != 99){
                        $("#selFormaPago").append(`<option value="${f.id}">${f.concepto}</option>`);
                    }
                });

                r5.map(c=>{
                    //para que no agregue las opciones de caja chica
                    if(!c.descripcion.includes("Chica")){
                        $("#selCuentaBanco").append(`<option value="${c.id}">${c.descripcion}</option>`);
                    }
                });

                //Crear el mapa
                const LatLngDefault = { "lat": 28.63052782762811, "lng": -106.11877312264313 };
                const LatLngCliente = { "lat": r1[0].latitud, "lng": r1[0].longitud };

                const LatLng = LatLngCliente.lat != 0.000000000000000 ? LatLngCliente: LatLngDefault;

                const map = new google.maps.Map(document.getElementById("mapDetalleMonitoreo"), {
                    zoom: 14,
                    center: LatLng,
                    draggableCursor:'pointer'
                });
                
                let marker = new google.maps.Marker({
                    position: LatLng,
                    map,
                    title: "Secorp",
                });

                $('#fondo_cargando').hide(); 
                $("#modalDetalleMonitoreo").modal("toggle");
            });

            $("#btnGuardarComentario").val(idCotiz);
            $("#btnGuardarPago").val(idCotiz);
        }

        $("#btnGuardarComentario").on("click",function(){
            const idCotiz = $(this).val();

            const comentario = $("#txtComentariosCuenta").val();

            if(comentario==""){
                $("#txtComentariosCuenta").addClass("is-invalid");
                return;
            }

            $("#txtComentariosCuenta").removeClass("is-invalid");
            $(this).prop("disabled", true);

            const guardar = $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_guardar_cuenta_comentarios.php',
                data:{idCotiz, comentario}
            });

            guardar.then(res=>{
                if(res == 1){
                    $("#modalDetalleMonitoreo").modal("toggle");
                    // mandarMensaje("Comentario guardado correctamente");
                    $("#txtComentariosCuenta").val("");
                    abrirModalDetallesMonitoreo(idCotiz);
                    $(this).prop("disabled", false);
                }else{
                    mandarMensaje("Comentario no guardado");
                }
            })
            .catch(ex=>{
                console.log(ex);
            })
        });

        $("#btnGuardarPago").on("click",function(){
            const idCotiz = $(this).val();
            const importe = $("#txtImporte").val();
            const forma = $("#selFormaPago").val();
            const tipo = $("#selTipo").val();
            const cuenta = $("#selCuentaBanco").val();
            const referencia = $("#txtReferencia").val();

            if(importe == ""){
                $("#txtImporte").addClass("is-invalid");
                return;
            }

            if(forma == null){
                $("#selFormaPago").addClass("is-invalid");
                return;
            }

            if(tipo == null){
                $("#selTipo").addClass("is-invalid");
                return;
            }

            if(cuenta==null){
                $("#selCuentaBanco").addClass("is-invalid");
                return;
            }

            $("#txtImporte, #selFormaPago, #selTipo, #selCuentaBanco").removeClass("is-invalid");

            //deshabilitar boton para evitar multiple clicks
            $(this).prop("disabled", true);

            const data = {idCotiz, importe, forma, tipo, cuenta, referencia};

            const pagar = $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_pagar_cuenta.php',
                data
            });

            pagar.then(res=>{
                if(res>0){
                    //habilitar boton para evitar multiple clicks
                    $(this).prop("disabled", false);

                    $("#modalDetalleMonitoreo").modal("toggle");
                    mandarMensaje("Pago guardado correctamente.");
                    traerCotizaciones();
                }
            }).catch(e=>{
                console.log(e)
            })

        })

        $("#btnBuscar").on("click",()=>traerCotizaciones());

        const abrirModalDetallesInstalacion = (idCotiz, idVenta) => {
            $('#fondo_cargando').show(); 

            const detalle = $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_buscar_cuenta.php',
                data:{idCotiz}
            });

            const formas = $.ajax({
                type: 'POST',
                url: 'php/combos_buscar.php',
                data:{
                    'tipoSelect' : 'CONCEPTOS_CXP_PAGOS',
                    "tipo": 5
                }
            });

            const cuentas = $.ajax({
                type: 'POST',
                url: 'php/cuentas_bancos_buscar_cuentas_por_unidad.php',
                data:{'idUnidadNegocio':2}
            });

            const comentarios = $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_buscar_cuenta_comentarios.php',
                data:{idCotiz}
            });

            const peticiones = [detalle, formas, cuentas, comentarios];
            
            var datos = {
                'path':"formato_venta",
                'idRegistro':idVenta,
                'nombreArchivo':'venta',
                'tipo':1
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            $("#framePdf").attr("src", "php/convierte_pdf.php?D="+datosJ);

            $.when(...peticiones).then((d1, f1, c2, c3)=>{
                const r1 = JSON.parse(d1[0]);
                const r4 = JSON.parse(f1[0]);
                const r5 = JSON.parse(c2[0]);
                const r6 = JSON.parse(c3[0]);

                $("#selFormaPago2, #selCuentaBanco2").html("<option value='0' disabled selected>...</option>");

                $("#txtImporte2").val(r1[0].importe);
                $("#txtImporte2").attr('max', r1[0].importe);
                $("#txtImporte2").attr('min', 0);

                $("#tableComentariosCuenta2 tbody").html("");

                r4.map(f=>{
                    if(f.clave != "" && f.clave != 99){
                        $("#selFormaPago2").append(`<option value="${f.id}">${f.concepto}</option>`);
                    }
                });

                r5.map(c=>{
                    //para que no agregue las opciones de caja chica
                    if(!c.descripcion.includes("Chica")){
                        $("#selCuentaBanco2").append(`<option value="${c.id}">${c.descripcion}</option>`);
                    }
                });

                r6.map(c=>{
                    const row = `<tr>
                                    <td>${c.usuario}</td>
                                    <td>${c.fecha}</td>
                                    <td>${c.comentario}</td>
                                </tr>`;

                    $("#tableComentariosCuenta2 tbody").append(row);
                });

                $('#fondo_cargando').hide(); 

                $("#modalDetalleInstalacion").modal("toggle");
            }).catch(ex=>{
                console.log(ex)
            });

            $("#btnGuardarComentario2").val(idCotiz);
            $("#btnGuardarPago2").val(idCotiz);
        }

        $("#btnGuardarPago2").on("click",function(){
            const idCotiz = $(this).val();
            const importe = $("#txtImporte2").val();
            const forma = $("#selFormaPago2").val();
            const tipo = $("#selTipo2").val();
            const cuenta = $("#selCuentaBanco2").val();
            const referencia = $("#txtReferencia2").val();

            if(importe == ""){
                $("#txtImporte2").addClass("is-invalid");
                return;
            }

            if(forma == null){
                $("#selFormaPago2").addClass("is-invalid");
                return;
            }

            if(tipo == null){
                $("#selTipo2").addClass("is-invalid");
                return;
            }

            if(cuenta==null){
                $("#selCuentaBanco2").addClass("is-invalid");
                return;
            }

            $("#txtImporte2, #selFormaPago2, #selTipo2, #selCuentaBanco2").removeClass("is-invalid");

            //deshabilitar boton para evitar multiple clicks
            $(this).prop("disabled", true);

            const data = {idCotiz, importe, forma, tipo, cuenta, referencia};

            const pagar = $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_pagar_cuenta.php',
                data
            });

            pagar.then(res=>{
                if(res>0){
                    //habilitar boton para evitar multiple clicks
                    $(this).prop("disabled", false);

                    $("#modalDetalleInstalacion").modal("toggle");
                    mandarMensaje("Pago guardado correctamente.");
                    traerCotizaciones();
                }
            }).catch(e=>{
                console.log(e)
            })

        })

        const abrirModalDetallesServicio = (idCotiz, idServicio) => {
            $('#fondo_cargando').show(); 

            const detalle = $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_buscar_cuenta.php',
                data:{idCotiz}
            });

            const formas = $.ajax({
                type: 'POST',
                url: 'php/combos_buscar.php',
                data:{
                    'tipoSelect' : 'CONCEPTOS_CXP_PAGOS',
                    "tipo": 5
                }
            });

            const cuentas = $.ajax({
                type: 'POST',
                url: 'php/cuentas_bancos_buscar_cuentas_por_unidad.php',
                data:{'idUnidadNegocio':2}
            });

            const comentarios = $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_buscar_cuenta_comentarios.php',
                data:{idCotiz}
            });

            const peticiones = [detalle, formas, cuentas, comentarios];
            
            var datos = {
                'path':'formato_orden_servicio',
                'idRegistro':idServicio,
                'nombreArchivo':'orden_servicio',
                'tipo':1,
                'modulo':'orden_servicio'
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            $("#framePdf2").attr("src", "php/convierte_pdf.php?D="+datosJ);

            $.when(...peticiones).then((d1, f1, c2, c3)=>{
                const r1 = JSON.parse(d1[0]);
                const r4 = JSON.parse(f1[0]);
                const r5 = JSON.parse(c2[0]);
                const r6 = JSON.parse(c3[0]);

                $("#selFormaPago3, #selCuentaBanco3").html("<option value='0' disabled selected>...</option>");

                $("#txtImporte3").val(r1[0].importe);
                $("#txtImporte3").attr('max', r1[0].importe);
                $("#txtImporte3").attr('min', 0);

                $("#tableComentariosCuenta3 tbody").html("");

                r4.map(f=>{
                    if(f.clave != "" && f.clave != 99){
                        $("#selFormaPago3").append(`<option value="${f.id}">${f.concepto}</option>`);
                    }
                });

                r5.map(c=>{
                    //para que no agregue las opciones de caja chica
                    if(!c.descripcion.includes("Chica")){
                        $("#selCuentaBanco3").append(`<option value="${c.id}">${c.descripcion}</option>`);
                    }
                });

                r6.map(c=>{
                    const row = `<tr>
                                    <td>${c.usuario}</td>
                                    <td>${c.fecha}</td>
                                    <td>${c.comentario}</td>
                                </tr>`;

                    $("#tableComentariosCuenta3 tbody").append(row);
                });

                $('#fondo_cargando').hide(); 

                $("#modalDetalleServicio").modal("toggle");
            }).catch(ex=>{
                console.log(ex)
            });

            $("#btnGuardarPago3").val(idCotiz);
            $("#btnGuardarComentario3").val(idCotiz);
        }

        $("#btnGuardarPago3").on("click",function(){
            const idCotiz = $(this).val();
            const importe = $("#txtImporte3").val();
            const forma = $("#selFormaPago3").val();
            const tipo = $("#selTipo3").val();
            const cuenta = $("#selCuentaBanco3").val();
            const referencia = $("#txtReferencia3").val();

            if(importe == ""){
                $("#txtImporte3").addClass("is-invalid");
                return;
            }

            if(forma == null){
                $("#selFormaPago3").addClass("is-invalid");
                return;
            }

            if(tipo == null){
                $("#selTipo3").addClass("is-invalid");
                return;
            }

            if(cuenta==null){
                $("#selCuentaBanco3").addClass("is-invalid");
                return;
            }

            $("#txtImporte3, #selFormaPago3, #selTipo3, #selCuentaBanco3").removeClass("is-invalid");

            const data = {idCotiz, importe, forma, tipo, cuenta, referencia};

            //deshabilitar boton para evitar multiple clicks
            $(this).prop("disabled", true);

            const pagar = $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_pagar_cuenta.php',
                data
            });

            pagar.then(res=>{
                if(res>0){
                    //habilitar boton para evitar multiple clicks
                    $(this).prop("disabled", false);

                    $("#modalDetalleServicio").modal("toggle");
                    mandarMensaje("Pago guardado correctamente.");
                    traerCotizaciones();
                }
            }).catch(e=>{
                console.log(e)
            })

        })

        $("#txtImporte3, #txtImporte2, #txtImporte").on("keyup", function(){
            const min = $(this).attr("min");
            const max = $(this).attr("max");
            const val = $(this).val();

            if(val > max){
                $(this).val(max);
            }

            if(val < min){
                $(this).val(0);
            }
        });

        $('#b_excel').click(function(){
            const fechaInicio = $('#i_fecha_inicio').val();
            const fechaFin = $('#i_fecha_fin').val();
            
            var datos = {
                fechaInicio,
                fechaFin
            };

            $("#i_nombre_excel").val('Reporte Cobranza');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val('REPORTE_COBRANZA_DIA');
            $('#i_datos_excel').val(JSON.stringify(datos));

            $("#f_imprimir_excel").submit();
        });

        $('#b_excel2').click(function(){
            const fechaInicio = $('#i_fecha_inicio').val();
            const fechaFin = $('#i_fecha_fin').val();
            
            var datos = {
                fechaInicio,
                fechaFin
            };

            $("#i_nombre_excel").val('Reporte Cobranza');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val('REPORTE_COBRANZA_DIA_COMPLETO');
            $('#i_datos_excel').val(JSON.stringify(datos));

            $("#f_imprimir_excel").submit();
        });

        $("#btnGuardarComentario2").on("click",function(){
            const idCotiz = $(this).val();

            const comentario = $("#txtComentariosCuenta2").val();

            if(comentario==""){
                $("#txtComentariosCuenta2").addClass("is-invalid");
                return;
            }

            $("#txtComentariosCuenta2").removeClass("is-invalid");
            $(this).prop("disabled", true);

            const guardar = $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_guardar_cuenta_comentarios.php',
                data:{idCotiz, comentario}
            });

            $("#modalDetalleInstalacion").modal("toggle");

            guardar.then(res=>{
                if(res == 1){
                    // $("#modalDetalleInstalacion").modal("toggle");
                    // mandarMensaje("Comentario guardado correctamente");
                    $("#txtComentariosCuenta2").val("");
                    abrirModalDetallesInstalacion(idCotiz);
                    $(this).prop("disabled", false);
                }else{
                    mandarMensaje("Comentario no guardado");
                }
            })
            .catch(ex=>{
                console.log(ex);
            })
        });

        $("#btnGuardarComentario3").on("click",function(){
            const idCotiz = $(this).val();

            const comentario = $("#txtComentariosCuenta3").val();

            if(comentario==""){
                $("#txtComentariosCuenta3").addClass("is-invalid");
                return;
            }

            $("#txtComentariosCuenta3").removeClass("is-invalid");
            $(this).prop("disabled", true);

            const guardar = $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_guardar_cuenta_comentarios.php',
                data:{idCotiz, comentario}
            });

            $("#modalDetalleServicio").modal("toggle");

            guardar.then(res=>{
                if(res == 1){
                    // $("#modalDetalleServicio").modal("toggle");
                    // mandarMensaje("Comentario guardado correctamente");
                    $("#txtComentariosCuenta3").val("");
                    abrirModalDetallesServicio(idCotiz);
                    $(this).prop("disabled", false);
                }else{
                    mandarMensaje("Comentario no guardado");
                }
            })
            .catch(ex=>{
                console.log(ex);
            })
        });

        // function initMap() {
        //     const myLatLng = { "lat": 28.63052782762811, "lng": -106.11877312264313 };
        //     const map = new google.maps.Map(document.getElementById("mapDetalleMonitoreo"), {
        //         zoom: 14,
        //         center: myLatLng,
        //         draggableCursor:'pointer'
        //     });

        //     let marker = new google.maps.Marker({
        //         position: myLatLng,
        //         map,
        //         title: "Secorp",
        //     });
        //     // Configure the click listener.
        //     // map.addListener("click", (mapsMouseEvent) => {
        //     //     // Close the current InfoWindow.
        //     //     marker.setMap(null);
        //     //     // Create a new InfoWindow.
        //     //     marker = new google.maps.Marker({
        //     //         position: mapsMouseEvent.latLng,
        //     //         title: JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
        //     //     });

        //     //     console.log(JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2));
        //     //     marker.setMap(map);
        //     //     // infoWindow.setContent(
        //     //     //     JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
        //     //     // );
        //     //     // infoWindow.open(map);
        //     // });
        // }

        // window.initMap = initMap;

    });

</script>

</html> 