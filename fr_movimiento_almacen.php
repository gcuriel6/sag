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
                        <div class="titulo_ban">Rastreo de Productos</div>
                    </div>
                    <div class="col-sm-12 col-md-5"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel_2"><i class="fa fa-file-excel-o" aria-hidden="true"></i> EXCEL Tallas</button>
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

                    <div class="col-sm-12 col-md-4">
                        <label for="s_id_unidad" class="col-sm-12 col-md-12 col-form-label requerido">Unidad de Negocio </label>
                        <div class="col-sm-12 col-md-12">
                            <select id="s_id_unidad" name="s_id_unidad" class="form-control validate[required]" autocomplete="off"></select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <label for="s_id_sucursal" class="col-sm-2 col-md-6 col-form-label requerido">Sucursal </label>
                        <div class="col-sm-12 col-md-12">
                            <select id="s_id_sucursal" name="s_id_unidadd_sucursal" class="form-control validate[required]" autocomplete="off"></select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-2">

                        <label for="i_id_producto" class="col-sm-2 col-md-6 col-form-label requerido">Catálogo </label>

                        <div class="input-group col-sm-12 col-md-12">
                            
                            <input type="text" id="i_id_producto" name="i_id_producto" class="form-control validate[required]" autocomplete="off">
                            
                            <div class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="b_busca_producto" style="margin:0px;">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>

                        </div>

                    </div>

                    <div class="col-sm-12 col-md-2">
                        <label for="i_existencia" class="col-sm-2 col-md-6 col-form-label ">Existencia </label>
                        <div class="col-sm-12 col-md-12">
                            <input type="text" id="i_existencia" name="i_existencia" class="form-control " readonly autocomplete="off">
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-12 col-md-4">
                        <label for="i_familia" class="col-sm-2 col-md-6 col-form-label ">Familia </label>
                        <div class="col-sm-12 col-md-12">
                            <input type="text" id="i_familia" name="i_familia" class="form-control" readonly autocomplete="off">
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <label for="i_linea" class="col-sm-2 col-md-6 col-form-label ">Línea </label>
                        <div class="col-sm-12 col-md-12">
                            <input type="text" id="i_linea" name="i_linea" class="form-control " readonly autocomplete="off">
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <label for="i_concepto" class="col-sm-2 col-md-6 col-form-label ">Concepto </label>
                        <div class="col-sm-12 col-md-12">
                            <input type="text" id="i_concepto" name="i_concepto" class="form-control " readonly autocomplete="off">
                        </div>
                    </div>


                </div>

                <br>

                <div class="row">
                    
                    <div class="col-sm-12 col-md-2">
                        <label for="i_fecha_de" class="col-sm-2 col-md-6 col-form-label ">De </label>
                        <div class="col-sm-12 col-md-12">
                            <input type="text" id="i_fecha_de" name="i_fecha_de" class="form-control fecha" autocomplete="off"/>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-2">
                        <label for="i_fecha_a" class="col-sm-2 col-md-6 col-form-label ">A </label>
                        <div class="col-sm-12 col-md-12">
                            <input type="text" id="i_fecha_a" name="i_fecha_a" class="form-control fecha" autocomplete="off"/>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-2">
                        <label for="i_existencia_fecha" class="col-sm-2 col-md-6 col-form-label ">  &nbsp;</label><!-- Existencia en la fecha de Inicio  &nbsp   &nbsp  &nbsp  d,-->
                        <div class="col-sm-12 col-md-12">
                            <input type="text" id="i_existencia_fecha" name="i_existencia_fecha" class="form-control " readonly autocomplete="off">
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <label for="i_existencia_fecha" class="col-sm-2 col-md-6 col-form-label ">  &nbsp;</label><!--  &nbsp   &nbsp  &nbsp  d,-->
                        <div class="col-sm-12 col-md-12">
                            <b>Existencia en la fecha de Inicio </b>
                        </div>
                    </div>                    

                </div>

                <br>

                <div class="row">

                    <div class="col-sm-12 col-md-12">
                        <table class="tablon" id="t_alnacen" border="2">
                            <thead>
                                <tr>
                                    <th width="5%">Folio</th>
                                    <th width="10%">Fecha</th>
                                    <th width="10%">Clave</th>
                                    <th width="15%">Concepto</th>
                                    <th width="24%"> Proveedor/Trabajador </th>
                                    <th width="10%">Referencia</th>
                                    <th width="7%">Precio</th>
                                    <th width="7%">Cantidad</th>
                                    <th width="7%">Saldo</th>
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

