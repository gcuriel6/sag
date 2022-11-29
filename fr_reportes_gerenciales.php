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

    #d_estatus{
       padding-top:7px;
       text-align:center;
       font-weight:bold;
       font-size:15px;
       height:40px;
       vertical-align:middle;
   }

   #dialog_buscar_requisiciones > .modal-lg{
        min-width: 80%;
        max-width: 80%;
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
        #dialog_buscar_requisiciones > .modal-lg{
            max-width: 100%;
        }
    }
    
</style>

<body>
    <div class="container-fluid bg-white">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Reporte Gerencial</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="s_id_unidad" class="col-sm-2 col-md-12 col-form-label requerido">Unidad de Negocio </label>
                                    <select id="s_id_unidad" name="s_id_unidad" class="form-control validate[required]" autocomplete="off"></select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="s_id_sucursal" class="col-sm-2 col-md-6 col-form-label ">Sucursal </label>
                                    <select id="s_id_sucursal" name="s_id_sucursal" class="form-control validate[required]" autocomplete="off"></select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="i_fecha_inicio" class="col-sm-6 col-md-8 col-form-label">Fecha Inicial</label>
                                    <input type="text" id="i_fecha_inicio" name="i_fecha_inicio" class="form-control fecha" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="i_fecha_fin" class="col-sm-6 col-md-8 col-form-label">Fecha Final</label>
                                    <input type="text" id="i_fecha_fin" name="i_fecha_fin" class="form-control fecha" autocomplete="off"/>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="i_anio" class="col-sm-2 col-md-6 col-form-label">Año </label>
                                    <input type="text" id="i_anio" name="i_anio" class="form-control izquierda validate[required,custom[integer],minSize[4],maxSize[4]]" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="s_mes_inicial" class="col-sm-6 col-md-8 col-form-label">Mes Inicial</label>
                                    <select  id="s_mes_inicial" name="s_mes_inicial" class="form-control validate[required]" autocomplete="off"/></select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="s_mes_final" class="col-sm-6 col-md-8 col-form-label">Mes Final</label>
                                    <select  id="s_mes_final" name="s_mes_final" class="form-control validate[required]" autocomplete="off"/></select>
                                </div>
                            </div>
                        </div> -->

                        <?php
                            //GCM - 26/Abril/2022 se agrega arreglo de personas que pueden ver ciertos botones en este pantalla
                            $puedenVerBotones = [
                                7, //Mabel Barrera
                                404, //Gabriel Curiel
                                316, //Hannali Limas
                                4, //Emanuel Garcia
                                11, //Anabel Erives
                                313, //Pedro Hernandez
                                531, //JIGA
                            ];
                        ?>
                        <div class="row">
                            <div class="col-md-3">
                                <button class="btn btn-primary btn-lg w-100" id="btnGenerarGraficaUnidad">Egresos por Unidad</button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary btn-lg w-100" id="btnGenerarGraficaFamilia">Egresos por Familia</button>
                            </div>
                            <!-- <div class="col-md-3">
                                <button class="btn btn-primary btn-lg w-100" id="btnGenerarGraficaClasificacion">Egresos por Clasificacion</button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary btn-lg w-100" id="btnGenerarGraficaDiario">Egresos Diario</button>
                            </div> -->
                            <?php
                            if(in_array($_SESSION["id_usuario"],$puedenVerBotones)){
                            ?>
                                <div class="col-md-3">
                                    <button class="btn btn-success btn-lg w-100" id="btnGenerarGraficaBancos">Saldos Bancos</button>
                                </div>
                            <?php        
                            }else{
                                //usuario de Cynthia Mora
                                if($_SESSION["id_usuario"]==3){
                                ?>
                                    <div class="col-md-3">
                                        <button class="btn btn-success btn-lg w-100" id="btnGenerarGraficaBancos">Saldos Bancos</button>
                                    </div>
                                <?php
                                }
                            }
                            ?>
                            
                            <div class="col-md-3">
                                <button class="btn btn-success btn-lg w-100" id="btnGenerarGraficaFacDiaria">Facturacion Mensual</button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-success btn-lg w-100" id="btnGenerarGraficaIngCxc">Ingresos CXC</button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-success btn-lg w-100" id="btnGenerarGraficaIngEgr">Ingresos VS Egresos</button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-success btn-lg w-100" id="btnGenerarGraficaSinTomate">Ingresos por Unidad</button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary btn-lg w-100" id="btnGenerarGraficaSinCebolla">Egresos por Unidad</button>
                            </div>
                        </div>
                        <div class="row">
                            <?php
                            if(in_array($_SESSION["id_usuario"],$puedenVerBotones)){
                            ?>
                                <div class="col-md-3">
                                    <button class="btn btn-danger btn-lg w-100" id="btnGenerarGraficaFacCanceladas">Facs Canceladas</button>
                                </div>
                            <?php        
                            }
                            ?>
                            <div class="col-md-3">
                                <button class="btn btn-warning btn-lg w-100" id="btnGenerarGraficaOficialesDob">Oficiales Doblados</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-center"><h2 id="tituloGrafica"></h2></div>
                            </div>
                        </div>
                        <div id="areaChart">
                            <div class="row">
                                <div class="col-12">
                                    <div height="500" style="max-height:500px;height:500px;width:100%;">
                                        <canvas id="myChart" height="500" style="width:100%;display:block;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="areaTabla">
                            <table id="tablaReportes" class="table table-hover table-bordered mt-3">
                                <thead class="thead-dark"></thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!--div_principal-->
    
