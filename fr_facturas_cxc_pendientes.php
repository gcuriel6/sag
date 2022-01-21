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

    #fondo_cargando
    {

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
        z-index:2000;
        display:none;
        
    }

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
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-offset-1 col-md-12" id="div_contenedor">
            

                <br>

                <div class="row">
                    
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Reporte de Facturas/CXC no Cobradas</div>
                    </div>

                    <div class="col-sm-12 col-md-2"></div>

                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_buscar"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                    </div>

                    <div class="col-sm-12 col-md-2"></div>

                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel" disabled><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                    </div>

                    
                </div>

                <div class="row">

                    <div class="col-sm-12 col-md-4">
                        <label for="s_id_unidad" class="col-sm-2 col-md-12 col-form-label">Unidad de Negocio</label>
                        <div class="input-group col-sm-12 col-md-12">
                            <select id="s_id_unidad" name="s_id_unidad" class="form-control" autocomplete="off" style="width:100%;"></select>
                            <div class="input-group-btn">
                                <button class="btn btn-info" type="button" id="b_refresh" style="margin:0px;">
                                    <i class="fa fa-refresh" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <label for="s_id_sucursal" class="col-sm-2 col-md-12 col-form-label">Sucursal </label>
                        <div class="col-sm-12 col-md-12">
                            <select id="s_id_sucursal" name="s_id_sucursal" class="form-control" autocomplete="off" style="width:100%;"></select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <br>
                        <div class="row">
                            <div class="col-sm-12 col-md-1">Del: </div>
                            <div class="input-group col-sm-12 col-md-5">
                                <input type="text" name="i_fecha_de" id="i_fecha_de" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                                <div class="input-group-addon input_group_span">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-1">Al: </div>
                            <div class="input-group col-sm-12 col-md-5">
                                <input type="text" name="i_fecha_a" id="i_fecha_a" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                                <div class="input-group-addon input_group_span">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <label for="i_cliente" class="col-sm-12 col-md-12 col-form-label">Cliente</label>
                        <div class="input-group col-sm-12 col-md-12">
                            <input type="text" id="i_cliente" name="i_cliente" class="form-control form-control-sm" readonly autocomplete="off">
                            <div class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="b_buscar_clientes" style="margin:0px;">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <label for="s_razon_social" class="col-md-12 col-form-label">Razón Social (receptor) </label>
                        <div class="input-group col-md-12">
                            <select id="s_razon_social" name="s_razon_social" class="form-control form-control-sm" autocomplete="off" style="width:100%;"></select>
                        </div>
                    </div>

                    <div class="col-sm-5 col-md-4">
                        <label class="col-md-12 col-form-label">Filtrar</label>
                        <div class="input-group col-md-12">
                            <input type="text" id="i_filtro" name="i_filtro" class="form-control form-control-sm filtrar_renglones" alt="renglon_registros" autocomplete="off" placeholder="Filtrar...">
                        </div>
                    </div>

                    <div class="col-sm-5 col-md-2">
                        <label class="col-md-12 col-form-label">Saldo Total</label>
                        <div class="input-group col-md-12">
                            <input type="text" id="i_saldo_total" name="i_saldo_total" class="form-control form-control-sm" autocomplete="off" readonly>
                        </div>
                    </div>
                </div>

                <br>

                <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
                    <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
                    <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
                    <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
                    <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
                </form>

                <div class="col-sm-12 col-md-12" id="div_registros">
                    <table class="tablon" id="t_registros">
                        <thead>
                            <tr class="renglon">
                                <th scope="col">Unidad de Negocio</th>
                                <th scope="col">Sucursal</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Razón Social Receptor</th>
                                <th scope="col">Razón Social Emisor</th>
                                <th scope="col">Fecha Vencimiento</th>
                                <th scope="col">Folio CXC</th>
                                <th scope="col">Factura</th>
                                <th scope="col">Nota Credito</th>
                                <th scope="col">Cargo Inicial</th>
                                <th scope="col">Saldo</th>
                                <th scope="col">Estatus</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <br>

            </div> <!--div_contenedor-->

        </div>      

    </div> <!--div_principal-->
    