<div id="dialog_buscar_productos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Productos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
            <div class="row">
                <div class="input-group col-sm-12 col-md-4">
                    <input type="text" id="i_familia_filtro" name="i_familia_filtro" class="form-control" placeholder="Filtrar Por Familia" readonly autocomplete="off">
                    <div class="input-group-btn">
                        <button class="btn btn-primary" type="button" id="b_buscar_familia_filtro" style="margin:0px;">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </div> 
                <div class="input-group col-sm-12 col-md-4">
                    <input type="text" id="i_linea_filtro" name="i_linea_filtro" class="form-control" placeholder="Filtrar Por Línea" readonly autocomplete="off">
                    <div class="input-group-btn">
                        <button class="btn btn-primary" type="button" id="b_buscar_lineas_filtro" style="margin:0px;">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>  
                <div class="col-sm-12 col-md-4"><input type="text" name="i_filtro_producto" id="i_filtro_producto" class="form-control filtrar_renglones" alt="producto-partida" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_productos">
                      <thead>
                        <tr class="renglon">
                          
                          <th scope="col">Familia</th>
                          <th scope="col">Linea</th>
                          <th scope="col">Concepto</th>
                          <th scope="col">Precio</th>

                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
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

<div id="dialog_buscar_familias" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Familias</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_familias" id="i_filtro_familias" class="form-control filtrar_renglones" alt="renglon_familias" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_familias">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">ID</th>
                          <th scope="col">Clave</th>
                          <th scope="col">Descripción</th>
                          <th scope="col">Tallas</th>
                          <th scope="col">Tipo</th>
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
        <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div id="dialog_buscar_lineas" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Líneas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_lineas" id="i_filtro_lineas" class="form-control filtrar_renglones" alt="renglon_lineas" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_lineas">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Clave</th>
                          <th scope="col">Descripción</th>
                          <th scope="col">Familia</th>
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
<script src="vendor/select2/js/select2.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>