</body>

<div id="dialog_mostrar_detalle_grafica" class="modal fade" tabindex="-1" role="dialog" style="overflow-x:auto; max-width:100%;">
  <div class="modal-dialog modal-lg" style="overflow-x:auto; max-width:3600px; width:3600px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span id="tituloModalDetalleGrafica"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <input type="text" name="i_filtro_tabla" id="i_filtro_tabla" alt="renglon_tabla" class="filtrar_renglones form-control" placeholder="Filtrar" autocomplete="off">
            </div>
        </div>   
        <div class="row">
            <div class="col-12">
                <table style="width:100%" class="table table-sm" id="t_detalle_grafica">
                    <thead class="thead-dark"><tr></tr></thead>
                    <tbody></tbody>
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

<div id="dialog_mostrar_detalle_grafica2" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span id="tituloModalDetalleGrafica2"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <input type="text" name="i_filtro_tabla2" id="i_filtro_tabla2" alt="renglon_tabla2" class="filtrar_renglones form-control" placeholder="Filtrar" autocomplete="off">
            </div>
        </div>   
        <div class="row">
            <div class="col-12">
                <table style="width:100%" class="table table-sm" id="t_detalle_grafica2">
                    <thead class="thead-dark"><tr></tr></thead>
                    <tbody></tbody>
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

<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="vendor/select2/js/select2.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>

