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
        overflow:hidden;
    }
    #div_contenedor{
        background-color: #ffffff;
        padding-bottom:10px;
    }
    #div_t_reclasificacion{
        max-height:290px;
        min-height:290px;
        overflow:auto;
        border: 1px solid #ddd;
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
    #forma{
        border: 1px solid #ddd;
        padding:0px 5px 20px 5px;
    }
    #i_total{
        text-align:right;
    }
    #dialog_reclasificar_gasto > .modal-lg{
        min-width: 80%;
        max-width: 80%;
    }
    
    @media only screen and (max-width:850px){
        body{
            overflow:auto;
        }
    }

    /* Responsive Web Design */
	@media only screen and (max-width:668px){
        .tablon{
            margin-top:10px;
        }
        #div_t_reclasificacion{
            height:auto;
            overflow:auto;
        }
        #div_principal{
            margin-left:0%;
        }
        #dialog_reclasificar_gasto > .modal-lg{
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
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Reclasificación de Gastos</div>
                    </div>
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-12 col-md-4">
                        <div class="row">
                            <div class="col-sm-12 col-md-1">Del: </div>
                            <div class="input-group col-sm-12 col-md-5">
                                <input type="text" name="i_fecha_inicio" id="i_fecha_inicio" class="form-control form-control-sm fecha" autocomplete="off" data-date-format="yyyy-mm-dd" readonly>
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
                    <div class="col-sm-12 col-md-2">
                        <!--<input type="checkbox" id="ch_incompletos" name="ch_incompletos" value=""> Incompletos-->
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                    </div>
                </div>

                <div class="row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>
            
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <label for="s_id_unidad" class="col-md-5 col-form-label requerido">Filtrar por Unidad de Negocio </label>
                            <div class="col-md-7">
                                <select id="s_id_unidad" name="s_id_unidad" class="form-control" autocomplete="off" style="width:100%;"></select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <label for="s_id_area" class="col-md-5 col-form-label">Filtrar por Área </label>
                            <div class="col-md-7">
                                <select id="s_id_area" name="s_id_area" class="form-control form-control-sm" autocomplete="off" style="width:100%;"></select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <label for="s_id_familia_gasto" class="col-md-5 col-form-label">Filtrar por Familia Gasto </label>
                            <div class="col-md-7">
                                <select id="s_id_familia_gasto" name="s_id_familia_gasto" class="form-control form-control-sm" autocomplete="off" style="width:100%;"></select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                    <div class="row">
                            <label for="s_id_sucursal" class="col-md-5 col-form-label">Filtrar por Sucursal </label>
                            <div class="col-md-7">
                                <select id="s_id_sucursal" name="s_id_sucursal" class="form-control form-control-sm" autocomplete="off" style="width:100%;"></select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <label for="s_id_departamento" class="col-md-5 col-form-label">Filtrar por Departamento </label>
                            <div class="col-md-7">
                                <select id="s_id_departamento" name="s_id_departamento" class="form-control form-control-sm" autocomplete="off" style="width:100%;" disabled></select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <label for="s_id_clasificacion" class="col-md-5 col-form-label">Filtrar por Clasificación </label>
                            <div class="col-md-7">
                                <select id="s_id_clasificacion" name="s_id_clasificacion" class="form-control form-control-sm" autocomplete="off" style="width:100%;" disabled></select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="div_reclasificacion">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Unidad de Negocio</th>
                                    <th scope="col">Sucursal</th>
                                    <th scope="col">Área</th>
                                    <th scope="col">Departamento</th>
                                    <th scope="col">Familia Gastos</th>
                                    <th scope="col">Clasificación</th>
                                    <th scope="col">proveedor</th>
                                    <th scope="col">Factura</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Importe</th>
                                    <th scope="col">Referencia</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col" width="7%">Editar</th>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_t_reclasificacion">
                            <table class="tablon"  id="t_reclasificacion">
                                <tbody>
                                    
                                </tbody>
                            </table>  
                        </div>  
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-8"></div>
                    <div class="col-sm-12 col-md-3">
                        <div class="row">
                            <label for="i_total" class="col-form-label col-md-3">Total</label>
                            <div class="col-sm-12 col-md-6">
                                <input type="text" id="i_total" name="i_total" class="form-control form-control-sm" autocomplete="off" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
                    <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
                    <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
                    <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
                    <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
                </form>

            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
