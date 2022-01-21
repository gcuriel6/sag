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
    .popover-title {
        background-color: #002699; 
        color: #FFFFFF; 
        font-size: 8px;
        text-align:center;
    }

    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_t_registros{
            height:auto;
            overflow-x:none;
        }
        #div_principal{
            margin-left:0%;
        }
    }

    .popover-title {
        background-color: #002699; 
        color: #FFFFFF; 
        font-size: 13px;
        text-align:center;
    }

    .popover-content {
	  max-height: 300px;
	  min-height: 40px;
	  overflow-y: scroll;
	 }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-11" id="div_contenedor">
            <br>
                <div class="form-group row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">REPORTE COTIZACIONES VENTAS</div>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-2">
                        <!--<button type="button" class="btn btn-info btn-sm form-control"  id="b_pdf" disabled><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</button>-->
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel" disabled><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <input type="text" name="i_filtro" id="i_filtro" alt="renglon_registros" class="form-control form-control-sm filtrar_renglones" placeholder="Filtrar" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <label for="s_id_sucursales_filtro" class="col-sm-2 col-md-1 col-form-label">Sucursal </label>
                    <div class="col-sm-3 col-md-3">
                        <select id="s_id_sucursales_filtro" name="s_id_sucursales_filtro" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="row">
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
                                <input type="text" name="i_fecha_fin" id="i_fecha_fin" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                                <div class="input-group-addon input_group_span">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                       
                </div>

                <div class="row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>
                <br>

                <div class="row" id="div_resgitros">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Sucursal</th>
                                    <th scope="col" width="5%">Folio</th>
                                    <th scope="col">Movimiento</th>
                                    <!--<th scope="col">Tipo</th>-->
                                    <th scope="col">Folio Cotización</th>
                                    <th scope="col">Fecha Captura</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Vendedor</th>
                                    <th scope="col">Importe Cotizado</th>
                                    <th scope="col">Precio Venta Sin Iva</th>
                                    <th scope="col">Precio Última Compra</th>
                                    <th scope="col">Descuento</th>
                                    <th scope="col">Importe Instalación</th>
                                    <th scope="col">Importe Admin</th>
                                    <th scope="col">Importe Comisión</th>
                                    <th scope="col">Usuario Captura</th>
                                    <th scope="col">Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                    
                            </tbody>
                        </table>
                        <div id="div_t_registros">
                            <table class="tablon"  id="t_registros">
                                <tbody></tbody>
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
  
    var modulo='REPORTE_COTIZACIONES_VENTAS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;

    var matriz = <?php echo $_SESSION['sucursales']?>;
    $(function(){

        muestraSucursalesPermiso('s_id_sucursales_filtro',idUnidadActual,modulo,idUsuario);
        mostrarBotonAyuda(modulo);
        $('[data-toggle="popover"]').popover(); 
      
        mostrarRegistros(primerDiaMes,ultimoDiaMes);
            
        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        });

        $('#i_fecha_inicio').val(primerDiaMes);
        $('#i_fecha_fin').val(ultimoDiaMes);

        $('#i_fecha_inicio').change(function(){
            
            if($('#i_fecha_inicio').val() == '')
            {
                $('#i_fecha_inicio').val(primerDiaMes);
    
                mostrarRegistros(primerDiaMes,$('#i_fecha_fin').val());
            }else{

                mostrarRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
            }
            
        });

        $('#i_fecha_fin').change(function(){
            
            if($('#i_fecha_fin').val() == '')
            {
                $('#i_fecha_fin').val(ultimoDiaMes);
                
                mostrarRegistros($('#i_fecha_inicio').val(),ultimoDiaMes);
            }else{
                
                mostrarRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
            }
           
        });

        //-->NJES October/20/2020 agregar filtro se sucursal
        $('#s_id_sucursales_filtro').change(function(){
            mostrarRegistros($('#i_fecha_inicio').val(),$('#i_fecha_fin').val())
        });

        function mostrarRegistros(fechaInicio,FechaFin){
            $('.renglon_registros').remove();

            if($('#s_id_sucursales_filtro').val() != null)
                var idSucursal = $('#s_id_sucursales_filtro').val();
            else
                var idSucursal = muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario);

            var info = {'fechaInicio':fechaInicio,
                        'fechaFin':FechaFin,
                        'reporte':'cotizaciones_ventas',
                        'idSucursal':idSucursal
                    };
           
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_ventas_alarmas_reporte.php',
                dataType:"json", 
                data:  {
                    'datos':info
                },
                success: function(data) {
                    console.log(data);
                    if(data.length != 0){
                        
                        var num=data.length;
                        for(var i=0;data.length>i;i++){
                            ///llena la tabla con renglones de registros
                            
                            var html='<tr class="renglon_registros">\
                                        <td aling="top" data-label="Sucursal" width="5%">'+data[i].sucursal+'</td>\
                                        <td aling="top" data-label="Folio" width="5%">'+data[i].folio+'</td>\
                                        <td aling="top" data-label="Movimiento">'+data[i].movimiento+'</td>\
                                        <td aling="top" data-label="Folio Cotización">'+data[i].folio_cotizacion+'</td>\
                                        <td aling="top" data-label="Fecha Captura">'+data[i].fecha_captura+'</td>\
                                        <td aling="top" data-label="Cliente">'+data[i].cliente+'</td>\
                                        <td aling="top" data-label="Vendedor">'+data[i].vendedor+'</td>\
                                        <td aling="top" data-label="Importe Cotizado">'+formatearNumero(data[i].importe_cotizado)+'</td>\
                                        <td aling="top" data-label="Precio Venta Sin Iva">'+formatearNumero(data[i].precio_venta)+'</td>\
                                        <td aling="top" data-label="Precio Última Compra">'+formatearNumero(data[i].precio_ultima_compra)+'</td>\
                                        <td aling="top" data-label="Descuento">'+formatearNumero(data[i].descuento)+'</td>\
                                        <td aling="top" data-label="Importe Instalación">'+formatearNumero(data[i].costo_instalacion)+'</td>\
                                        <td aling="top" data-label="Importe Admin">'+formatearNumero(data[i].costo_administrativo)+'</td>\
                                        <td aling="top" data-label="Importe Comisión">'+formatearNumero(data[i].comision_venta)+'</td>\
                                        <td aling="top" data-label="Usuario Captura">'+data[i].usuario_captura+'</td>\
                                        <td aling="top" data-label="Estatus">'+data[i].estatus+'</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            
                            $('#t_registros tbody').append(html);                             
                        }

                        $('#b_excel').prop('disabled',false);

                    }else{
                        $('#b_excel').prop('disabled',true);

                        var html='<tr class="renglon_registros">\
                                        <td colspan="16">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros tbody').append(html);

                    }
                },
                error: function (xhr) 
                {
                    console.log('php/cotizaciones_ventas_alarmas_reporte.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar reporte cotizaciones ventas');
                }
            });
        }

    

        $('#b_excel').click(function(){

            if($('#i_fecha_inicio').val() != '')
            {
                var fechaInicio = $('#i_fecha_inicio').val();
            }else{
                var fechaInicio = primerDiaMes;
            }

            if($('#i_fecha_fin').val() != '')
            {
                var fechaFin = $('#i_fecha_fin').val();
            }else{
                var fechaFin = ultimoDiaMes;
            }
            
            var datos = {
                'idSucursal':$('#s_id_sucursales_filtro').val(),
                'fechaInicio':fechaInicio,
                'fechaFin':fechaFin
            };
            
            $("#i_nombre_excel").val('Reporte Cotizaciones Ventas Alarmas');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(datos));
            
            $("#f_imprimir_excel").submit();
        });
        
    });

</script>

</html>