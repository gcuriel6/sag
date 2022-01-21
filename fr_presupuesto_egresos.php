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
    <div id="fondo_cargando"></div>
    <div class="container-fluid" id="div_principal">
    <form id="f_p" name="f_p">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Presupuesto de Egresos</div>
                    </div>
                    <div class="col-sm-12 col-md-1"><input id="i_id_sucursal" type="hidden"/></div>
                    <div class="col-sm-12 col-md-4">
                        <label for="s_id_unidad" class="col-form-label requerido">Unidad de Negocio </label>
                        <select id="s_id_unidad" name="s_id_unidad" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <!--<button type="button" class="btn btn-success btn-sm form-control" id="b_descargar"  onClick="window.location.href='excel/plantilla.xls'"><i class="fa fa-download" aria-hidden="true"></i> Descargar Plantilla</button>-->
                                <!--<button type="button" class="btn btn-success btn-sm form-control" id="b_descargar" onClick="window.location.href='excel/genera_plantilla.php'"><i class="fa fa-download" aria-hidden="true"></i> Descargar Plantilla</button>-->
                                <button type="button" class="btn btn-success btn-sm form-control" id="b_descargar"><i class="fa fa-download" aria-hidden="true"></i> Descargar Plantilla</button>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <?php
                                    $dia = date("d");
                                    $permisos = array(3,4,316,404);

                                    if($dia > 19 && $dia < 32){
                                        echo '<button type="button" class="btn btn-success btn-sm form-control" id="b_cargar"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Cargar Archivo Excel</button>';
                                    }else{                                        

                                        if(in_array($_SESSION["id_usuario"],$permisos)){
                                            echo '<button type="button" class="btn btn-success btn-sm form-control" id="b_cargar"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Cargar Archivo Excel</button>';
                                        }else{
                                            echo '<button type="button" class="btn btn-success btn-sm form-control" disabled><i class="fa fa-file-excel-o" aria-hidden="true"></i> Cargar Archivo Excel</button>';   
                                        }                                     
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="row" id="div_eliminar">
                            <div class="col-sm-12 col-md-3"></div>
                            <div class="col-sm-12 col-md-6">
                                <button type="button" class="btn btn-danger btn-sm form-control" id="b_eliminar_presupuesto"><i class="fa fa-trash" aria-hidden="true"></i>  Eliminar Presupuesto</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!--<div class="row">

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

                </div>-->

                <div class="row">

                    <div class="col-sm-12 col-md-2">
                        <label for="i_anio" class="col-sm-2 col-md-6 col-form-label requerido">Año </label>
                        <div class="col-sm-12 col-md-12">
                            <!--<input type="text" id="i_anio" name="i_anio" class="form-control izquierda" readonly autocomplete="off"/>-->
                            <select  id="i_anio" name="i_anio" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-2">
                        <label for="i_mes" class="col-sm-2 col-md-6 col-form-label requerido">Mes </label>
                        <div class="col-sm-12 col-md-12">
                            <select  id="i_mes" name="i_mes" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">

                        
                        <label for="" class="col-sm-2 col-md-6 col-form-label">&nbsp; </label>
                        <div class="col-sm-12 col-md-12">
                            Reemplazar Presupuetos Completo <input type="radio" name="rdb_tipo" id="r_todo" value="0" checked> 
                        <!--</div>-->
                        &nbsp;
                        <br>
                        <!--<div class="col-sm-12 col-md-12">-->
                            Actualizar Presupuesto <input type="radio" name="rdb_tipo" id="r_actualizar" value="1"> 
                        </div>

                    </div>

                    <div class="col-sm-12 col-md-3">

                        <label for="" class="col-sm-2 col-md-6 col-form-label">&nbsp; </label>                        
                        <form id="myform">
                            <input type="file" name="i_archivo_excel" id="i_archivo_excel" class="form-control form-control-sm">
                        </form> 

                    </div>
                    
                </div>

                <br>

                <div class="row">
                    <div class="col-sm-12 col-md-12">

                        <table class="tablon"  id="t_presupuesto">
                          <thead>
                            <tr class="renglon">  
                                <th scope="col">UNIDAD DE NEGOCIO</th>     
                                <th scope="col">SUCURSAL</th>                              
                                <!--<th scope="col">ÁREA</th> 
                                <th scope="col">DEPARTAMENTO INTERNO</th>-->
                                <th scope="col">FAMILIA</th>
                                <th scope="col">CLASIFICACIÓN</th>
                                <th scope="col">IMPORTE</th>
                                <th scope="col"></th>
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

    </div> <!--div_principal-->
    
</body>

<div id="dialog_detalles" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Relación factor prorrateo: <span id="dato_importe"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_factor_prorrateo">
                            <thead>
                                <tr class="renglon">                                
                                    <th scope="col">UNIDAD DE NEGOCIO</th> 
                                    <th scope="col">SUCURSAL</th>
                                    <th scope="col">FACTOR PRORRATEO</th>
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

<div id="dialog_confirm" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header alert-danger">
                <h5 class="modal-title">CANCELAR PRESUPUESTO EGRESOS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body alert-danger">
                <div class="row">
                    <div class="col-sm-12 col-md-3"></div>
                    <div class="col-sm-12 col-md-6" style="text-align:center; font-size:40px; color:black;">
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12"><h5>Se eliminará todo el presupuesto egresos del mes y año seleccionados. ¿Deseas continuar?</h5></div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-primary btn-lg" data-dismiss="modal"> NO </button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" id="b_cancelar_presupuesto" class="btn btn-danger btn-lg"> SI </button>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                </div>
            </div>
        </div>
    </div>
</div>
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
    var modulo = 'CARGAR';

    $(function()
    {

        mostrarBotonAyuda(modulo);
        //-->NJES December/11/2020 verifica si el usuario puede eliminar el presupuesto (aparece o no boton)
        //el presupuesto se elimina del año y mes seleccionado, el permiso se da directo en base de datos en la tabla usuarios en el campo b_eliminar_presupuesto
        verificaPermisoEliminar();

        //-->NJES December/07/2020 obtiene en lista los id de las unidades a las que tiene acceso el usuario
        function listaUnidadesNegocioId(datos)
        {
            var lista='';
            if(datos.length > 0)
            {
                for (i = 0; i < datos.length; i++) {
                    lista+=','+datos[i].id_unidad;
                }
            
            }else{
                lista='';
            }
            return lista;
        }

        //-->NJES December/07/2020 busca las unidades de negocio que meinimo tenga una sucursal con permiso por usuario y modulo
        buscarUnidadesSucursalPermisoUsuario('s_id_unidad',modulo,idUsuario,listaUnidadesNegocioId(matriz));
        
        //muestraSucursalesAcceso('s_id_sucursal', idUnidadActual, idUsuario); 
        generaAnio();
        generaMes();

        //$("#i_anio").val(new Date().getFullYear());

        $('#i_anio').change(function()
        {
            //buscarQuitar();
            generaMes();
        });

        $('#i_mes').change(function()
        {
            //buscarQuitar();
            //console.log('1');
            mostrarPresupuestoEgresos($('#i_anio').val(),$('#i_mes').val());
        });

        $('#s_id_unidad').change(function()
        {

            $('.img-flag').css({'width':'50px','height':'20px'});
            mostrarPresupuestoEgresos($('#i_anio').val(),$('#i_mes').val());

        });
        

        $('#radioBtn a').on('click', function()
        {

            var sel = $(this).data('title');
            var tog = $(this).data('toggle');
            $('#' + tog).prop('value', sel);
            
            $('a[data-toggle="' + tog + '"]').not('[data-title="' + sel + '"]').removeClass('btn-success').addClass('btn-secondary');
            $('a[data-toggle="' + tog + '"][data-title="' + sel + '"]').removeClass('btn-secondary').addClass('btn-success');

        });

        function buscarQuitar()
        {

            $('#t_presupuesto >tbody tr').remove();
            var anio = $('#i_anio').val();
            var mes = $('#i_mes').val();

            var verifica = false;

            if(anio== null)
                verifica = true;

            if(mes == null)
                verifica = true;

            if(verifica == false)
            {

                $.ajax({

                    type: 'POST',
                    url: 'php/presupuesto_egresos_buscar.php',
                    dataType:"json", 
                    data:
                    {
                        'anio': $('#i_anio').val(),
                        'mes': $('#i_mes').val()
                    },
                    success: function(data)
                    {

                        for(var i=0; data.length > i; i++)
                        {

                            var presupuesto = data[i];                        

                            var pm = parseFloat(presupuesto.monto);           

                            var html = "<tr class='presupuesto-detalle'>";
                            html += "<td>" + presupuesto.nombre_unidad + "</td>";
                            html += "<td>" + presupuesto.nombre_sucursal + "</td>";
                            //html += "<td>" + presupuesto.nombre_area + "</td>";
                            //html += "<td>" + presupuesto.nombre_depto + "</td>";
                            html += "<td>" + presupuesto.nombre_familia + "</td>";
                            html += "<td>" + (presupuesto.nombre_clasificacion == null ? '' : presupuesto.nombre_clasificacion) + "</td>";
                            html += "<td align='right'>" + formatearNumeroCSS(pm.toFixed(2) + '') +  "</td>";                                
                            if(presupuesto.prorrateo > 0)
                            {
                                html +="<td><button type='button' class='btn btn-secondary btn-sm b_relacion' alt="+presupuesto.id+" alt2="+presupuesto.monto+">\
                                    <i class='fa fa-eye' aria-hidden='true'></i>\
                                </button></td>";    
                            }else
                                html +="<td></td>";  

                            html += "</tr>";

                            $('#t_presupuesto tbody').append(html);
                        
                        }

                    
                    },
                    error: function (xhr) 
                    {
                        console.log('php/presupuesto_egresos_buscar.php-->'+JSON.stringify(xhr));
                        mandarMensaje('* No se encontro información al buscar');
                    }

                });

            }

        }

        function generaMes()
        {

            var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

            $('#i_mes').select2();
            $('#i_mes').html('');
            var html = '<option selected disabled>Selecciona</option>';
            $('#i_mes').append(html);

            var d = new Date();
            var monthC = d.getMonth();

            var anioActual = new Date().getFullYear()

            if($('#i_anio').val()==anioActual)
                var valor = monthC;
            else
                var valor = 0; 
            
            for(var i = valor; i < meses.length; i++)
            {
                var actual = meses[i];

                if(i==valor)
                    var html = "<option value=" + (i+1) + " selected>" + actual + "</option>";
                else
                    var html = "<option value=" + (i+1) + ">" + actual + "</option>";

                $('#i_mes').append(html);

            } 
            
            mostrarPresupuestoEgresos($('#i_anio').val(),monthC+1);
            console.log('*' + $('#s_id_unidad').val());

        }

        function generaAnio(){
            var anioActual = new Date().getFullYear();
            var anioSiguiente = new Date().getFullYear()+1;

            var anios = [anioActual,anioSiguiente];
            for(var j = 0; j < anios.length; j++)
            {
                var actual = anios[j];
                   
                if(actual==anioActual)
                    var html = "<option value=" + actual + " selected>" + actual + "</option>";
                else
                    var html = "<option value=" + actual + ">" + actual + "</option>";

                $('#i_anio').append(html);

            }
        }

        $('#b_cargar').click(function()
        {
            $('#b_cargar').prop('disabled',true);

            if($('#s_id_unidad').val() != '')
            {
                if($('#i_archivo_excel').val() == '')
                {
                    mandarMensaje('Debes seleccionar un archivo primero');
                    $('#b_cargar').prop('disabled',false);
                }else
                {

                    if($("#f_p").validationEngine('validate'))
                    {
                        $('#fondo_cargando').show();  
                        cargarXLS();
                        $('#b_cargar').prop('disabled',false);
                    }
                }
            }else{
                mandarMensaje('Debes seleccionar una unidad de negocio.');
                $('#b_cargar').prop('disabled',false);
            }

        });

        function cargarXLS()
        {
            var archivoExcel = document.getElementById("i_archivo_excel");//Damos el valor del input tipo file
            var archivoExcel = archivoExcel.files; //Obtenemos el valor del input (los archivos) en modo de arreglo
            var ruta = $('#i_archivo_excel').val();

            var ext = ruta.substr(ruta.length - 3); 
            if(ext == 'xls' || ext == 'XLS' )
            {

                if(window.XMLHttpRequest)
                    var Req = new XMLHttpRequest(); 
                else if(window.ActiveXObject) 
                    var Req = new ActiveXObject("Microsoft.XMLHTTP"); 
                
                var data = new FormData();
                data.append('i_excel', archivoExcel[0]);
                Req.open("POST","php/presupuesto_egreso_cargar.php", true);
            
                Req.onload = function(Event)
                {

                    if (Req.status == 200)
                    {
                
                        var msg = Req.responseText;
                        if(msg == 1)
                           verificaDatosExcel();
                         else
                         {
                            mandarMensaje(msg);
                            $('#fondo_cargando').hide();  
                         }
                         
                    }
                    else
                    {
                        console.log("Ocurrio al guardar el archivo: "+Req.status); //Vemos que paso. 
                        $('#fondo_cargando').hide();  
                    }
                };

                Req.send(data);

            }
            else
                mandarMensaje('Debes seleccionar un archivo excel con extensión xls');

        }

        function verificaDatosExcel()
        {

            var id_unidad = $('#s_id_unidad').val();
            var nombre = $('#s_id_unidad option:selected').text();

            // verificando ando

            $('#fondo_cargando').show();
            $('#t_presupuesto >tbody tr').remove();
            $.ajax({
                type: 'POST',
                url: 'php/presupuesto_egresos_verificar.php',
                dataType:"json", 
                data:
                {
                    'id_unidad_negocio' : id_unidad,
                    'nombre_unidad' : nombre,
                    'anio': $('#i_anio').val(),
                    'mes': $('#i_mes').val(),
                    'tipo': $('input[name=rdb_tipo]:checked').val()
                },
                success: function(data)
                {
                    //console.log('**'+data);
                    //console.log('**'+JSON.stringify(data));

                    console.log('**' + data.warning);

                    if(data.verifica == true)
                    {
                        mandarMensaje(data.warning);
                        $('#fondo_cargando').hide();  
                        $('#i_archivo_excel').val('');
                    }
                    else
                    {
                        mandarMensaje('El Presupuesto se cargo de forma exitosa');
                        $('#fondo_cargando').hide();
                        $('#i_archivo_excel').val('');
                        mostrarPresupuestoEgresos($('#i_anio').val(),$('#i_mes').val());
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/presupuesto_egresos_verificar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* Error en el sistema al verificar archivo excel');
                    $('#fondo_cargando').hide();  
                }

            });

        }

        function mostrarPresupuestoEgresos(anio,mes)
        {

            console.log('*' + $('#s_id_unidad').val());
            //console.log($('#i_anio').val()+' - '+$('#i_mes').val());
            $('#t_presupuesto >tbody tr').remove();

            $.ajax({
                type: 'POST',
                url: 'php/presupuesto_egresos_buscar.php',
                dataType:"json", 
                data:
                {
                    'anio': anio,
                    'mes': mes,
                    'id_unidad_negocio': $('#s_id_unidad').val()
                },
                success: function(data)
                {
                    if(data.length > 0)
                    {
                        for(var i=0; data.length > i; i++)
                        {
                            var presupuesto = data[i];                        

                            var pm = parseFloat(presupuesto.monto);

                            var html = "<tr class='presupuesto-detalle'>";
                            html += "<td>" + presupuesto.nombre_unidad + "</td>";
                            html += "<td>" + presupuesto.nombre_sucursal + "</td>";
                            //html += "<td>" + presupuesto.nombre_area + "</td>";
                            //html += "<td>" + presupuesto.nombre_depto + "</td>";
                            html += "<td>" + presupuesto.nombre_familia + "</td>";
                            html += "<td>" + (presupuesto.nombre_clasificacion == null ? '' : presupuesto.nombre_clasificacion) + "</td>";
                            html += "<td align='right'>" + formatearNumeroCSS(pm.toFixed(2) + '') +  "</td>"; 
                            if(presupuesto.prorrateo > 0)
                            {
                                html +="<td><button type='button' class='btn btn-secondary btn-sm b_relacion' alt="+presupuesto.id+" alt2="+presupuesto.monto+">\
                                    <i class='fa fa-eye' aria-hidden='true'></i>\
                                </button></td>";    
                            }else
                                html +="<td></td>";  

                            html += "</tr>";

                            $('#t_presupuesto tbody').append(html);
                        
                        }   
                        $('#fondo_cargando').hide();  
                    }else{
                        var html = "<tr><td colspan='6'>No se encontró información</td></tr>";
                        $('#t_presupuesto tbody').append(html);
                        $('#fondo_cargando').hide(); 
                    }                        
                },
                error: function (xhr) 
                {
                    console.log('php/presupuesto_egresos_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* Error en el sistema al buscar registros');
                    $('#fondo_cargando').hide();  
                }

            });
        }

        $(document).on('click','#t_presupuesto .b_relacion',function(){
            var id = $(this).attr('alt');
            var monto = $(this).attr('alt2');
            $('#t_factor_prorrateo tbody').html('');
            $('#dato_importe').text('');

            $.ajax({
                type: 'POST',
                url: 'php/presupuesto_egresos_buscar_relacion.php',
                dataType:"json", 
                data:{'idPresupuesto':id},
                success: function(data)
                {
                    $('#dato_importe').text(' $'+formatearNumero(monto));

                    for(var i=0; data.length > i; i++)
                    {
                        var dato = data[i];

                        var html='<tr alt="'+dato.id+'">\
                                <td>'+dato.unidad_negocio+'</td>\
                                <td>'+dato.sucursal+'</td>\
                                <td>'+formatearNumero(dato.factor_prorrateo)+'%</td>\
                            </tr>';

                        $('#t_factor_prorrateo tbody').append(html);
                    }

                    $('#dialog_detalles').modal('show');
                },
                error: function (xhr) 
                {
                    console.log('php/presupuesto_egresos_buscar_relacion.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontro información al buscar la relación del presupuesto.');
                }
            });
        });

        $('#b_descargar').click(function(){
            $('#b_descargar').prop('disabled',true);

            if($('#s_id_unidad').val() != '')
            {
                var id_unidad = $('#s_id_unidad').val();
                var nombre = $('#s_id_unidad option:selected').text();
                
                window.open('excel/genera_plantilla.php?id_unidad='+id_unidad+'&nombre='+nombre);
                $('#b_descargar').prop('disabled',false);
            }else{
                mandarMensaje('Debes seleccionar una unidad de negocio.');
                $('#b_descargar').prop('disabled',false);
            }
        });

        $('#b_eliminar_presupuesto').click(function(){
            $('#dialog_confirm').modal('show');
        });

        
        $('#b_cancelar_presupuesto').click(function(){
            $('#b_cancelar_presupuesto').prop('disabled',true);

            $.ajax({
                type: 'POST',
                url: 'php/presupuesto_egresos_eliminar.php',
                dataType:"json", 
                data:
                {
                    'anio': $('#i_anio').val(),
                    'mes': $('#i_mes').val()
                },
                success: function(data)
                {
                    console.log('eliminar: '+data);
                    if(data > 0)
                    {
                        mandarMensaje('Se elimino el presupuesto egresos');
                        mostrarPresupuestoEgresos($('#i_anio').val(),$('#i_mes').val());
                        $('#b_cancelar_presupuesto').prop('disabled',false);
                        $('#dialog_confirm').modal('hide');
                    }else{
                        mandarMensaje('Error al eliminar el presupuesto egresos');
                        $('#b_cancelar_presupuesto').prop('disabled',false);
                        $('#dialog_confirm').modal('hide');
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/presupuesto_egresos_eliminar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* Error al eliminar el presupuesto egresos.');
                    $('#b_cancelar_presupuesto').prop('disabled',false);
                }
            });
        });

        function verificaPermisoEliminar(){
            $.ajax({
                type: 'POST',
                url: 'php/presupuesto_egresos_verifica_permiso_eliminar.php', 
                data:{
                    'idUsuario' : idUsuario
                },
                success: function(data) {
                    if(data == 1)
                        $('#div_eliminar').show();
                    else
                        $('#div_eliminar').hide();
            
                },
                error: function (xhr) {
                    console.log('php/presupuesto_egresos_verifica_permiso_eliminar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* Error al eliminar el presupuesto egresos.');
                }
            });
        }

    });

</script>

</html>