</body>

<div id="dialog_reclasificar_gasto" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" style="overflow-y: scroll;" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Reclasificar Gasto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row form-group">
                <div class="col-sm-12 col-md-2 datos_clasif" id="div_fecha"></div>
                <div class="col-sm-12 col-md-2 datos_clasif" id="div_importe"></div>
            </div>
            <div class="row form-group">
                <div class="col-sm-12 col-md-4 datos_clasif" id="div_unidad"></div>
                <div class="col-sm-12 col-md-4 datos_clasif" id="div_sucursal"></div>
                <div class="col-sm-12 col-md-4 datos_clasif" id="div_area"></div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-4 datos_clasif" id="div_departamento"></div>
                <div class="col-sm-12 col-md-4 datos_clasif" id="div_familia_gasto"></div>
                <div class="col-sm-12 col-md-4 datos_clasif" id="div_clasificacion"></div>
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

<script>
  
    var modulo='RECLASIFICACION_GASTOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;

    var matriz = <?php echo $_SESSION['sucursales']?>;

    var FromEndDate = new Date('<?php echo date('Y-m-d')?>');//--hoy
    var ayer =  restarDias(FromEndDate, 0);//---ayer
   
    $(function()
    {

        fechaHoyServidor('i_fecha_inicio','ayer');
        fechaHoyServidor('i_fecha_fin','hoy');
        mostrarBotonAyuda(modulo);
        muestraSelectUnidades(matriz, 's_id_unidad', idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursal', idUnidadActual,modulo,idUsuario);
        muestraAreasAcceso('s_id_area');
        muestraSelectFamiliaGastos('s_id_familia_gasto');

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true,
        });

        $('[data-toggle="popover"]').popover();
        
        muestraGastos($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());

        $('#s_id_unidad').change(function(){
            var idUnidadNegocio = $('#s_id_unidad').val();
            $('.img-flag').css({'width':'50px','height':'20px'});

            muestraSucursalesPermiso('s_id_sucursal', idUnidadNegocio,modulo,idUsuario);

            $('#s_id_departamento').val('').select2({placeholder: ''}).prop('disabled',true);
            $('#s_id_clasificacion').val('').select2({placeholder: ''}).prop('disabled',true);

            muestraGastos($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
        });

       $('#s_id_sucursal').change(function(){
           var idSucursal = $('#s_id_sucursal').val();
           var idArea = $('#s_id_area').val();
           $("#s_id_departamento").empty();
           if(idSucursal > 0 && idArea > 0)
            {
                muestraDepartamentoAreaInternos('s_id_departamento', idSucursal, idArea);
                $("#s_id_departamento").prop("disabled", false);
            }

            muestraGastos($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
        });

       $('#s_id_area').change(function(){
            var idSucursal = $('#s_id_sucursal').val();
            var idArea = $('#s_id_area').val();
            $("#s_id_departamento").empty();
            if(idSucursal > 0 && idArea > 0)
            {
                muestraDepartamentoAreaInternos('s_id_departamento', idSucursal, idArea);
                $("#s_id_departamento").prop("disabled", false);
            }

            muestraGastos($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
        });

        $('#s_id_departamento').change(function(){
            muestraGastos($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
        });

        $('#s_id_familia_gasto').change(function(){
            var idFamilia = $('#s_id_familia_gasto').val();
            muestraSelectClasificacionGastos('s_id_clasificacion',idFamilia);
            $("#s_id_clasificacion").prop("disabled", false);

            muestraGastos($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
        });

        $('#s_id_clasificacion').change(function(){
            muestraGastos($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
        });

        $('#i_fecha_inicio').on('change',function(){
            muestraGastos($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
        });

        $('#i_fecha_fin').change(function(){
            muestraGastos($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
        });

        function muestraGastos(fechaInicio,fechaFin){
            
            $('#t_reclasificacion tbody').empty();
            
            var idUnidadNegocio =  $('#s_id_unidad').val() == null ? 0 : $('#s_id_unidad').val();
            var idSucursal = $('#s_id_sucursal').val() == null ? 0 : $('#s_id_sucursal').val();
            var idArea = $('#s_id_area').val() == null ? 0 : $('#s_id_area').val();
            var idDepartamento = $('#s_id_departamento').val() == null ? 0 : $('#s_id_departamento').val();
            var idFamiliaGasto = $('#s_id_familia_gasto').val() == null ? 0 : $('#s_id_familia_gasto').val();
            var idClasificacion = $('#s_id_clasificacion').val() == null ? 0 : $('#s_id_clasificacion').val();
            
            var datos={
                'idUnidadNegocio': idUnidadNegocio,
                'idSucursal': idSucursal,
                'idArea': idArea,
                'idDepartamento': idDepartamento,
                'idFamiliaGasto': idFamiliaGasto,
                'idClasificacion':idClasificacion,
                'fechaInicio': fechaInicio,
                'fechaFin': fechaFin
            };
            
            $.ajax({

                type: 'POST',
                url: 'php/reclasificacion_gastos_buscar.php',
                dataType: 'json',
                data:{'datos':datos},
                async: false,
                success: function(data)
                {
                    //console.log(data);
                    if(data.length != 0){
                        
                        var num=data.length;
                        for(var i=0;data.length>i;i++){
                        var color='';
                        var colorS='style="background-color:#aaa;"';
                        var colorS2='style="background-color:#aaa;"';

                            if(data[i].nums > 0)
                            {
                                if(data[i].llaves1 == 'SI')
                                    colorS = 'style="background-color:rgba(51, 204, 51,.5);"';


                                if(data[i].llaves2 == 'SI')
                                    colorS2 = 'style="background-color:rgba(153, 102, 255,.5);"';

                            }else
                                color = 'style="background-color:rgba(170, 170, 170,.5);"';
                            
                            var importe = parseFloat(data[i].importe); 
                            
                            var selectUnidadNegocio=data[i].unidad_negocio;
                            var selectSucursal=data[i].sucursal;
                            var selectArea=data[i].area;
                            var selectDepartamento=data[i].departamento;
                            var selectFamiliaGasto=data[i].familia_gasto;
                            var selectClasificacion=data[i].clasificacion;

                            /*NJES RECLASIFICACIÓN DE GASTOS (1) (DEN18-2408) Dic/26/2019*/
                            var botonDetalle='<button type="button" class="btn btn-info btn-sm" data-trigger="focus" data-toggle="popover" title="Descripción" data-content="'+data[i].descripcion+'">\
                                                    <i class="fa fa-eye" aria-hidden="true"></i>\
                                                </button>';
                            
                            var botonEditar='<button type="button" class="btn btn-dark btn-sm b_editar" alt="'+data[i].id+'">\
                                                    <i class="fa fa-pencil" aria-hidden="true"></i>\
                                                </button>';
                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_registros" id="'+data[i].id+'" idUnidad="'+data[i].id_unidad_negocio+'" idSucursal="'+data[i].id_sucursal+'">\
                                        <td '+color+' '+colorS+' data-label="Unidad de Negocio">'+selectUnidadNegocio+'</td>\
                                        <td '+color+' '+colorS+' data-label="Sucursal">'+selectSucursal+'</td>\
                                        <td '+color+' '+colorS2+' data-label="Área">'+selectArea+'</td>\
                                        <td '+color+' '+colorS2+' data-label="Departamento">'+selectDepartamento+'</td>\
                                        <td '+color+' '+colorS2+' data-label="Familia Gasto">'+selectFamiliaGasto+'</td>\
                                        <td '+color+' '+colorS2+' data-label="Clasificación">'+selectClasificacion+'</td>\
                                        <td data-label="Proveedor">'+data[i].proveedor+'</td>\
                                        <td data-label="Factura">'+data[i].factura+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Importe" class="importe" alt='+data[i].importe+'>$'+formatearNumeroCSS(importe.toFixed(2) + '')+'</td>\
                                        <td data-label="Referencia">'+data[i].referencia+'</td>\
                                        <td data-label="Tipo">'+data[i].tipo+' '+botonDetalle+'</td>\
                                        <td data-label="Editar" width="5%">'+botonEditar+'</td>\
                                    </tr>';

                            ///agrega la tabla creada al div 
                            $('#t_reclasificacion tbody').append(html); 
                            
                            $('[data-toggle="popover"]').popover();
                            
                        }
                    }else{
                        var html='<tr class="renglon_registros">\
                                        <td colspan="11">No se encontró información</td>\
                                    </tr>';

                        $('#t_reclasificacion tbody').append(html);
                    }

                    sumaTotal();
                },
                error: function (xhr) 
                {
                    console.log('php/reclasificacion_gastos_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('*No se encontró información al buscar datos');
                }
            });

        }

        //-->NJES Sep/25/2020 agregar modal para poder reclasificar los gastos ya que se tardaba mucho en cargar los combos de cada renglon
        $(document).on('click','.b_editar',function()
        {

            var id = $(this).attr('alt');

            console.log('ID -> ' + id);

            $('.datos_clasif').empty();
            $.ajax({
                type: 'POST',
                url: 'php/reclasificacion_gastos_id_buscar.php',
                dataType: 'json',
                data:{'id':id},
                success: function(data)
                {
                    $('#div_fecha').text('Fecha: '+data[0].fecha);
                    $('#div_importe').text('Importe: $'+formatearNumero(data[0].importe));

                    var selectUnidadNegocio='<label class="col-md-5 col-form-label">Unidad de Negocio </label><select id="s_id_unidad_negocio_'+data[0].id+'" name="s_id_unidad_negocio_'+data[0].id+'" alt="'+data[0].id+'" alt2="'+data[0].id_unidad_negocio+'" unidadNegocioAnterior="'+data[0].unidad_negocio+'" class="form-control form-control-sm s_unidad_negocio" autocomplete="off" style="width:100%;"></select>';
                    $('#div_unidad').append(selectUnidadNegocio);
                    var selectSucursal='<label class="col-md-5 col-form-label">Sucursal </label><select id="s_id_sucursal_'+data[0].id+'" name="s_id_sucursal_'+data[0].id+'" alt="'+data[0].id+'" alt2="'+data[0].id_sucursal+'" sucursalAnterior="'+data[0].sucursal+'" class="form-control form-control-sm s_sucursal" autocomplete="off" style="width:100%;"></select>';
                    $('#div_sucursal').append(selectSucursal);
                    var selectArea='<label class="col-md-5 col-form-label">Area</label><select id="s_id_area_'+data[0].id+'" name="s_id_area_'+data[0].id+'" alt="'+data[0].id+'" alt2="'+data[0].id_area+'" areaAnterior="'+data[0].area+'" class="form-control form-control-sm s_area" autocomplete="off" style="width:100%;"></select>';
                    $('#div_area').append(selectArea);
                    var selectDepartamento='<label class="col-md-5 col-form-label">Departamento </label><select id="s_id_departamento_'+data[0].id+'" name="s_id_departamento_'+data[0].id+'" alt="'+data[0].id+'" departamentoAnterior="'+data[0].departamento+'" class="form-control form-control-sm s_depto" autocomplete="off" style="width:100%;"></select>';
                    $('#div_departamento').append(selectDepartamento);
                    var selectFamiliaGasto='<label class="col-md-5 col-form-label">Familia </label><select id="s_id_familia_'+data[0].id+'" name="s_id_familia_'+data[0].id+'" alt="'+data[0].id+'" alt2="'+data[0].id_familia_gasto+'" familiaGastoAnterior="'+data[0].familia_gasto+'" class="form-control form-control-sm s_familia_gasto" autocomplete="off" style="width:100%;"></select>';
                    $('#div_familia_gasto').append(selectFamiliaGasto);
                    var selectClasificacion='<label class="col-md-5 col-form-label">Clasificación </label><select id="s_id_clasificacion_'+data[0].id+'" name="s_id_clasificacion_'+data[0].id+'" alt="'+data[0].id+'" clasificacionAnterior="'+data[0].clasificacion+'" class="form-control form-control-sm s_clasificacion" autocomplete="off" style="width:100%;"></select>';
                    $('#div_clasificacion').append(selectClasificacion);
                    
                    muestraUnidadesValor(matriz,'s_id_unidad_negocio_'+data[0].id,data[0].id_unidad_negocio);
                            
                    muestraSucursalesPermisoValor('s_id_sucursal_'+data[0].id,data[0].id_unidad_negocio,modulo,idUsuario,data[0].id_sucursal);

                    muestraAreasAccesoValor('s_id_area_'+data[0].id,data[0].id_area)

                    muestraDepartamentoAreaInternosValor('s_id_departamento_'+data[0].id,data[0].id_sucursal, data[0].id_area, data[0].id_departamento); 
                    
                    muestraSelectFamiliaGastosValor('s_id_familia_'+data[0].id,data[0].id_familia_gasto);

                    muestraSelectClasificacionGastosValor('s_id_clasificacion_'+data[0].id,data[0].id_familia_gasto,data[0].id_clasificacion);

                    console.log('** ' + data[0].id_familia_gasto);
                    console.log('** ' + data[0].id_clasificacion);

                },
                error: function (xhr) 
                {
                    console.log('php/reclasificacion_gastos_id_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('*No se encontró información al buscar datos');
                }
            });

            $('#dialog_reclasificar_gasto').modal('show');
        });

        $(document).on('change','.s_unidad_negocio',function(){
            
            var id = $(this).attr('alt');
            var idUnidadAnterior = $(this).attr('alt2');
            var valorAnterior = $(this).attr('unidadNegocioAnterior');
            var idSucursal = 0;
            var idUnidadNegocio = $('#s_id_unidad_negocio_'+id).val();
            var idArea = $('#s_id_area_'+id).val();

            actualizaCampo('unidad_negocio',id,$('#s_id_unidad_negocio_'+id).val(),idUnidadNegocio,idSucursal,idUnidadAnterior,valorAnterior,idArea);            
        
        });

        $(document).on('change','.s_sucursal',function(){
            var id = $(this).attr('alt');
            var idSucursalAnterior = $(this).attr('alt2');
            var valorAnterior = $(this).attr('sucursalAnterior');
            var idSucursal = $('#s_id_sucursal_'+id).val();
            var idUnidadNegocio = $('#s_id_unidad_negocio_'+id).val();
            var idArea = $('#s_id_area_'+id).val();

            actualizaCampo('sucursal',id,$('#s_id_sucursal_'+id).val(),idUnidadNegocio,idSucursal,idSucursalAnterior,valorAnterior,idArea);            
            
        });


        $(document).on('change','.s_area',function(){
            var id = $(this).attr('alt');
            var idAreaAnterior = $(this).attr('alt2');
            var valorAnterior = $(this).attr('areaAnterior');
            var idSucursal = $('#s_id_sucursal_'+id).val();
            var idUnidadNegocio = $('#s_id_unidad_negocio_'+id).val();
            var idArea = $('#s_id_area_'+id).val();

            actualizaCampo('area',id,$('#s_id_area_'+id).val(),idUnidadNegocio,idSucursal,idAreaAnterior,valorAnterior,idArea);            
            
        });

        $(document).on('change','.s_depto',function(){
            var id = $(this).attr('alt');
            var valorAnterior = $(this).attr('departamentoAnterior');
            var idSucursal = $('#s_id_sucursal_'+id).val();
            var idUnidadNegocio = $('#s_id_unidad_negocio_'+id).val();
            var idArea = $('#s_id_area_'+id).val();

            actualizaCampo('departamento',id,$('#s_id_departamento_'+id).val(),idUnidadNegocio,idSucursal,0,valorAnterior,idArea);            
        });

        $(document).on('change','.s_familia_gasto',function(){
            var id = $(this).attr('alt');
            var idFamiliaAnterior = $(this).attr('alt2');
            var valorAnterior = $(this).attr('familiaGastoAnterior');
            var idSucursal = $('#s_id_sucursal_'+id).val();
            var idUnidadNegocio = $('#s_id_unidad_negocio_'+id).val();
            var idFamilia = $('#s_id_familia_'+id).val();
            var idArea = $('#s_id_area_'+id).val();

            actualizaCampo('familia_gasto',id,$('#s_id_familia_'+id).val(),idUnidadNegocio,idSucursal,idFamiliaAnterior,valorAnterior,idArea);            
        
        });

        $(document).on('change','.s_clasificacion',function(){
            var id = $(this).attr('alt');
            var valorAnterior = $(this).attr('clasificacionAnterior');
            var idSucursal = $('#s_id_sucursal_'+id).val();
            var idUnidadNegocio = $('#s_id_unidad_negocio_'+id).val();
            var idArea = $('#s_id_area_'+id).val();

            actualizaCampo('clasificacion',id,$('#s_id_clasificacion_'+id).val(),idUnidadNegocio,idSucursal,0,valorAnterior,idArea);            
        });

        function actualizaCampo(campo,idRegistro,valor,idUnidadNegocio,idSucursal,idAnterior,valorAnterior,idArea){
            $('#dialog_reclasificar_gasto').modal('hide');
            var info ={
                'campo':campo,
                'idRegistro':idRegistro,
                'valor':valor,
                'camposModificados':campo+': '+valorAnterior+' <br>',
                'idUsuario':idUsuario,
                'modulo':modulo,
                'idUnidadNegocio':idUnidadNegocio,
                'idSucursal':idSucursal
            };

            $.ajax({
                type: 'POST',
                url: 'php/reclasificacion_gastos_actualizar.php',
                dataType: 'json',
                data:{'datos':info},
                success: function(data)
                {
                    if(data > 0)
                        muestraGastos($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
                    else{
                        console.log('php/reclasificacion_gastos_actualizar.php-->'+data);
                        mandarMensaje('Ocurrio un error al actualizar');
                    }

                },error: function (xhr) 
                {
                    console.log('php/reclasificacion_gastos_actualizar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* Ocurrio un error al actualizar');
                }
            });
        }

        function sumaTotal(){
            var total=0;
            
            $('.importe').each(function(){
                if($(this).parent().css('display')!='none')
                {
                    var valor= parseFloat($(this).attr('alt'));

                    total=total+valor;
                }
            });

            $('#i_total').val(formatearNumero(total));
        }

        $('#b_excel').click(function(){
            var idUnidadNegocio =  $('#s_id_unidad').val() == null ? 0 : $('#s_id_unidad').val();
            var idSucursal = $('#s_id_sucursal').val() == null ? 0 : $('#s_id_sucursal').val();
            var idArea = $('#s_id_area').val() == null ? 0 : $('#s_id_area').val();
            var idDepartamento = $('#s_id_departamento').val() == null ? 0 : $('#s_id_departamento').val();
            var idFamiliaGasto = $('#s_id_familia_gasto').val() == null ? 0 : $('#s_id_familia_gasto').val();
            var idClasificacion = $('#s_id_clasificacion').val() == null ? 0 : $('#s_id_clasificacion').val();
            var fechaInicio= $('#i_fecha_inicio').val();
            var fechaFin= $('#i_fecha_fin').val();
            
            var datos={
                'idUnidadNegocio': idUnidadNegocio,
                'idSucursal': idSucursal,
                'idArea': idArea,
                'idDepartamento': idDepartamento,
                'idFamiliaGasto': idFamiliaGasto,
                'idClasificacion':idClasificacion,
                'fechaInicio': fechaInicio,
                'fechaFin': fechaFin
            };

            $("#i_nombre_excel").val('Reporte Reclasificación Gastos');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(datos));

            $("#f_imprimir_excel").submit();
        });
        
    });

</script>

</html>