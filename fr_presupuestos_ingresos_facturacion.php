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

    #fondo_cargando {
            position: absolute;
            top: 1%;
            background-image:url('imagenes/loading.gif');
            background-repeat:no-repeat;
            background-position:center;
            background-color:#000;
            left: 1%;
            width: 98%;
            bottom:3%;
            border: 2px solid #6495ed;
            opacity: .1;
            filter:Alpha(opacity=10);
            border-radius: 5px;
            z-index:2;
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
    <form id="f_p" name="f_p">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Presupuesto de Ingresos de Facturación</div>
                    </div>

                    <div class="col-sm-12 col-md-1"></div>

                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel" title="Este Excel solo mostrará la información que ya se guardó, con los filtros ingresados"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                        
                    </div>
                    <div class="col-sm-12 col-md-1"></div>

                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>
                   
                   
                </div>

                <div class="row">

                    <div class="col-sm-12 col-md-3">
                        <label for="s_id_unidad" class="col-sm-2 col-md-6 col-form-label requerido">Unidad N. </label>
                        <div class="col-sm-12 col-md-12">
                            <select id="s_id_unidad" name="s_id_unidad" class="form-control validate[required]" autocomplete="off"></select>
                        </div>
                    </div>
                    
                    <div class="col-sm-12 col-md-3">
                        <label for="s_id_sucursal" class="col-sm-2 col-md-6 col-form-label requerido">Sucursal </label>
                        <div class="col-sm-12 col-md-12">
                            <select id="s_id_sucursal" name="s_id_sucursal" class="form-control validate[required]" autocomplete="off"></select>
                        </div>
                    </div>

                   <div class="col-sm-12 col-md-2">
                        <label for="i_anio" class="col-sm-2 col-md-6 col-form-label">Año </label>
                        <div class="col-sm-12 col-md-12">
                            <input type="text" id="i_anio" name="i_anio" class="form-control form-control-sm izquierda" readonly autocomplete="off"/>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-2">
                        <label for="i_mes" class="col-sm-2 col-md-6 col-form-label requerido">Mes </label>
                        <div class="col-sm-12 col-md-12">
                            <select  id="i_mes" name="i_mes" class="form-control validate[required]" autocomplete="off"/></select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2 justify-content-center align-self-center" >
                        <!--<input type="radio" id="r_anual" name="r_tipo" value="anual" />Anual<br> -->
                        <input type="radio" id="r_mensual" name="r_tipo" value="mensual" checked="checked" />Mensual
                        <button type="button" class="btn btn-info btn-sm form-control" id="b_buscar"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                    </div>

                </div>

                <br>

                <div class="row">
                    <div class="col-sm-12 col-md-12">

                        <table class="tablon"  id="t_presupuesto">
                          <thead>
                            <tr class="renglon">                                
                                <th scope="col">AREA</th> 
                                <th scope="col">DEPARTAMENTO OPERATIVO</th>
                                <th scope="col">FACTURA</th> 
                                <th scope="col">VENCIMIENTO</th>
                                <th scope="col">IMPORTE</th>
                                <th scope="col">OTROS_INGRESOS</th>
                                <th scope="col">OBSERVACIONES</th>
                                <th scope="col">TOTAL</th>
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
    </form>
    <!--- ESTE FROM DEBE IR FUERA DE CUALQUIER OTRO FORM SI NO NO DESCARGARA EL ARCHIVO EXCEL-->
    <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
        <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
        <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
        <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
        <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
    </form>

    </div> <!--div_principal-->
    
</body>


