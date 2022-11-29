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

    #fondo_cargando{
        position: absolute;
        background-image:url('imagenes/3.svg');
        background-repeat:no-repeat;
        background-size: 500px 500px; 
        background-position:center;
        left: 1%;
        width: 98%;
        bottom:1%;
        border-radius: 5px;
        z-index:2000;
        display:none;
    }
    
</style>

<body>

    <div id="fondo_cargando"></div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Reportes de Bancos</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="s_cuenta">Cuenta de Banco</label>
                                    <select class="form-control" id="s_cuenta">
                                    </select>
                                    <small class="form-text text-muted">Por default se muestran todas las cuentas.</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="i_fecha_inicio">Fecha de Inicio</label>
                                    <input type="text" class="form-control fecha" id="i_fecha_inicio" autocomplete="off">
                                    <small class="form-text text-muted">Si no hay fecha seleccionada se mostrara el mes actual.</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="i_fecha_fin">Fecha de Fin</label>
                                    <input type="text" class="form-control fecha" id="i_fecha_fin" autocomplete="off">
                                    <small class="form-text text-muted">Si no hay fecha seleccionada se mostrara el mes actual.</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-success" type="button" id="btn_filtrar_reportes">Filtrar</button>
                            </div>
                            <div class="col">
                                <button class="btn btn-success" type="button" id="btn_excel">Excel</button>
                            </div>
                            <div class="col">
                                <button class="btn btn-danger" type="button" id="btn_limpiar">Limpiar</button>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-sm table-hover table-bordered" id="t_reportes_bancos">
                                    <!-- <thead>
                                        <th>Sucursal</th>
                                        <th>Folio OC</th>
                                        <th>Folio Req</th>
                                        <th>Fecha</th>
                                        <th>Cuenta</th>
                                        <th>Descripcion</th>
                                        <th>Banco</th>
                                        <th>Ingreso</th>
                                        <th>Egreso</th>
                                        <th>Movimiento</th>
                                        <th>Observaciones</th>
                                        <th>Folio Fac</th>
                                        <th>Folio Pago</th>
                                        <th>Folio Gasto</th>
                                        <th>Folio Viatico</th>
                                    </thead> -->
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div> <!--div_principal-->

    <div class="formExcel" hidden>
        <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
            <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
            <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
            <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
            <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
        </form>
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
  
    var modulo='REPORTES_BANCOS_TODOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var nombreReporte='';

    var matriz = <?php echo $_SESSION['sucursales']?>;
    $(function(){
        // mostrarBotonAyuda(modulo);
        buscaMovimientosBancos(0);
        buscaCuentasBancos();

        function buscaMovimientosBancos(idCuenta){

            $('#fondo_cargando').show();

            let fechaI = $("#i_fecha_inicio").val();
            let fechaF = $("#i_fecha_fin").val();

            let detalle = $.ajax({
                type: 'POST',
                url: 'php/movimientos_reportes_buscar_detalle.php',
                data:{idCuenta, fechaF, fechaI}
            });

            let saldo = $.ajax({
                type: 'POST',
                url: 'php/cuentas_bancos_saldos.php',
                data:{idCuenta, fechaF, fechaI}
            });

            $.when(detalle, saldo).done((de,sa)=>{
                let detalles = de[0];
                let saldos = JSON.parse(sa[0]);

                $("#t_reportes_bancos tbody").html("");
                   
                if(detalles != ''){
                    let json = JSON.parse(detalles);

                    let thead = `<tr class="table-secondary">
                                    <th>Sucursal</th>
                                    <th>Folio OC</th>
                                    <th>Folio Req</th>
                                    <th>Fecha</th>
                                    <th>Fecha Aplic</th>                                    
                                    <th>Cuenta</th>
                                    <th>Descripcion</th>
                                    <th>Banco</th>
                                    <th>Ingreso</th>
                                    <th>Egreso</th>
                                    <th>Movimiento</th>
                                    <th>Observaciones</th>
                                    <th>Folio Fac</th>
                                    <th>Folio Pago</th>
                                    <th>Folio Gasto</th>
                                    <th>Folio Viatico</th>
                                </tr>`;

                    //Se le habia puesto que anterior inicia en 0 pero si hay cuenta 0.
                    let idCuentaAnterior = "NINGUNA";

                    $.each(json,(k,v)=>{

                        if(v.id_cuenta_banco != idCuentaAnterior){
                            idCuentaAnterior = v.id_cuenta_banco;
                            let filtrado = saldos.find(x=>x.id_cuenta_banco == idCuentaAnterior);

                            if(filtrado!=undefined){
                                let titulos = `<tr class="table-success">
                                                <th colspan="3">Descripcion</th>
                                                <th colspan="3">Cuenta</th>
                                                <th colspan="3">Ingreso</th>
                                                <th colspan="3">Egreso</th>
                                                <th colspan="4">Saldo</th>
                                            </tr>
                                            <tr class="table-success">
                                                <th colspan="3">${filtrado.descripcion}</th>
                                                <th colspan="3">${filtrado.cuenta}</th>
                                                <th colspan="3">${filtrado.ingresos}</th>
                                                <th colspan="3">${filtrado.egresos}</th>
                                                <th colspan="4">${filtrado.saldo}</th>
                                            </tr>`;

                                $("#t_reportes_bancos tbody").append(titulos);
                                $("#t_reportes_bancos tbody").append(thead);     
                            }else{
                                console.log("No hay cuenta: "+idCuentaAnterior)
                            }
                        }

                        let row = `<tr>
                                        <td>${v.sucursal}</td>
                                        <td>${v.folio_oc}</td>
                                        <td>${v.folio_requi}</td>
                                        <td>${v.fecha}</td>
                                        <td>${v.fecha_aplicacion}</td>                                        
                                        <td>${v.cuenta}</td>
                                        <td>${v.descripcion}</td>
                                        <td>${v.banco}</td>
                                        <td>${v.montoIngreso}</td>
                                        <td>${v.montoEgreso}</td>
                                        <td>${v.movimiento}</td>
                                        <td>${v.observaciones}</td>
                                        <td>${v.folio_factura}</td>
                                        <td>${v.folio_pago}</td>
                                        <td>${v.folio_gasto}</td>
                                        <td>${v.folio_viatico}</td>
                                    </tr>`;

                        $("#t_reportes_bancos tbody").append(row);
                    });
                    $('#fondo_cargando').hide();
                }else{
                    mandaMensaje("No hay detalles para mostrar");
                }
            });
        }

        function buscaCuentasBancos(){

            $.ajax({
                type: 'POST',
                url: 'php/cuentas_banco_buscar.php',
                success: function(data){
                    $("#s_cuenta").html("<option value='0' selected>...</option>")
                
                    if(data != ''){
                        let json = JSON.parse(data);
                        $.each(json,(k,v)=>{
                            $("#s_cuenta").append(`<option value="${v.id}">${v.descr}</option>`)
                        });
                    }

                    $("#s_cuenta").select2();
                },
                error: function (xhr){
                    console.log('php/cuentas_banco_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de bancos');
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

        $('#btn_excel').click(function(){

            let yourDate = new Date();            
            
            var datos = 
            {
                "fechaI" : $("#i_fecha_inicio").val(),
                "fechaF" : $("#i_fecha_fin").val(),
                "idCuenta" : $("#s_cuenta").val(),
            };

            $('#i_nombre_excel').val('REPORTES_BANCOS_TODOS2');
            $('#i_fecha_excel').val(yourDate.toISOString().split('T')[0]);
            $('#i_modulo_excel').val('REPORTES_BANCOS_TODOS2');
            $('#i_datos_excel').val(JSON.stringify(datos));
            
            $("#f_imprimir_excel").submit();

        });

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        });

        $("#btn_filtrar_reportes").on("click", ()=>{
            let idCuenta = $("#s_cuenta").val();

            buscaMovimientosBancos(idCuenta);
        });

        $("#btn_limpiar").on("click",()=>{
            $("#i_fecha_inicio").val("");
            $("#i_fecha_fin").val("");
            $("#s_cuenta").val(-1).trigger('change');
            buscaMovimientosBancos(0);
        });

        $("#i_fecha_inicio").on("change",()=>{
            let yourDate = new Date()            

            $("#i_fecha_fin").val(yourDate.toISOString().split('T')[0]);
        });
        
    });

</script>

</html>