<script>

    var idUnidadActual = <?php echo $_SESSION['id_unidad_actual']; ?>;
    var idUsuario = <?php echo $_SESSION['id_usuario']; ?>;
    var modulo = 'REPORTES_GERENCIALES';
    var matriz = <?php echo $_SESSION['sucursales']; ?>;
    var months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    $(function(){

        mostrarBotonAyuda(modulo);
        muestraSelectUnidades(matriz, 's_id_unidad', idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursal', idUnidadActual,modulo,idUsuario);

        // generaFecha('s_mes_inicial');
        // generaFecha('s_mes_final');
        // $("#i_anio").val(new Date().getFullYear() );

        //variable global para reutilizar el canvas
        let myChart;
        let yourDate = new Date();
        let mesActual = yourDate.getMonth() + 1;
        let anoActual = yourDate.getFullYear();
        let reporte="";
        
        $("#i_fecha_inicio").val(yourDate.getFullYear()+"-"+mesActual+"-"+"01");
        $("#i_fecha_fin").val(yourDate.toISOString().split('T')[0]);

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        });

        // $('#b_excel_acumulado').click(function()
        // {

        //     var html = '';
        //     var aux = new Date();
        //     var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
            
        //     var datos = 
        //     {
        //         'id_unidad': $("#s_id_unidad").val(),
        //         'id_sucursal': $("#s_id_sucursal").val(),
        //         'id_producto': $("#i_id_producto").val(),
        //         'id_familia': $('#i_familia_filtro').attr('alt'),
        //         'id_linea': $('#i_linea_filtro').attr('alt'),
        //         'fecha_de': $("#i_fecha_de").val(),
        //         'fecha_a': $("#i_fecha_a").val()
        //     };

        //     $('#i_nombre_excel').val('ACUMULADO');
        //     $('#i_fecha_excel').val(hoy);
        //     $('#i_modulo_excel').val('INVENTARIO_ACUMULADO');
        //     $('#i_datos_excel').val(JSON.stringify(datos));
            
        //     $("#f_imprimir_excel").submit();

        // });

        function traerReportes(tipo){
            // var tipo=$('input[name=radio_tipo]:checked').val();

            let label1="Ejercido";
            let label2="Presupuesto";
            $("#tituloGrafica").text("");
            $("#areaChart").prop("hidden", false);
            // $("#areaTabla").prop("hidden", true);
            $("#areaTabla").prop("hidden", false);
            headersTabla = ["Familia", "Presupuesto", "Ejercido", "Porcentaje"];
            
            switch(tipo){
                case 1:
                    reporte='familia';
                    $("#tituloGrafica").text("REPORTE POR FAMILIA");
                    break;
                case 2:
                    reporte='clasificacion';
                    $("#tituloGrafica").text("REPORTE POR CLASIFICACION");
                    break;
                case 3:
                    reporte='diario';
                    $("#tituloGrafica").text("REPORTE DIARIO");
                    break;
                case 4:
                    reporte='unidad';
                    headersTabla = ["Unidad", "Presupuesto", "Ejercido", "Porcentaje"];
                    $("#tituloGrafica").text("REPORTE POR UNIDAD");
                    break;
                case 5:
                    reporte="bancos";
                    label1="Saldo Actual";
                    label2="Saldo Inicial";
                    headersTabla = ["Banco", "Saldo Actual", "Saldo Inicial", "Administrador"];
                    $("#tituloGrafica").text("SALDOS BANCOS");
                    $("#areaChart").prop("hidden", true);
                    break;
                case 6:
                    reporte="facDiaria";
                    label1="Periodo";
                    label2="En Mes";
                    headersTabla = ["Sucursal", "En Mes", "Periodo"];
                    $("#tituloGrafica").text("FACTURACION POR MES");
                    break;
                case 7:
                    reporte="ingCxc";
                    label1="Ingresado";
                    label2="";
                    headersTabla = ["Sucursal", "Ingresado"];
                    $("#tituloGrafica").text("INGRESOS CXC");
                    break;
                case 8:
                    reporte="ingVSegr";
                    label1="Ingresos";
                    label2="Egresos";
                    headersTabla = ["Unidad", "Egresos", "Ingresos", "Fondeo"];
                    $("#tituloGrafica").text("INGRESOS VS EGRESOS");
                    break;
                case 9:
                    reporte="oficialesDob";
                    $("#tituloGrafica").text("OFICIALES DOBLADOS");
                    label1="Cantidad";
                    label2="";
                    headersTabla = ["Departamento", "Sucursal", "#", "Nombre", "Incidencia", "Inc Aux", "Fecha"];
                    break;
                case 10:
                    reporte="facCanceladas";
                    label1="Monto";
                    label2="";
                    headersTabla = ["Sucursal", "Monto", "Fecha", "Cliente","Folio"];
                    $("#tituloGrafica").text("FACTURAS CANCELADAS");
                    break;
            }

            if(reporte==""){
                mandarMensaje("No hay formato seleccionado");
                return;
            }

            var idUnidad =  $('#s_id_unidad').val();

            if($('#s_id_sucursal').val() >= 1)
                var idSucursal = $('#s_id_sucursal').val();
            else
                var idSucursal = muestraSucursalesPermisoListaId($('#s_id_unidad').val(),modulo,idUsuario);

            var fechaInicial = $('#i_fecha_inicio').val();
            var fechaFinal = $('#i_fecha_fin').val();

            var datos={
                idUnidad,
                idSucursal,
                fechaInicial,
                fechaFinal,
            };

            // console.log(JSON.stringify(datos));
            $.ajax({

                type: 'POST',
                url: 'php/presupuesto_egresos_seguimiento_grafica.php',
                data:
                {   
                    'reporte':reporte,
                    'datos':datos                    
                },
                success: function(data)
                {
                    let obj = JSON.parse(data);

                    if(obj.length > 0){
                        let labels = [];
                        let ejercido = [];
                        let presupuesto = [];
                        let rows = [];
                        let fechaAnterior = "";
                        let botonesConPorcentajeRojo = [1,4];
                        let totalesEjercido = 0;
                        let totalesPresupuesto = 0;
                        let porcentaje = "";
                        let userAnterior = "";
                        let totalAnterior1 = 0;
                        let totalAnterior2 = 0;
                        //labels = arreglo de strings
                        //ejercido y presupuesto = arreglo nums
                        $.each(obj,function( index, value ) {
                            // console.log(value);

                            // console.log(tipo);
                            switch(tipo){
                                case 5:
                                    if(value.FAMILIA != "TOTAL"){
                                        if(value.usuario == userAnterior){
                                            // userAnterior = value.usuario;
                                            totalAnterior1 += Number(value.PRESUPUESTO);
                                            totalAnterior2 += Number(value.EJERCIDO);
                                        }else{

                                            if(userAnterior != ""){
                                                t1 = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(totalAnterior1);
                                                t2 = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(totalAnterior2);
                                                
                                                rows.push(["<b>TOTAL</b>", `<b>${t2}</b>`, `<b>${t2}</b>`, `<b>${userAnterior}</b>`]);
                                            }

                                            userAnterior = value.usuario;
                                            totalAnterior1 = Number(value.PRESUPUESTO);
                                            totalAnterior2 = Number(value.EJERCIDO);
                                        }

                                        labels.push(value.FAMILIA);
                                        ejercido.push(value.EJERCIDO);
                                        presupuesto.push(value.PRESUPUESTO);
                                        totalesEjercido += parseInt(value.EJERCIDO);
                                        totalesPresupuesto += parseInt(value.PRESUPUESTO);


                                        ejer = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(value.EJERCIDO);
                                        pres = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(value.PRESUPUESTO);

                                        rows.push([value.FAMILIA, ejer, pres, value.usuario]);

                                    }
                                    if(index == obj.length - 1){

                                        if(userAnterior != ""){
                                            t1 = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(totalAnterior1);
                                            t2 = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(totalAnterior2);

                                            rows.push(["<b>TOTAL</b>", `<b>${t2}</b>`, `<b>${t1}</b>`, `<b>${userAnterior}</b>`]);
                                        }

                                        tot1 = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(totalesPresupuesto);
                                        tot2 = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(totalesEjercido);
                                        rows.push(["<b>TOTAL</b>", `<b>${tot2}</b>`, `<b>${tot1}</b>`, ""]);
                                    }
                                    break;
                                case 6:
                                    if(value.FAMILIA != "TOTAL"){
                                        labels.push(value.FAMILIA);
                                        ejercido.push(value.EJERCIDO);
                                        presupuesto.push(value.PRESUPUESTO);                                        
                                    }

                                    ejer = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(value.EJERCIDO);
                                    pres = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(value.PRESUPUESTO);

                                    rows.push([value.FAMILIA, pres, ejer]);
                                    break;
                                case 7:
                                    //["Sucursal", "Ingresado", "Porcentaje"];
                                    labels.push(value.FAMILIA);
                                    ejercido.push(value.EJERCIDO);
                                    presupuesto.push(value.PRESUPUESTO);

                                    ejer = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(value.EJERCIDO);
                                    
                                    rows.push([value.FAMILIA, ejer]);
                                    break;
                                case 8:
                                    labels.push(value.FAMILIA);
                                    ejercido.push(value.EJERCIDO);
                                    presupuesto.push(value.PRESUPUESTO);


                                    ejer = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(value.EJERCIDO);
                                    pres = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(value.PRESUPUESTO);
                                    fond = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(value.FONDEO);

                                    rows.push([value.FAMILIA, pres, ejer, fond]);
                                    break;
                                case 9:
                                    if(value.fecha==fechaAnterior){
                                        let buscarFecha = (element) => element == fechaAnterior;
                                        let index = labels.findIndex(buscarFecha);

                                        let contador = ejercido[index];
                                        ejercido[index] = contador+1;

                                    }else{
                                        labels.push(value.fecha);
                                        ejercido.push(1);

                                        fechaAnterior = value.fecha;
                                    }

                                    rows.push([value.depto, value.sucursal, value.id, value.empleado, value.incidencia, value.incidencia_aux, value.fecha]);
                                    break;
                                case 10:
                                    //["Sucursal", "Monto", "Fecha", "Cliente","Folio"];
                                    labels.push(value.FAMILIA);
                                    ejercido.push(value.EJERCIDO);
                                    presupuesto.push(value.PRESUPUESTO);

                                    ejer = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(value.EJERCIDO);

                                    rows.push([value.FAMILIA, ejer, value.FECHA, value.CLIENTE, value.FOLIO]);
                                    break;
                                default:
                                    if(value.FAMILIA != "TOTAL"){
                                        labels.push(value.FAMILIA);
                                        ejercido.push(value.EJERCIDO);
                                        presupuesto.push(value.PRESUPUESTO);
                                        
                                    }

                                    porcentaje = "NA";

                                    if(value.PRESUPUESTO != 0 && value.EJERCIDO != 0){
                                        let porciento = ((value.EJERCIDO / value.PRESUPUESTO)*100).toFixed(2);
                                        
                                        if(botonesConPorcentajeRojo.includes(tipo)){
                                            if(porciento > 100){
                                                porcentaje = `<span class="text-danger">${porciento}%</span>`
                                            }else{
                                                porcentaje = `${porciento}%`;
                                            } 
                                        }else{
                                            porcentaje = `${porciento}%`;
                                        }                                           
                                    }

                                    ejer = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(value.EJERCIDO);
                                    pres = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(value.PRESUPUESTO);

                                    rows.push([value.FAMILIA, pres, ejer, porcentaje]);
                                    break;
                            }
                        });
                        generarGrafica(labels, ejercido, label1, presupuesto, label2, tipo, obj);
                        generarTabla(headersTabla, rows);
                    }else{
                        mandarMensaje("No hay informacion en ese rango de fechas");
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/presupuesto_egresos_segumiento_grafica.php-->'+JSON.stringify(xhr));
                    mandarMensaje('*Error en el sistema');
                }
            });
        }

        function traerReportesModal(tipo, id){

            reporteModal = "";
            
            switch(tipo){
                case 3:
                    reporteModal='diario';
                    $("#tituloModalDetalleGrafica").text("REPORTE DIARIO");
                    break;
            }

            if(reporteModal==""){
                mandarMensaje("No hay formato seleccionado");
                return;
            }

            var idUnidad =  $('#s_id_unidad').val();

            if($('#s_id_sucursal').val() >= 1)
                var idSucursal = $('#s_id_sucursal').val();
            else
                var idSucursal = muestraSucursalesPermisoListaId($('#s_id_unidad').val(),modulo,idUsuario);

            var fechaInicial = $('#i_fecha_inicio').val();
            var fechaFinal = $('#i_fecha_fin').val();

            var datos={
                idUnidad,
                idSucursal,
                fechaInicial,
                fechaFinal,
                id
            };

            // console.log(JSON.stringify(datos));
            $.ajax({

                type: 'POST',
                url: 'php/presupuesto_egresos_seguimiento_grafica.php',
                data:{   
                    'reporte':reporteModal,
                    'datos':datos                    
                },
                success: function(data){
                    let obj = JSON.parse(data);

                    if(obj.length > 0){
                        let headers = Object.keys(obj[0]);
                        $("#t_detalle_grafica thead tr").html("");
                        $("#t_detalle_grafica tbody").html("");
                        $.each(headers,function(index, value){
                            $("#t_detalle_grafica thead tr").append(`<th>${value}</th>`);
                        });
                        $.each(obj,function(index, value){
                            let html = `<tr class="renglon_tabla">`;

                            $.each(value,function(i, v){
                                html += `<td>${v}</td>`;
                            });

                            html +=`</tr>`;
                            $("#t_detalle_grafica tbody").append(html);
                        });
                    }else{
                        mandarMensaje("No hay informacion en ese rango de fechas");
                    }

                    $("#dialog_mostrar_detalle_grafica").modal("toggle");
                },
                error: function (xhr){
                    console.log('php/presupuesto_egresos_segumiento_grafica.php-->'+JSON.stringify(xhr));
                    mandarMensaje('*Error en el sistema');
                }
            });
        }

        function traerReportesMeses(tipo){

            reporteModal = "";
            let meses = mesActual;
            $("#areaChart").prop("hidden", false);
            $("#areaTabla").prop("hidden", true);

            switch(tipo){
                case 1:
                    reporteModal='especial';
                    $("#tituloGrafica").text("INGRESOS POR UNIDAD");
                    break;
                case 2:
                    reporteModal='especial2';
                    $("#tituloGrafica").text("EGRESOS POR UNIDAD");
                    break;
            }

            if(reporteModal==""){
                mandarMensaje("No hay formato seleccionado");
                return;
            }

            var idUnidad =  $('#s_id_unidad').val();

            var fechaInicial = $('#i_fecha_inicio').val();
            var fechaFinal = $('#i_fecha_fin').val();

            let fechaSeleccionada = new Date(fechaInicial);

            if(fechaSeleccionada.getFullYear() != anoActual){
                meses = 12;
            }

            var datos={
                idUnidad,
                fechaInicial,
                fechaFinal
            };

            // console.log(JSON.stringify(datos));
            $.ajax({

                type: 'POST',
                url: 'php/presupuesto_egresos_seguimiento_grafica.php',
                data:
                {   
                    'reporte':reporteModal,
                    'datos':datos                    
                },
                success: function(data)
                {
                    let obj = JSON.parse(data);

                    if(obj.length > 0){
                        let unidadAnterior = 0;
                        let objetoDatasets = [];
                        let labels = months.slice(0, meses);

                        $.each(obj,function(index, value){
                            if(value.MES != 0){
                            
                                if(value.ID != unidadAnterior){

                                    let labelActual = "";
                                    let valoresUnidadActualIng = [];
                                    let valoresUnidadActualEgr = [];

                                    let filtrados = obj.filter(x => x.ID == value.ID);

                                    for (let i = 1; i <= meses; i++) {
                                        let filtradoSolo = filtrados.filter(x => x.MES == i);
                                        if(filtradoSolo.length > 0){
                                            labelActual = filtradoSolo[0].UNIDAD;
                                            valoresUnidadActualIng.push(filtradoSolo[0].INGRESOS);
                                            valoresUnidadActualEgr.push(filtradoSolo[0].EGRESOS);
                                        }else{
                                            valoresUnidadActualIng.push(0);
                                            valoresUnidadActualEgr.push(0);
                                        }                                        
                                    }

                                    let r = randomBetween(0, 255);
                                    let g = randomBetween(0, 255);
                                    let b = randomBetween(0, 255);

                                    let color1 = [r,g,b];

                                    let dataset = {
                                                        label: labelActual,
                                                        data: valoresUnidadActualIng,
                                                        backgroundColor: [`rgba(${color1[0]}, ${color1[1]}, ${color1[2]}, 0.4)`],
                                                        borderColor: [`rgba(${color1[0]}, ${color1[1]}, ${color1[2]}, 1)`],
                                                        // stack: 'combined'
                                                    };

                                    objetoDatasets.push(dataset);

                                    // r = randomBetween(0, 255);
                                    // g = randomBetween(0, 255);
                                    // b = randomBetween(0, 255);

                                    // color1 = [r,g,b];

                                    // dataset = {
                                    //                     label: labelActual,
                                    //                     data: valoresUnidadActualEgr,
                                    //                     backgroundColor: [`rgba(${color1[0]}, ${color1[1]}, ${color1[2]}, 0.4)`],
                                    //                     borderColor: [`rgba(${color1[0]}, ${color1[1]}, ${color1[2]}, 1)`],
                                    //                     type: 'bar'
                                    //                 };

                                    // objetoDatasets.push(dataset);
                                }
                            }
                            unidadAnterior = value.ID;
                        });

                        const canvas = document.getElementById('myChart');
                        const ctx = canvas.getContext("2d");
                        if (myChart) {
                            myChart.destroy();
                        }
                        myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels,
                                datasets: objetoDatasets
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        // stacked: true,
                                        beginAtZero: true,
                                        ticks: {
                                            // Include a dollar sign in the ticks
                                            callback: function(value, index, ticks) {
                                                let cadena = Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(value);
                                                // if(tiposNoMoneda.includes(tipo)){
                                                //     cadena = value;
                                                // }
                                                return cadena;
                                            }
                                        }
                                    }
                                },
                                // interaction: {
                                //     intersect: false,
                                //     mode: 'index',
                                // }
                            }
                        });
                        myChart.resize();
                        
                    }else{
                        mandarMensaje("No hay informacion en ese rango de fechas");
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/presupuesto_egresos_segumiento_grafica.php-->'+JSON.stringify(xhr));
                    mandarMensaje('*Error en el sistema');
                }
            });
        }
        
        $("#btnGenerarGraficaUnidad").on("click",()=>{
            traerReportes(4);
        });
        $("#btnGenerarGraficaFamilia").on("click",()=>{
            traerReportes(1);
        });
        $("#btnGenerarGraficaClasificacion").on("click",()=>{
            traerReportes(2);
        });
        $("#btnGenerarGraficaDiario").on("click",()=>{
            traerReportes(3);
        });
        $("#btnGenerarGraficaBancos").on("click",()=>{
            traerReportes(5);
        });
        $("#btnGenerarGraficaFacDiaria").on("click",()=>{
            traerReportes(6);
        });
        $("#btnGenerarGraficaIngCxc").on("click",()=>{
            traerReportes(7);
        });
        $("#btnGenerarGraficaIngEgr").on("click",()=>{
            traerReportes(8);
        });
        $("#btnGenerarGraficaOficialesDob").on("click",()=>{
            traerReportes(9);
        });
        $("#btnGenerarGraficaSinTomate").on("click",()=>{
            traerReportesMeses(1);
        });
        $("#btnGenerarGraficaSinCebolla").on("click",()=>{
            traerReportesMeses(2);
        });
        $("#btnGenerarGraficaFacCanceladas").on("click",()=>{
            traerReportes(10);
        });

        const randomBetween = (min, max) => min + Math.floor(Math.random() * (max - min + 1));

        function generarGrafica(labels, ejercido, label1, presupuesto, label2, tipo, objOriginal){
            
            let tiposNoMoneda = [9];
            let tiposNoPorcentaje = [6, 7];

            let r = randomBetween(0, 255);
            let g = randomBetween(0, 255);
            let b = randomBetween(0, 255);

            let color1 = [r,g,b];

            r = randomBetween(0, 255);
            g = randomBetween(0, 255);
            b = randomBetween(0, 255);

            let color2 = [r,g,b];
            // console.log(labels);
            // console.log(ejercido);
            // console.log(presupuesto);
            const canvas = document.getElementById('myChart');
            const ctx = canvas.getContext("2d");
            if (myChart) {
                myChart.destroy();
            }

            let datasets = [{
                                label: label1,
                                data: ejercido,
                                backgroundColor: [`rgba(${color1[0]}, ${color1[1]}, ${color1[2]}, 0.2)`],
                                borderColor: [`rgba(${color1[0]}, ${color1[1]}, ${color1[2]}, 1)`],
                                borderWidth: 2,
                                stack: 'combined'
                            }];

            if(label2 != ""){
                datasets.push({
                                label: label2,
                                data: presupuesto,
                                backgroundColor: [`rgba(${color2[0]}, ${color2[1]}, ${color2[2]}, 0.2)`],
                                borderColor: [`rgba(${color2[0]}, ${color2[1]}, ${color2[2]}, 1)`],
                                borderWidth: 2,
                                // stack: 'combined',
                                type: 'bar'
                            });
            }

            myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            // stacked: true,
                            beginAtZero: true,
                            ticks: {
                                // Include a dollar sign in the ticks
                                callback: function(value, index, ticks) {
                                    let cadena = Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(value);
                                    if(tiposNoMoneda.includes(tipo)){
                                        cadena = value;
                                    }
                                    return cadena;
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    plugins: {
                        tooltip: {
                            // displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    let cadena = "";

                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        if(tiposNoMoneda.includes(tipo)){
                                            label += context.parsed.y;
                                        }else{
                                            label += new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(context.parsed.y);
                                        }                                        
                                    }
                                    return label;
                                },
                                footer:(tooltipItems) => {
                                    // let sum = 0;
                                    // console.log(tooltipItems);
                                    // tooltipItems.forEach(function(tooltipItem) {
                                    //     // console.log(tooltipItem.parsed.y)
                                    //     sum += tooltipItem.parsed.y;
                                    // });
                                    // return 'Sum: ' + sum;
                                    if(!tiposNoPorcentaje.includes(tipo)){
                                        let ej = tooltipItems[0].parsed.y;
                                        let pr = 0;

                                        if(tooltipItems[1] != undefined){
                                            pr = tooltipItems[1].parsed.y;
                                        }                                    

                                        if(ej != 0 && pr != 0){
                                            return "Porcentaje: " + ((ej / pr) * 100).toFixed(2) + "%";
                                        }
                                        return "Porcentaje: NA";
                                    }
                                }
                            }
                        }
                    }
                }
            });
            myChart.resize();

            if(tipo != 9){
                if(presupuesto.length  == 0){
                    myChart.data.datasets.pop();
                    myChart.update();
                }
            }

            canvas.onclick = function(e){

                const points = myChart.getElementsAtEventForMode(e, 'nearest', { intersect: false }, true);
                if(points.length > 0){
                    const index = points[0].index;

                    // console.log(labels[index]);
                    // console.log(ejercido[index]);
                    // console.log(presupuesto[index]);
                    // console.log(objOriginal[index]);
                    let click = objOriginal[index];

                    if(click != undefined){
                        switch(reporte){
                            case "familia":
                                traerReportesModal(3, click.id_fam);
                                //se mostrara clasificacion y diario
                                break;
                            case "bancos":
                                //mostrar el desglose del saldo
                                break;
                            case "ingCxc":
                                //Mostrar facturas pagadas y pendiente
                                break;
                            case "ingVSegr":
                                //ingresos y egresos agrupados por mes
                                break;
                            case "facDiaria":
                                traerDetalleModal(4, click.id_sucursal);
                                break;
                            
                        }
                    }                    
                }
            };
        }

        function generarTabla(headersTabla, rows){
            const cantidadHeaders = headersTabla.length;
            const cantidadRows = rows.length;
            if(cantidadRows==0){
                $("#tablaReportes thead, #tablaReportes tbody").html("");
                return;
            }

            if(cantidadHeaders > 0){
                $("#tablaReportes thead, #tablaReportes tbody").html("");
                $("#tablaReportes thead").html("<tr></tr>");
                let filas = "";

                for (let i = 0; i < cantidadHeaders; ++i) {
                    const element = headersTabla[i];
                    $("#tablaReportes thead tr").append(`<th>${element}</th>`);
                }

                for (let j = 0; j < cantidadRows; j++) {
                    const fila = rows[j];
                    filas += `<tr>`;

                    $.each(fila, function( index, value ) {
                        if(value == "TOTAL"){
                            filas += `<th>${value}</th>`;
                        }else{
                            filas += `<td>${value}</td>`;
                        }
                    });

                    filas += `</tr>`;
                }

                $("#tablaReportes tbody").html(filas);
            }
        }

        $('#s_id_unidad').change(function(){
            //muestraSucursalesAcceso('s_id_sucursal',$('#s_id_unidad').val(),idUsuario);
            muestraSucursalesPermiso('s_id_sucursal', $('#s_id_unidad').val(), "SEGUIMIENTO_EGRESOS",idUsuario); 
            //$('#s_id_area').val('').select2({placeholder: ''}).prop('disabled',true);
            //$('#s_id_departamento').val('').select2({placeholder: ''}).prop('disabled',true);
            $('.img-flag').css({'width':'50px','height':'20px'});
        });

        $('#s_mes_inicial').on('change',function(){
            var valor=$(this).val();

            generaFecha('s_mes_final');
            $('#s_mes_final').val(valor);
        });

        function traerDetalleModal(tipo, id){

            reporteModal = "";

            switch(tipo){
                case 4:
                    reporteModal='detalleFacSuc';
                    $("#tituloModalDetalleGrafica2").text("DETALLE FACTURAS EN SUCURSAL");
                    break;
            }

            if(reporteModal==""){
                mandarMensaje("No hay formato seleccionado");
                return;
            }

            var idUnidad =  $('#s_id_unidad').val();

            if($('#s_id_sucursal').val() >= 1)
                var idSucursal = $('#s_id_sucursal').val();
            else
                var idSucursal = muestraSucursalesPermisoListaId($('#s_id_unidad').val(),modulo,idUsuario);

            var fechaInicial = $('#i_fecha_inicio').val();
            var fechaFinal = $('#i_fecha_fin').val();

            var datos={
                idUnidad,
                idSucursal,
                fechaInicial,
                fechaFinal,
                id
            };

            // console.log(JSON.stringify(datos));
            $.ajax({

                type: 'POST',
                url: 'php/presupuesto_egresos_seguimiento_grafica.php',
                data:{   
                    'reporte':reporteModal,
                    'datos':datos                    
                },
                success: function(data){
                    let obj = JSON.parse(data);

                    if(obj.length > 0){
                        let headers = Object.keys(obj[0]);
                        $("#t_detalle_grafica2 thead tr").html("");
                        $("#t_detalle_grafica2 tbody").html("");
                        $.each(headers,function(index, value){
                            $("#t_detalle_grafica2 thead tr").append(`<th>${value}</th>`);
                        });
                        $.each(obj,function(index, value){
                            let html = `<tr class="renglon_tabla2">`;

                            $.each(value,function(i, v){
                                html += `<td>${v}</td>`;
                            });

                            html +=`</tr>`;
                            $("#t_detalle_grafica2 tbody").append(html);
                        });
                    }else{
                        mandarMensaje("No hay informacion en ese rango de fechas");
                    }

                    $("#dialog_mostrar_detalle_grafica2").modal("toggle");
                },
                error: function (xhr){
                    console.log('php/presupuesto_egresos_segumiento_grafica.php-->'+JSON.stringify(xhr));
                    mandarMensaje('*Error en el sistema');
                }
            });
        }

    });

</script>

</html> 