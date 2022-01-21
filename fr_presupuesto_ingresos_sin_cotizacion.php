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

    .vencida td{
        background : #F8D7DA;
        color:#721C24;
    }
    
</style>

<body>
<div id="fondo_cargando"></div>
    <div class="container-fluid" id="div_principal">
    <form id="f_p" name="f_p">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Presupuesto de Ingresos Sin Cotización</div>
                    </div>

                    <div class="col-sm-12 col-md-6"></div>

                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel" title="Este Excel solo mostrará la información que ya se guardó, con los filtros ingresados"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                        
                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-12 col-md-3">
                        <label for="s_id_unidad" class="col-sm-8 col-md-8 col-form-label requerido">Unidad Negocio </label>
                        <div class="col-sm-12 col-md-12">
                            <select id="s_id_unidad" name="s_id_unidad" class="form-control validate[required]" autocomplete="off"></select>
                        </div>
                    </div>
                    
                    <div class="col-sm-12 col-md-3">
                        <label for="s_id_sucursal" class="col-sm-2 col-md-6 col-form-label">Sucursal </label>
                        <div class="col-sm-12 col-md-12">
                            <select id="s_id_sucursal" name="s_id_sucursal" class="form-control" autocomplete="off"></select>
                        </div>
                    </div>

                   <div class="col-sm-12 col-md-2">
                        <label for="i_anio" class="col-sm-2 col-md-6 col-form-label">Año </label>
                        <div class="col-sm-12 col-md-12">
                            <select  id="i_anio" name="i_anio" class="form-control validate[required]" autocomplete="off"/></select>   
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-2">
                        <label for="i_mes" class="col-sm-2 col-md-6 col-form-label requerido">Mes </label>
                        <div class="col-sm-12 col-md-12">
                            <select  id="i_mes" name="i_mes" class="form-control validate[required]" autocomplete="off"/></select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2 justify-content-center align-self-center" >
                          <button type="button" class="btn btn-info btn-sm form-control" id="b_buscar"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                    </div>

                </div>

                <br>

                <div class="row">
                    <div class="col-sm-12 col-md-12">

                        <table class="tablon"  id="t_presupuesto">
                          <thead>
                            <tr class="renglon">                                
                                <th scope="col">UNIDAD NEGOCIO</th> 
                                <th scope="col">SUCURSAL</th>
                                <th scope="col">FACTURA</th>
                                <th scope="col">FECHA</th>
                                <th scope="col">VENCE</th>
                                <th scope="col">CLIENTE</th>
                                <th scope="col">REFERENCIA</th>
                                <th scope="col">TOTAL</th>
                                <th scope="col">ESTATUS</th>
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
    var modulo = 'PRESUPUESTOS_INGRESOS_SIN_COTIZACION';
    var anioActual= new Date().getFullYear();
    var mesActual=(new Date().getMonth())+1;
    var idsSucursal='';
    $(function()
    {
        mostrarBotonAyuda(modulo);
        muestraSelectUnidades(matriz, 's_id_unidad', idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursal',idUnidadActual,modulo,idUsuario); 
        generaFecha();


        $('#b_excel').prop('disabled',true);

        
   
        buscarPresupuestoIngresos(muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario),$("#i_anio").val(),$("#i_mes").val());

        $('#s_id_unidad').change(function(){

            generaFecha();
            
            var idUnidadNegocio = $('#s_id_unidad').val();
            $('.img-flag').css({'width':'50px','height':'20px'});
            $('#s_id_sucursal').val('');
            muestraSucursalesPermiso('s_id_sucursal',idUnidadNegocio,modulo,idUsuario); 
            buscarPresupuestoIngresos(muestraSucursalesPermisoListaId(idUnidadNegocio,modulo,idUsuario),anioActual,mesActual);
            
            
            $('#t_presupuesto >tbody tr').remove();
           
        });

        $('#s_id_sucursal').change(function(){

            $('#b_buscar').prop('disabled',false);
            buscarPresupuestoIngresos($('#s_id_sucursal').val(),$("#i_anio").val(),$("#i_mes").val());
          
            $('#t_presupuesto >tbody tr').remove();

        });

        $('#i_mes').change(function(){

            $('#b_buscar').prop('disabled',false);
            $('#t_presupuesto >tbody tr').remove();

            if($('#s_id_sucursal').val()>0){
                buscarPresupuestoIngresos($('#s_id_sucursal').val(),$("#i_anio").val(),$("#i_mes").val());
            }else{
                buscarPresupuestoIngresos(muestraSucursalesPermisoListaId($('#s_id_unidad').val(),modulo,idUsuario),$("#i_anio").val(),$("#i_mes").val());
            }
        
        });

        $('#i_anio').change(function(){

            $('#b_buscar').prop('disabled',false);
            $('#t_presupuesto >tbody tr').remove();

            if($('#s_id_sucursal').val()>0){
                buscarPresupuestoIngresos($('#s_id_sucursal').val(),$("#i_anio").val(),$("#i_mes").val());
            }else{
                buscarPresupuestoIngresos(muestraSucursalesPermisoListaId($('#s_id_unidad').val(),modulo,idUsuario),$("#i_anio").val(),$("#i_mes").val());
            }
            
        });

        $('#b_buscar').on('click',function(){
            $('#b_buscar').prop('disabled',true);

            if ($('#f_p').validationEngine('validate')){
                

                if($('#s_id_sucursal').val() >= 1)
                {
                    buscarPresupuestoIngresos($('#s_id_sucursal').val(),$("#i_anio").val(),$("#i_mes").val());
                }else{
                    buscarPresupuestoIngresos(muestraSucursalesPermisoListaId($('#s_id_unidad').val(),modulo,idUsuario),$("#i_anio").val(),$("#i_mes").val());
                }
               

            }else{
                mandarMensaje('Debes llenar todos los filtros, para poder generar la búsqueda');
                $('#b_buscar').prop('disabled',false);
            }
        });


        function buscarPresupuestoIngresos(idSucursal,anio,mes)
        {   
            idsSucursal=idSucursal;//-- para enviar el id o ids a excel
            $('#fondo_cargando').show();

            $('#t_presupuesto >tbody tr').remove();
            var idUnidad =  $('#s_id_unidad').val();
            var anio = anio;//$('#i_anio').val();
            var mes = mes;//$('#i_mes').val();

           var verifica = false;
            if(idUnidad == null)
                verifica = true;

            if(anio== null)
                verifica = true;

            if(mes == null)
                verifica = true;

            if(verifica == false)
            {

                $.ajax({

                    type: 'POST',
                    url: 'php/presupuesto_ingresos_sin_cotizacion_buscar.php',
                    dataType:"json", 
                    data:
                    {
                        'id_unidad': $('#s_id_unidad').val(),
                        'id_sucursal': idSucursal,
                        'anio': $('#i_anio').val(),
                        'mes': $('#i_mes').val(),
                        'tipo' : 'mensual'
                    },
                    success: function(data)
                    {
                        if(data.length >0){
                            $('#b_excel').prop('disabled',false);
                            for(var i=0; data.length > i; i++)
                            {

                                var presupuesto = data[i];

                                var html = "<tr class='presupuesto-detalle " + presupuesto.vencida + "' estatus='"+presupuesto.estatus+"' razonSocial='"+presupuesto.razon_social+"' referencia='"+presupuesto.referencia+"' fecha='"+presupuesto.fecha+"' idSucursal='"+presupuesto.id_sucursal+"' idUnidad='"+presupuesto.id_unidad_negocio+"' id='"+ presupuesto.id +"' idRazonSocial='"+ presupuesto.id_razon_social +"' folioFactura='"+ presupuesto.folio_factura +"' vence='"+ presupuesto.vence +"' total='"+ presupuesto.total +"' observaciones='"+ presupuesto.observaciones +"'>";
                                html += "<td>" + presupuesto.unidad_negocio + "</td>";
                                html += "<td>" + presupuesto.sucursal + "</td>";
                                html += "<td>" + presupuesto.folio_factura + "</td>";
                                html += "<td>" + presupuesto.fecha + "</td>";
                                html += "<td>" + presupuesto.vence + "</td>";
                                html += "<td>" + presupuesto.razon_social + "</td>";
                                html += "<td>" + presupuesto.referencia + "</td>";
                                html += "<td style='text-align:right;'>" + formatearNumero(presupuesto.total) + "</td>";
                                html += "<td>" + presupuesto.estatus + "</td>";
                                html += "</tr>";
                               
                                $('#t_presupuesto > tbody').append(html);
                            
                            }

                            $('#fondo_cargando').hide();

                        }else{
                            $('#b_excel').prop('disabled',true);
                            $('#fondo_cargando').hide();
                            mandarMensaje('No se encontró información con los datos ingresados, intenta con otros');
                        }

                    
                    },
                    error: function (xhr) 
                    {
                        $('#b_excel').prop('disabled',true);
                        $('#fondo_cargando').hide();
                        console.log('php/presupuesto_ingresos_buscar.php-->'+JSON.stringify(xhr));
                        mandarMensaje('Error en el sistema');
                    }

                });

           }

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
            //--MGFS SE AGREGA 2 AÑOS ANTES Y UN AÑO DESPUES EN EL COMBO DE AÑO
            var anioC = new Date().getFullYear();

            $('#i_anio').select2();
            $('#i_anio').html('');
            var html = '<option selecte disabled>Selecciona</option>';
            html += "<option value='"+(parseInt(anioC)-2)+"'>" + (parseInt(anioC)-2) + "</option>";
            html += "<option value='"+(parseInt(anioC)-1)+"'>" + (parseInt(anioC)-1) + "</option>";
            html += "<option value='"+anioC+"'>" + anioC + "</option>";
            html += "<option value='"+(parseInt(anioC)+1)+"'>" + (parseInt(anioC)+1) + "</option>";
            $('#i_anio').append(html);

            $("#i_anio").val(new Date().getFullYear());
            $("#i_mes").val((new Date().getMonth())+1);

        }

        $('#b_excel').click(function(){

            $('#b_excel').prop('disabled',true);

            if ($('#f_p').validationEngine('validate')){
                
                generaExcel();
                $('#b_excel').prop('disabled',false);

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
                'idsSucursal':idsSucursal,
                'sucursal' : $('select[name="s_id_sucursal"] option:selected').text(),
                'anio': $('#i_anio').val(),
                'mes': $('#i_mes').val(),
                'tipo' : 'mensual'
            };
            
            $("#i_nombre_excel").val('Presupuesto Ingresos Sin Cotización');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(datos));
            
            $("#f_imprimir_excel").submit();
        }


    });

</script>

</html>