</body>

<div id="fondo_cargando"></div>

<div id="dialog_clientes" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Clientes</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_cliente" id="i_filtro_cliente" alt="renglon_cliente" class="filtrar_renglones form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_clientes">
                    <thead>
                        <tr class="renglon">
                            <th scope="col" style="text-align:left;">ID</th>
                            <th scope="col">Nombre Comercial</th>
                            <th scope="col">Fecha Inicio</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                    </table>  
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

    var idUnidadActual = <?php echo $_SESSION['id_unidad_actual']; ?>;
    var idUsuario = <?php echo $_SESSION['id_usuario']; ?>;
    var modulo = 'REPORTES_CXC_PENDIENTES';
    var matriz = <?php echo $_SESSION['sucursales']; ?>;
    $(function()
    {

        muestraSelectUnidades(matriz, 's_id_unidad', idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursal', idUnidadActual,modulo,idUsuario);

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true,
        });

        $('#s_id_unidad').change(function()
        {
            $('.img-flag').css({'width':'50px','height':'20px'});
            var idUnidadNegocio = $('#s_id_unidad').val();
            muestraSucursalesPermiso('s_id_sucursal', idUnidadNegocio,modulo,idUsuario);
        });
   
        $('#i_fecha_de').val(primerDiaMes);
        $('#i_fecha_a').val(ultimoDiaMes);

        $('#b_buscar').click(function()
        {
            $('#i_saldo_total').val(''); 
            $('#t_registros >tbody tr').remove();   
            $('#fondo_cargando').show();

            var datos = {
                'id_unidad_negocio' : $('#s_id_unidad').val(),
                'id_sucursal' : $('#s_id_sucursal').val(),
                'fecha_de' : $('#i_fecha_de').val(),
                'fecha_a' : $('#i_fecha_a').val(),
                'id_cliente' : $('#i_cliente').attr('alt'),
                'id_razon_social' : $('#s_razon_social').val(),
                'nombre_unidad' : $('#s_id_unidad').find('option:selected').text()
            };

            console.log(JSON.stringify(datos));

            $.ajax({
                type: 'POST',
                url: 'php/cxc_facturas_buscar_pendientes.php',
                dataType:"json", 
                data : {'datos':datos},
                success: function(data)
                {

                    console.log('* ' + data);

                    if(data.length != 0)
                    { 
                                     
                        for(var i=0;data.length>i;i++)
                        {
                            var html='<tr class="renglon_registros '+data[i].tipo+'" alt="'+data[i].tipo+'" saldo="'+data[i].saldo+'">\
                                        <td data-label="Unidad Negocio">'+data[i].unidad_negocio+'</td>\
                                        <td data-label="Sucursal">'+data[i].sucursal+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Cliente">'+data[i].cliente+'</td>\
                                        <td data-label="Razón Social (receptor)">'+data[i].razon_social+'</td>\
                                        <td data-label="Razón Social (emisor)">'+data[i].empresa_fiscal+'</td>\
                                        <td data-label="Fecha Vencimiento">'+data[i].fecha_vencimiento+'</td>\
                                        <td data-label="Folio cxc">'+data[i].id+'</td>\
                                        <td data-label="Factura">'+data[i].factura+'</td>\
                                        <td data-label="Nota">'+data[i].nota+'</td>\
                                        <td data-label="Cargo Inicial">'+formatearNumeroCSS(data[i].cargo_inicial,'')+'</td>\
                                        <td data-label="Saldo">'+formatearNumeroCSS(data[i].saldo,'')+'</td>\
                                        <td data-label="Estatus">'+labelEstatus(data[i].estatus)+'</td>\
                                    </tr>';
                            
                            $('#t_registros tbody').append(html);   

                        }

                        calculaTotalSaldo();
                        $('#b_excel').prop('disabled',false);
                        $('#fondo_cargando').hide();

                    }
                    else
                    {
                        var html = '<tr class="renglon_registros"><td colspan="13">No se encontró información</td></tr>';
                        $('#t_registros tbody').append(html);

                        $('#fondo_cargando').hide();
                    }

                },
                error: function (xhr) 
                {
                    console.log('php/cxc_facturas_buscar_pendientes.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar registros.');
                    $('#fondo_cargando').hide();
                }
            });

        });

        $('#b_excel').click(function()
        {

            var datos = {
                'id_unidad_negocio' : $('#s_id_unidad').val(),
                'id_sucursal' : $('#s_id_sucursal').val(),
                'fecha_de' : $('#i_fecha_de').val(),
                'fecha_a' : $('#i_fecha_a').val(),
                'id_cliente' : $('#i_cliente').attr('alt'),
                'id_razon_social' : $('#s_razon_social').val(),
                'nombre_unidad' : $('#s_id_unidad').find('option:selected').text()
            };
            
            $("#i_nombre_excel").val('Facturas/CXC no cobradas');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val('CXC_NO_COBRADAS');
            $('#i_datos_excel').val(JSON.stringify(datos));
            
            $("#f_imprimir_excel").submit();

        });

        function labelEstatus(estatus){
            var est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #0066cc;">SIN TIMBRAR</label>';
                        if(estatus == 'T')
                            est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #73AD21;">TIMBRADA</label>';
                        else if(estatus == 'C')
                            est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #ff0000;">CANCELADA</label>';
                        else if(estatus == 'P')
                            est = '<label style="background-color: rgb(232, 232, 232); color: black; border-radius: 5px; border: 2px solid #ffc107;">PENDIENTE</label>';
        
            return est;
        }

        //-->NJES March/30/2021 agregar campos y filtros
        $('#b_buscar_clientes').click(function(){
            
            if($('#s_id_unidad').val() != null)
            {
                if($('#s_id_unidad').find('option:selected').text()=='ALARMAS'){
                    $('#i_filtro_cliente').val('');
                    muestraModalServicios('renglon_cliente','t_clientes tbody','dialog_clientes');
                }else{
                    $('#i_filtro_cliente').val('');
                    muestraModalClientes('renglon_cliente','t_clientes tbody','dialog_clientes');
                }
            }else{
                mandarmensaje('Selecciona una unidad para buscar los clientes.');
            }
        });

        $('#t_clientes').on('click', '.renglon_cliente', function() {
            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            $('#i_cliente').attr('alt',id).val(nombre);

            if($('#s_id_unidad').find('option:selected').text()=='ALARMAS'){

                var razonSocial = $(this).attr('alt3');
                $('#s_razon_social').empty();
                $('#s_razon_social').append('<option value="'+id+'" alt6="'+razonSocial+'">'+razonSocial+'<option>');
                
            }

            $('#dialog_clientes').modal('hide'); 
            
            if($('#s_id_unidad').val() != '')
            {
                if($('#s_id_unidades').find('option:selected').text()!='ALARMAS')
                    muestraSelectRazonesSociales(id,$('#s_id_unidad').val(),'s_razon_social');
                
            }
        });

        $('#b_refresh').click(function(){
            muestraSelectUnidadesNotSelected(matriz, 's_id_unidad');
            $('#s_id_sucursal').html('').val('');
            $('#i_filtro').val('');
            $('#i_cliente').val('');
            $('#i_cliente').attr('alt',''),
            $('#s_razon_social').html('').val('');
            $('#i_fecha_de').val(primerDiaMes);
            $('#i_fecha_a').val(ultimoDiaMes);
            $('#t_registros >tbody tr').remove(); 
            $('#i_saldo_total').val(''); 
        });

        $('#i_filtro').keyup(function(){
            calculaTotalSaldo();
        });

        function calculaTotalSaldo(){
            var total=0;
            $('.renglon_registros').each(function(){
                if($(this).css('display')!='none')
                {
                    var valor= parseFloat(quitaComa($(this).attr('saldo')));

                    total=total+valor;
                }
            });

            $('#i_saldo_total').val(formatearNumero(total));
        }
        
    });

</script>

</html> 