<!-- DIALOGS -->

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
    var matriz = <?php echo $_SESSION['sucursales']; ?>;
    var modulo = 'PRESUPUESTOS_INGRESOS_FACTURACION';

    $(function()
    {
        mostrarBotonAyuda(modulo);
        muestraSelectUnidades(matriz, 's_id_unidad', idUnidadActual);
        muestraSucursalesAcceso('s_id_sucursal', idUnidadActual, idUsuario); 
        generaFecha();

        $('#b_excel').prop('disabled',true);

        $("#i_anio").val(new Date().getFullYear());

        $('#s_id_unidad').change(function()
       {

            var idUnidadNegocio = $('#s_id_unidad').val();
            $('.img-flag').css({'width':'50px','height':'20px'});
            muestraSucursalesAcceso('s_id_sucursal', idUnidadNegocio, idUsuario);
            $('#t_presupuesto >tbody tr').remove();

        });

        $('input[name=r_tipo]').on('click',function(){
            $('#b_buscar').prop('disabled',false);
        });

        $('#s_id_sucursal').change(function()
        {
            $('#b_buscar').prop('disabled',false);
            $('#t_presupuesto >tbody tr').remove();
        });

        $('#i_mes').change(function()
        {
            $('#b_buscar').prop('disabled',false);
            $('#t_presupuesto >tbody tr').remove();
        });

        $('#b_buscar').on('click',function(){

            $('#b_buscar').prop('disabled',true);

            if ($('#f_p').validationEngine('validate')){
                
                buscarPresupuestoIngresos();
                verificaSiHayInformacion();

            }else{
                mandarMensaje('Debes llenar todos los filtros, para poder generar la búsqueda');
                $('#b_buscar').prop('disabled',false);
            }
        });


        function buscarPresupuestoIngresos()
        {

            $('#t_presupuesto >tbody tr').remove();
            var idUnidad =  $('#s_id_unidad').val();
            var idSucursal = $('#s_id_sucursal').val();
            var anio = $('#i_anio').val();
            var mes = $('#i_mes').val();
            var tipo = $('input[name=r_tipo]:checked').val();

           var verifica = false;
            if(idUnidad == null)
                verifica = true;

            if(idSucursal == null)
                verifica = true;

            if(anio== null)
                verifica = true;

            if(mes == null)
                verifica = true;

            if(verifica == false)
            {

                $.ajax({

                    type: 'POST',
                    url: 'php/presupuesto_ingresos_facturacion_buscar.php',
                    dataType:"json", 
                    data:
                    {
                        'id_unidad': $('#s_id_unidad').val(),
                        'id_sucursal': $('#s_id_sucursal').val(),
                        'anio': $('#i_anio').val(),
                        'mes': $('#i_mes').val(),
                        'tipo' : $('input[name=r_tipo]:checked').val()
                    },
                    success: function(data)
                    {
                       
                        //console.log(JSON.stringify(data));
                        if(data.length >0){
                           
                           
                            for(var i=0; data.length > i; i++)
                            {

                                var presupuesto = data[i];                        
                               
                                var importe = parseFloat(presupuesto.importe); 
                                var OI = parseFloat(presupuesto.otros_ingresos);
                                var total = parseFloat(presupuesto.total); 

                                var inputOtrosIngresos='<input type="text" class="form-control form-control-sm otrosIngresos numeroMoneda" valorAnterior="'+OI+'" value="'+formatearNumero(OI)+'" disabled="disabled"  autocomplete="off">';

                            if(presupuesto.editar=='si'){
                                    inputOtrosIngresos='<input type="text" class="form-control form-control-sm otrosIngresos numeroMoneda" valorAnterior="'+OI+'" value="'+formatearNumero(OI)+'" autocomplete="off"  >';
                                }         

                                var html = "<tr class='presupuesto-detalle' id='"+presupuesto.id+"' idDepartamento='"+presupuesto.id_departamento+"' idArea='"+presupuesto.id_area+"' importe='"+presupuesto.importe+"' folioFactura='" + presupuesto.folio_factura + "' vencimiento='" + presupuesto.vencimiento + "'>";
                                html += "<td>" + presupuesto.area + "</td>";
                                html += "<td>" + presupuesto.departamento + "</td>";
                                html += "<td>" + presupuesto.folio_factura + "</td>";
                                html += "<td>" + presupuesto.vencimiento + "</td>";
                                html += "<td>" + formatearNumeroCSS(importe.toFixed(2) + '') + "</td>";
                                html += "<td>" + inputOtrosIngresos+ "</td>";
                                html += "<td class='observaciones'>" + presupuesto.observaciones + "</td>";
                                html += "<td class='total' totalAnterior='"+total+"' align='right'>" + formatearNumeroCSS(total.toFixed(2) + '') +  "</td>";                                
                                html += "</tr>";
                               
                                $('#t_presupuesto > tbody').append(html);
                            
                            }

                        }else{
                           
                            mandarMensaje('No se encontró información con los datos ingresados, intenta con otros');
                        }

                    
                    },
                    error: function (xhr) 
                    {
                        console.log('php/presupuesto_ingresos_facturacion_buscar.php-->'+JSON.stringify(xhr));
                        mandarMensaje('Error en el sistema');
                    }

                });

           }

        }

        $(document).on('change','.otrosIngresos',function(){
            var otros=parseFloat(quitaComa($(this).val()));
            var importe = parseFloat($(this).parent().parent().attr('importe'));
            var total= otros+importe;
            $(this).parent().parent().find('.total').text(formatearNumero(total));
        });
        
        $('#b_guardar').on('click',function(){

            $('#b_guardar').prop('disabled',true);

            if ($('#f_p').validationEngine('validate')){
                
                if( $('.presupuesto-detalle').length > 0 ){
                    guardar();
                }else{
                    mandarMensaje('Debe haber por lo menos un registro para guardar esta información');
                    $('#b_guardar').prop('disabled',false);
                }
                

            }else{

                mandarMensaje('Debes llenar los filtros requeridos para poder guardar esta información');
                $('#b_guardar').prop('disabled',false);
            }
        });

        function guardar(){
      
            $.ajax({

                type: 'POST',
                url: 'php/presupuesto_ingresos_facturacion_guardar.php', 
                data:
                {
                    'id_unidad': $('#s_id_unidad').val(),
                    'id_sucursal': $('#s_id_sucursal').val(),
                    'anio': $('#i_anio').val(),
                    'mes': $('#i_mes').val(),
                    'datos' : obtenerPartidas(),
                    'idUsuario':idUsuario,
                    'modulo':modulo
                },
                success: function(data)
                {
                    console.log("Resutado:" +data);
                    $('#b_guardar').prop('disabled',false);
                    if(data > 0 ){

                        mandarMensaje('El presupuesto se guardó correctamente');
                        $('#b_excel').prop('disabled',false);

                    }else{

                        mandarMensaje('Ocurrio un error al guardar el presupuesto');
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/presupuesto_ingresos_facturacion_guardar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* Ocurrio un error al guardar el presupuesto');
                     $('#b_guardar').prop('disabled',false);
                }

            });

        }


        
        function obtenerPartidas()
        {

            var partidas = [];
            var contador = 0;
            $("#t_presupuesto tbody tr").each(function()
            {
                var id = $(this).attr('id');
                var idDepartamento = $(this).attr('idDepartamento');
                var idArea = $(this).attr('idArea');
                var importe = $(this).attr('importe');
                var folioFactura = $(this).attr('folioFactura');
                var vencimiento = $(this).attr('vencimiento');
                var otrosIngresos = quitaComa($(this).find('.otrosIngresos').val());
                var observaciones = $(this).find('.observaciones').text();
                var total = quitaComa($(this).find('.total').text());

                var otrosIngresosAnterior = $(this).find('.otrosIngresos').attr('valorAnterior');
                var totalAnterior = $(this).find('.total').attr('totalAnterior');
                var camposModificados = '';
               
                if(parseFloat(otrosIngresos) != parseFloat(otrosIngresosAnterior)){
                    camposModificados = camposModificados+'OTROS INGRESOS: '+otrosIngresosAnterior+' <br> TOTAL: '+totalAnterior+' <br>';
                    
                }
               
                contador++;
                partidas[contador] =
                {
                    'id': id,
                    'idDepartamento': idDepartamento, 
                    'idArea': idArea,
                    'importe': importe,
                    'otrosIngresos': otrosIngresos,
                    'observaciones': observaciones,
                    'total': total,
                    'factura' : folioFactura,
                    'vencimiento' : vencimiento,
                    'camposModificados' : camposModificados
                };
                
                
                
            });
            partidas[0] = contador;

           // console.log(JSON.stringify(partidas));

            return partidas;

        }


        function obtenerCamposModificados()
        {

            var camposModificados='';
            $("#t_presupuesto tbody tr").each(function()
            {
                var otrosIngresos = quitaComa($(this).find('.otrosIngresos').val());
                var otrosIngresosAnterior = $(this).find('.otrosIngresos').attr('valorAnterior');
                var totalAnterior = $(this).find('.total').attr('totalAnterior');
                
                if(parseFloat(otrosIngresos) != parseFloat(otrosIngresosAnterior)){
                    camposModificados = camposModificados+'OTROS INGRESOS: '+otrosIngresosAnterior+' <br> TOTAL: '+totalAnterior+' <br>';
                }else{
                    camposModificados = camposModificados + '';
                }
                
                
                
            });

            return camposModificados;

        }


        function generaFecha()
        {

            var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

            $('#i_mes').select2();
            $('#i_mes').html('');
            var html = '<option selected disabled>Selecciona</option>';
            $('#i_mes').append(html);

            var d = new Date();
            var monthC = d.getMonth() + 1;

            for(var i = 0; i < meses.length; i++)
            {
                var actual = meses[i];
                   
                var html = "<option value=" + (i+1) + ">" + actual + "</option>";
                $('#i_mes').append(html);

            }

        }

        $('#b_excel').click(function(){

            $('#b_excel').prop('disabled',true);

            if ($('#f_p').validationEngine('validate')){
                
                generaExcel();

            }else{
                mandarMensaje('Debes llenar todos los filtros');
                $('#b_excel').prop('disabled',false);
            }
        
            
        });

        function generaExcel(){
            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();

            var datos = {
                'idUnidad': $('#s_id_unidad').val(),
                'id_sucursal': $('#s_id_sucursal').val(),
                'sucursal' : $('select[name="s_id_sucursal"] option:selected').text(),
                'anio': $('#i_anio').val(),
                'mes': $('#i_mes').val(),
                'tipo' : $('input[name=r_tipo]:checked').val()
            };

            
            $("#i_nombre_excel").val('Presupuesto Ingresos Facturación');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(datos));
            
            $("#f_imprimir_excel").submit();
        }


        function verificaSiHayInformacion()
        {

            $('#t_presupuesto >tbody tr').remove();
            var idUnidad =  $('#s_id_unidad').val();
            var idSucursal = $('#s_id_sucursal').val();
            var anio = $('#i_anio').val();
            var mes = $('#i_mes').val();

           var verifica = false;
            if(idUnidad == null)
                verifica = true;

            if(idSucursal == null)
                verifica = true;

            if(anio== null)
                verifica = true;

            if(mes == null)
                verifica = true;

            if(verifica == false)
            {

                $.ajax({

                    type: 'POST',
                    url: 'php/presupuesto_ingresos_facturacion_verifica.php',
                    data:
                    {
                        'id_unidad': $('#s_id_unidad').val(),
                        'id_sucursal': $('#s_id_sucursal').val(),
                        'anio': $('#i_anio').val(),
                        'mes': $('#i_mes').val()
                    },
                    success: function(data)
                    {
                        if(data==1){
                           $('#b_excel').prop('disabled',false);
                        }else{
                            $('#b_excel').prop('disabled',true); 
                        }
                    },
                    error: function (xhr) 
                    {
                        console.log('php/presupuesto_ingresos_facturacion_verifica.php-->'+JSON.stringify(xhr));
                        mandarMensaje('Error en el sistema');
                    }

                });

           }

        }


    });

</script>

</html>