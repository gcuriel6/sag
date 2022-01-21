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


    #fondo_cargando
    {

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
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor">
            

                <br>

                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Inventario</div>
                    </div>
                    <div class="col-sm-12 col-md-5"></div>
                    <div class="col-sm-12 col-md-2">
                        <!--<button type="button" class="btn btn-primary btn-sm form-control" id="b_pdf"><i class="fa fa-print" aria-hidden="true"></i> PDF</button>-->
                    </div>
                    
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> EXCEL</button>
                        <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
                            <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
                            <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
                            <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
                            <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
                        </form>
                    </div>
                </div>

                <br>

                <div class="row">

                    <div class="col-sm-12 col-md-5">
                        <label for="s_id_unidad" class="col-sm-12 col-md-12 col-form-label requerido">Unidad de Negocio </label>
                        <div class="col-sm-12 col-md-12">
                            <select id="s_id_unidad" name="s_id_unidad" class="form-control validate[required]" autocomplete="off"></select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-1"></div>

                    <div class="col-sm-12 col-md-5">
                        <label for="s_id_sucursal" class="col-sm-2 col-md-6 col-form-label requerido">Sucursal </label>
                        <div class="col-sm-12 col-md-12">
                            <select id="s_id_sucursal" name="s_id_sucursal" class="form-control validate[required]" autocomplete="off"></select>
                        </div>
                    </div>

                </div>

                <br>

                <div class="row">

                    <div class="col-sm-12 col-md-12">
                        <table class="tablon" id="t_productos" border="2">
                            <thead>
                                <tr>
                                    <th width="10%">
                                        <input type="text" id="i_filtro_1" name="i_filtro_1" alt="i_filtro1" alt2="1" alt3="renglon-producto-inventario" alt4="4" class="form-control filtrar_campos_renglones" placeholder="Catálogo" autocomplete="off"/>
                                    </th>
                                    <th width="15%">
                                      <input type="text" id="i_filtro_2" name="i_filtro_2" alt="i_filtro2" alt2="2"  alt3="renglon-producto-inventario" alt4="4" class="form-control  filtrar_campos_renglones" placeholder="Familia" autocomplete="off"/>
                                    </th>
                                    <th width="15%">
                                        <input type="text" id="i_filtro_3" name="i_filtro_3" alt="i_filtro3" alt2="3"  alt3="renglon-producto-inventario" alt4="4" class="form-control  filtrar_campos_renglones" placeholder="Línea" autocomplete="off"/>
                                    </th>
                                    <th width="20%">
                                        <input type="text" id="i_filtro_4" name="i_filtro_4" alt="i_filtro4" alt2="4"  alt3="renglon-producto-inventario" alt4="4" class="form-control  filtrar_campos_renglones" placeholder="Concepto" autocomplete="off"/>
                                    </th>
                                    <th width="10%"></th>
                                    <th width="10%"></th>
                                    <th width="10%"></th>
                                    <th width="10%"></th>
                                </tr>
                                <tr>
                                    <th width="10%">Catálogo</th>
                                    <th width="15%">Familia</th>
                                    <th width="15%">Línea</th>
                                    <th width="20%">Concepto</th>
                                    <th width="10%">Costo</th>
                                    <th width="10%">PrecioVenta</th>
                                    <th width="10%">Existencia</th>
                                    <th width="10%">Importe</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="6"></th>
                                    <th width="10%">Total</th>
                                    <th width="10%" id="th_total"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                
                </div>

                <br>

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
<script src="vendor/select2/js/select2.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>

<script>

    var idUnidadActual = <?php echo $_SESSION['id_unidad_actual']; ?>;
    var idUsuario = <?php echo $_SESSION['id_usuario']; ?>;
    var modulo = 'INVENTARIO_PRODUCTOS';
    var matriz = <?php echo $_SESSION['sucursales']; ?>;
    $(function()
    {

        mostrarBotonAyuda(modulo);
        muestraSelectUnidades(matriz, 's_id_unidad', idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursal', idUnidadActual, modulo,idUsuario);

        $('#s_id_unidad').change(function()
        {

            var idUnidadNegocio = $('#s_id_unidad').val();
            $('.img-flag').css({'width':'50px','height':'20px'});
            muestraSucursalesPermiso('s_id_sucursal', idUnidadNegocio, modulo,idUsuario);
            $('#t_productos >tbody tr').remove();

        });

        $('#s_id_sucursal').change(function()
        {

            var idSucursal = $('#s_id_sucursal').val();
            buscarInventario();


        });

        function buscarInventario()
        {

            console.log('A');
            $('#fondo_cargando').show();
            $('#t_productos >tbody tr').remove();
            $.ajax({
                type: 'POST',
                url: 'php/inventario_buscar.php',
                dataType:"json", 
                data:{
                    'id_sucursal': $("#s_id_sucursal").val()
                },
                success: function(data)
                {

                    console.log('X');
                    var totalCosto=0;
                    for(var i=0; data.length>i; i++)
                    {

                        var producto = data[i];
                        var importe =parseFloat(producto.precio)*parseFloat(producto.existencia);
                        totalCosto = totalCosto + importe;
                        var html = "<tr class='renglon-producto-inventario' importe='"+importe+"'>";
                        html += "<td class='i_filtro1' align='center'>" + producto.id_producto +  "</td>";
                        html += "<td class='i_filtro2'>" + producto.familia + "</td>";
                        html += "<td class='i_filtro3'>" + producto.linea + "</td>";
                        html += "<td class='i_filtro4'>" + producto.concepto + "</td>";
                        html += "<td align='right'>" + formatearNumero(redondear(producto.precio)) +  "</td>";
                        html += "<td align='right'>" + formatearNumero(redondear(producto.precio_venta)) +  "</td>";
                        html += "<td align='right'>" + producto.existencia +  "</td>";
                        html += "<td align='right'>" + formatearNumero(importe) +  "</td>";
                        html += "</tr>";

                        $('#t_productos tbody').append(html);
                    
                    }

                    if(i == data.length)
                        $('#th_total').text(formatearNumero(totalCosto));

                    $('#fondo_cargando').hide();
         
                },
                error: function (xhr)
                {
                    console.log('php/inventario_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar inventario');
                }
            });

        }

        $('#b_excel').click(function()
        {

            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
            
            var datos = 
            {
                'id_sucursal':$('#s_id_sucursal').val()
            };

            $('#i_nombre_excel').val('Inventario');
            $('#i_fecha_excel').val(hoy);
            $('#i_modulo_excel').val('INVENTARIO');
            $('#i_datos_excel').val(JSON.stringify(datos));
            
            $("#f_imprimir_excel").submit();

        });

        $(document).on('keyup','input',function(){
            var costoTotal=0;
            $('#t_productos >tbody tr').each(function(){
                var importe = $(this).attr('importe');

                if($(this).css('display')!='none'){
                    costoTotal = costoTotal+parseFloat(importe);
                }
            });
            $('#th_total').text(formatearNumero(costoTotal));
        });
        
    });

</script>

</html>