<script>

    var idUnidadActual = <?php echo $_SESSION['id_unidad_actual']; ?>;
    var idUsuario = <?php echo $_SESSION['id_usuario']; ?>;
    var modulo = 'RASTREO_PRODUCTOS';
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
            $('#t_alnacen >tbody tr').remove();

        });

        $('#s_id_sucursal').change(function()
        {

            var idSucursal = $('#s_id_sucursal').val();
            $('#i_id_producto').val('');
            $('#i_linea').val('');
            $('#i_familia').val('');
            $('#i_concepto').val('');
            $("#i_existencia").val('');
            $("#i_existencia_fecha").val('');
            $("#i_fecha_de").val('');
            $("#i_fecha_a").val('');
            $('#t_productos >tbody tr').remove();
            $('#t_alnacen >tbody tr').remove();


        });

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        });

        $('#b_busca_producto').click(function()
        {   

            if($("#s_id_sucursal").val() != null)
            {
                $('#i_familia_filtro').attr('alt',0).val('');
                $('#i_linea_filtro').attr('alt',0).val('');
                $('.producto-partida').remove();
                buscarProductos();
            }
            else
                mandarMensaje('Selecciona una Sucursal');
            
        });

        function buscarProductos()
        {

            var idUnidad = $('#s_id_unidad').val();

            $('#t_productos >tbody tr').remove();

            


            $.ajax({
                type: 'POST',
                url: 'php/productos_buscar_activos.php',
                dataType:"json", 
                data:{
                    'idUnidad': idUnidad,
                    'idFamilia': $('#i_familia_filtro').attr('alt'),
                    'idLinea' : $('#i_linea_filtro').attr('alt')
                },
                success: function(data)
                {
                    for(var i=0; data.length>i; i++)
                    {

                        var producto = data[i];

                        var html = "<tr class='producto-partida' alt='" + producto.id + "' alt2='" + producto.concepto+ "' alt3='" + producto.id_familia + "' alt4='" + producto.familia + "' alt5='" + producto.id_linea + "' alt6='" + producto.linea + "' alt7='" + producto.precio + "' alt8='" + producto.verifica_talla + "'>";
                        html += "<td>" + producto.familia + "</td>";
                        html += "<td>" + producto.linea + "</td>";
                        html += "<td>" + producto.concepto + "</td>";
                        html += "<td align='right'>" + redondear(producto.precio) +  "</td>";
                        html += "</tr>";

                        $('#t_productos tbody').append(html);
                    
                    }

                    $('#dialog_buscar_productos').modal('show');
         
                },
                error: function (xhr)
                {
                    mandarMensaje('1');//xhr.responseText
                }
            });
           
        }

        $("#t_productos").on('click',".producto-partida",function()
        {
            $('#t_alnacen >tbody tr').remove();
            var idProducto = $(this).attr('alt');
            var concepto = $(this).attr('alt2');
            var idFamilia = $(this).attr('alt3');
            var familia = $(this).attr('alt4');
            var idLinea = $(this).attr('alt5');
            var linea = $(this).attr('alt6');
            var precio = $(this).attr('alt7');
            var verificaT = $(this).attr('alt8');

            $('#i_id_producto').val(idProducto);
            $('#i_linea').val(linea);
            $('#i_familia').val(familia);
            $('#i_concepto').val(concepto);

            $('#dialog_buscar_productos').modal('hide');

            $.ajax({
                type: 'POST',
                url: 'php/inventario_buscar_existencia.php',
                //dataType:"json", 
                data:{
                    'id_sucursal': $("#s_id_sucursal").val(),
                    'id_producto': idProducto
                },
                success: function(data)
                {

                    $("#i_existencia").val(data);
                    $("#i_existencia_fecha").val(0);
                    $("#i_fecha_de").val('');
                    $("#i_fecha_a").val('');
                    buscarInventario();
                    //mandarMensaje(data);//xhr.responseText

                },
                error: function (xhr)
                {
                    mandarMensaje('1');//xhr.responseText
                }
            });

        });


        $('#i_fecha_de').change(function(){

            if($('#i_fecha_a').val()!='')
                buscarInventario();

        });

        $('#i_fecha_a').change(function()
        {

            if($("#i_id_producto").val() != '')
            {

                $.ajax({
                    type: 'POST',
                    url: 'php/inventario_buscar_existencia_rango_fechas.php',
                    data:{
                        'id_sucursal': $("#s_id_sucursal").val(),
                        'id_producto': $("#i_id_producto").val(),
                        'fechaFin': $("#i_fecha_a").val()
                    },
                    success: function(data)
                    {

                        if(data == '')
                            data = 0;

                        $("#i_existencia_fecha").val(data);

                    },
                    error: function (xhr)
                    {
                        mandarMensaje('1');//xhr.responseText
                    }
                });
                buscarInventario();
            }

        });

        function buscarInventario()
        {
            $('#t_alnacen >tbody tr').remove();
            $.ajax({
                type: 'POST',
                url: 'php/inventario_rastreo.php',
                dataType:"json", 
                data:{
                    'id_sucursal': $("#s_id_sucursal").val(),
                    'id_producto': $("#i_id_producto").val(),
                    'fecha_de': $("#i_fecha_de").val(),
                    'fecha_a': $("#i_fecha_a").val()
                },
                success: function(data)
                {
                    console.log(data);

                    //var totalI = parseInt($("#i_existencia_fecha").val());
                    var totalI = 0;
                   
                    for(var i=0; data.length >i; i++)
                    {

                        var detalle = data[i];
                        var claseR='';
                        var clave = detalle.clave;
            
                        if(clave.charAt(0) == 'S'){
                            totalI = totalI - parseInt(detalle.cantidad);
                            claseR = 'style="background:#F8D7DA;color:#721C24;"';
                        }else{
                            totalI = totalI + parseInt(detalle.cantidad);
                        }
                            

                        var html = "<tr class='renglon-producto-inventario' "+claseR+">";
                        html += "<td>" + detalle.no_movimiento +  "</td>";
                        html += "<td>" + detalle.fecha + "</td>";
                        html += "<td>" + detalle.concepto_mov + "</td>";
                        html += "<td>" + detalle.concepto + "</td>";
                        html += "<td>" + detalle.ref + "</td>"; // align='right'
                        html += "<td>" + detalle.referencia +  "</td>";
                        html += "<td align='right'>" + formatearNumero(detalle.precio) +  "</td>";
                        html += "<td align='right'>" + detalle.cantidad +  "</td>";
                        html += "<td align='right'>" + formatearNumero(totalI) +  "</td>";
                        html += "</tr>";

                        $('#t_alnacen tbody').append(html);
                    
                    }
         
                },
                error: function (xhr)
                {
                    console.log(JSON.stringify(xhr));
                    mandarMensaje('1');//xhr.responseText
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
                'id_sucursal':$('#s_id_sucursal').val(),
                'id_producto':$('#i_id_producto').val(),
                'fecha_de':$('#i_fecha_de').val(),
                'fecha_a':$('#i_fecha_a').val()
            };

            $('#i_nombre_excel').val('Detalle');
            $('#i_fecha_excel').val(hoy);
            $('#i_modulo_excel').val('DETALLE_MOV');
            $('#i_datos_excel').val(JSON.stringify(datos));
            
            $("#f_imprimir_excel").submit();

        });

        $('#b_excel_2').click(function()
        {

            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
            


            var datos = 
            {
                'id_sucursal':$('#s_id_sucursal').val(),
                'id_producto':$('#i_id_producto').val(),
                'fecha_de':$('#i_fecha_de').val(),
                'fecha_a':$('#i_fecha_a').val()
            };

            $('#i_nombre_excel').val('Detalle');
            $('#i_fecha_excel').val(hoy);
            $('#i_modulo_excel').val('DETALLE_MOV_2');
            $('#i_datos_excel').val(JSON.stringify(datos));
            
            $("#f_imprimir_excel").submit();

        });

        $('#b_buscar_familia_filtro').on('click',function()
        {
            buscaFamilias();
        });

        //$('#b_buscar_lineas').prop('disabled',true);
        //$('#b_buscar_lineas_filtro').prop('disabled',true);

        function buscaFamilias()
        {

            $('#i_filtro_familias').val('');
            $('.renglon_familias').remove();

            $.ajax({

                type: 'POST',
                url: 'php/familias_buscar.php',
                dataType:"json", 
                data:{'estatus':0},

                success: function(data) {
                
                if(data.length != 0){

                        $('.renglon_familias').remove();
                
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var inactivo='';
                            
                            if(parseInt(data[i].inactivo) == 1){

                                inactivo='inactivo';
                            }else{
                                inactivo='Activa';
                            }

                            var html='<tr class="renglon_familias" alt="'+data[i].id+'" alt2="'+data[i].descripcion+'">\
                                        <td data-label="ID">' + data[i].id+ '</td>\
                                        <td data-label="Clave">' + data[i].clave+ '</td>\
                                        <td data-label="Descripción">' + data[i].descripcion+ '</td>\
                                        <td data-label="Tallas">' + data[i].tallas+ '</td>\
                                        <td data-label="Tipo">' + data[i].tipo+ '</td>\
                                        <td data-label="Estatus">' + inactivo+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_familias tbody').append(html);   
                            $('#dialog_buscar_familias').modal('show');   
                        }

                }
                else
                        mandarMensaje('No se encontró información');

                },
                error: function (xhr) {
                    console.log('php/familias_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        $('#t_familias').on('click', '.renglon_familias', function()
        {
            
            var  idFamilia = $(this).attr('alt');
            var  familia = $(this).attr('alt2');
         
            $('#i_familia_filtro').attr('alt',idFamilia).val(familia);
            $('#b_buscar_lineas_filtro').prop('disabled',false);
            buscarProductos();
    
            $('#i_linea_filtro').val('');
            
            $('#dialog_buscar_familias').modal('hide');

        });

        $('#b_buscar_lineas_filtro').on('click',function(){
            buscaLineas();
        });

        function buscaLineas(){

                $('#i_filtro_lineas').val('');
                $('.renglon_lineas').remove();

                $.ajax({

                    type: 'POST',
                    url: 'php/lineas_buscar_idFamilia.php',
                    dataType:"json", 
                    data:{'idFamilia':$('#i_familia_filtro').attr('alt')},

                    success: function(data) {
                  
                    if(data.length != 0)
                    {

                            $('.renglon_lineas').remove();
                    
                            for(var i=0;data.length>i;i++){

                                ///llena la tabla con renglones de registros
                                var inactiva='';
                                
                                if(parseInt(data[i].inactiva) == 1){

                                    inactiva='Inactiva';
                                }else{
                                    inactiva='Activa';
                                }

                                var html='<tr class="renglon_lineas" alt="'+data[i].id+'" alt2="' + data[i].descripcion+ '">\
                                            <td data-label="Clave">' + data[i].clave+ '</td>\
                                            <td data-label="Descripción">' + data[i].descripcion+ '</td>\
                                            <td data-label="Familia">' + data[i].familia+ '</td>\
                                            <td data-label="Estatus">' + inactiva+ '</td>\
                                        </tr>';
                                ///agrega la tabla creada al div 
                                $('#t_lineas tbody').append(html);   
                                $('#dialog_buscar_lineas').modal('show');   
                            }
                    }
                    else
                            mandarMensaje('No se encontró información');

                    },
                    error: function (xhr) {
                        console.log('php/lineas_buscar.php-->'+JSON.stringify(xhr));
                        mandarMensaje('Error en el sistema');
                    }
                });
            }

            $('#t_lineas').on('click', '.renglon_lineas', function()
            {
              
                var idLinea = $(this).attr('alt');
                var linea = $(this).attr('alt2');

                $('#i_linea_filtro').val(linea).attr('alt',idLinea);
                buscarProductos();

                $('#dialog_buscar_lineas').modal('hide');


            });
        
    });

</script>

</html> 