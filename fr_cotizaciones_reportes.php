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
    #div_t_cotizaciones{
        min-height:290px;
        max-height:290px;
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

    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_t_cotizaciones{
            height:auto;
            overflow:auto;
        }
        #div_principal{
            margin-left:0%;
        }
    }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-11" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Reporte Cotizaciones</div>
                    </div>
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-12 col-md-4">
                    </div>
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-12 col-md-3">
                        <button type="button" class="btn btn-success btn-sm form-control verificar_permiso" alt="BOTON_EXCEL_COTIZACIONES_REPORTES" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                    </div>
                </div>

                
                <div class="row">
                    <div class="col-md-3">
                        <br>
                        <input type="text" name="i_filtro_cotizaciones" id="i_filtro_cotizaciones" alt="renglon_cotizaciones" class="form-control filtrar_renglones" placeholder="Filtrar">
                    </div>
            
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">Del: </div>
                                    <div class="input-group col-sm-12 col-md-12">
                                        <input type="text" name="i_fecha_inicio" id="i_fecha_inicio" class="form-control fecha" autocomplete="off" readonly>
                                        <div class="input-group-addon input_group_span">
                                            <span class="input-group-text">
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">Al: </div>
                                <div class="input-group col-sm-12 col-md-12">
                                    <input type="text" name="i_fecha_fin" id="i_fecha_fin" class="form-control fecha" autocomplete="off" readonly disabled>
                                    <div class="input-group-addon input_group_span">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon">
                    <thead>
                        <tr class="renglon">
                        <th scope="col">Folio</th>
                        <th scope="col">Cotización</th>
                        <th scope="col">Versión</th>
                        <th scope="col">Fecha<br> Creación</th>
                        <th scope="col">Proyecto</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Sucursal</th>
                        <th scope="col">Unidad Negocio</th>
                        <th scope="col">Costo Total</th>
                        <th scope="col">Precio de Venta Total</th>
                        <th scope="col">Porcentaje Utilidad</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Estatus Cotización</th>
                        <th scope="col">Estatus Proyecto</th>
                        <th scope="col">Justificación<br>Rechazo</th>
                        </tr>
                    </thead>
                    </table> 
                    <div id="div_t_cotizaciones">
                        <table class="tablon"  id="t_cotizaciones">
                            <tbody>
                                
                            </tbody>
                        </table>  
                    </div> 
                    <br><br> 
                    <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
                    <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
                    <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
                    <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
                    <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
                </form> 
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
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
  
    var modulo='COTIZACIONES_REPORTES';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var nombreReporte='';

    var matriz = <?php echo $_SESSION['sucursales']?>;
    $(function(){

        mostrarBotonAyuda(modulo);
       
        $('#i_fecha_inicio').val(primerDiaMes);
        $('#i_fecha_fin').val(ultimoDiaMes);

        $('#i_fecha_inicio,#i_fecha_fin').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        });

      
        buscarCotizacionesReportes();

        $('#i_fecha_inicio').change(function(){
            if($('#i_fecha_inicio').val() != '')
            {
                
                buscarCotizacionesReportes();
                $('#i_fecha_fin').prop('disabled',false);
                
            }
        });

        $('#i_fecha_fin').change(function(){
           
            buscarCotizacionesReportes();
            
        });

        /******* Busca todas las cotixzaciones mediante filtros ingresados*********/
        function buscarCotizacionesReportes(){
            $('.renglon_cotizaciones').remove();
            var datos={
                'fechaInicio':$('#i_fecha_inicio').val(),
                'fechaFin':$('#i_fecha_fin').val()
            };
            
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_buscar_reporte.php',
                dataType:"json", 
                data:{'datos':datos},
                success: function(data) {
                    console.log('resultado:'+data);    
                    $('.renglon_cotizaciones').remove();

                    if(data.length != 0){
                        console.log(JSON.stringify(data));
                   
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var activo='';
                            
                            if(parseInt(data[i].estatus_cotizacion) == 1){

                                activo='Activa';
                            }else{
                                activo='Impresa';
                            }

                            //-->NJES December/15/2020 agregar campos en reporte de cotizaciones
                            var prorrateoMensual = parseFloat(data[i].inversion_secorp)/12;
                            var costoUnico = parseFloat(prorrateoMensual)+parseFloat(data[i].costo_total);
                            var precio = parseFloat(data[i].precio_total)+parseFloat(data[i].inversion_cliente);
                            
                            if(parseFloat(costoUnico) == 0)
                                var prorrteo = (parseFloat(precio)*100)/1;
                            else
                                var prorrteo = (parseFloat(precio)*100)/parseFloat(costoUnico); 
                            
                            if(parseFloat(costoUnico) == 0)
                                var porcentaje_utilidad = 0;
                            else
                                var porcentaje_utilidad = parseFloat(prorrteo)-100;

                            var html='<tr class="renglon_cotizaciones" alt="'+data[i].id+'">\
                                        <td data-label="Folio">' + data[i].folio+ '</td>\
                                        <td data-label="Cotizacion">' + data[i].cotizacion+ '</td>\
                                        <td data-label="Version">' + data[i].version+ '</td>\
                                        <td data-label="Fecha Creacion">' + data[i].fecha_creacion+ '</td>\
                                        <td data-label="Proyecto">' + data[i].proyecto+ '</td>\
                                        <td data-label="Cliente">' + data[i].cliente+ '</td>\
                                        <td data-label="Sucursal">' + data[i].sucursal+ '</td>\
                                        <td data-label="Unidad Negocio">' + data[i].unidad_negocio+ '</td>\
                                        <td data-label="Costo Total">'+formatearNumero(data[i].costo_total)+'</td>\
                                        <td data-label="Precio de Venta Total">'+formatearNumero(data[i].precio_total)+'</td>\
                                        <td data-label="Porcentaje Utilidad">'+formatearNumero(porcentaje_utilidad)+'%</td>\
                                        <td data-label="Usuario">' + data[i].usuario+ '</td>\
                                        <td data-label="Estatus Cotizacion">' + activo+ '</td>\
                                        <td data-label="Estatus Proyecto">' + data[i].estatus_proyecto+ '</td>\
                                        <td data-label="Estatus Proyecto">' + data[i].justificacion_rechazada+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_cotizaciones tbody').append(html);   
 
                        }
                    }else{

                        //mandarMensaje('No se encontraron cotizaciones con esos datos.');
                        var html = '<tr class="renglon_cotizaciones"><td colspan="15">No se encontraron cotizaciones con esos datos.</td></tr>';
                        $('#t_cotizaciones tbody').append(html); 
                    }

                },
                error: function (xhr) {
                    console.log('buscarCotizacionesReportes:'+JSON.stringify(xhr));
                    mandarMensaje('No se encontró información al buscar cotizacion con filtros');
                }
            });
        }


        $('#b_excel').click(function(){
            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();

            var datos = {
                'fechaInicio':$('#i_fecha_inicio').val(),
                'fechaFin':$('#i_fecha_fin').val()
            };
            
            $("#i_nombre_excel").val('Reporte_cotizaciones');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val('COTIZACIONES_REPORTES');
            $('#i_datos_excel').val(JSON.stringify(datos));
            
            $("#f_imprimir_excel").submit();
        });
        

    });

</script>

</html>