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
    }
    #div_contenedor{
        background-color: #ffffff;
    }
    #div_t_registros{
        max-height:190px;
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
    #dialog_buscar_caja_chica > .modal-lg{
        min-width: 80%;
        max-width: 80%;
    }

    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_t_registros{
            height:auto;
            overflow:auto;
        }
        #div_principal{
            margin-left:0%;
        }
        #dialog_buscar_caja_chica > .modal-lg{
            max-width: 100%;
        }
    }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10" id="div_contenedor">
            <br>
                <div class="form-group row">
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Caja Chica</div>
                    </div>
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_nuevo"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_buscar"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_imprimir" disabled><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>
                </div>

                <form id="forma" name="forma">
                    <div class="row">
                        <label for="i_folio" class="col-md-1 col-form-label">Folio </label>
                        <div class="col-md-2">
                            <input type="text" id="i_folio" name="i_folio" class="form-control form-control-sm" autocomplete="off" readonly>
                        </div>
                        <div class="col-md-1"></div>
                        <label for="i_saldo" class="col-md-1 col-form-label">Saldo </label>
                        <div class="col-md-2">
                            <input type="text" id="i_saldo" name="i_saldo" class="form-control form-control-sm" autocomplete="off" readonly>
                        </div>
                        <div class="col-md-1"></div>
                        <?php
                            $permisos = array(3,4,316,404);

                            if(in_array($_SESSION["id_usuario"],$permisos)){
                                echo '<input type="checkbox" id="ch_todostodos" name="ch_todostodos" value=""> Mostrar todos (todas las unidades)';
                            }
                        ?>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="s_id_unidades" class="col-form-label requerido">Unidad de Negocio </label>
                                    <select id="s_id_unidades" name="s_id_unidades" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="s_id_sucursales" class="col-form-label requerido">Sucursal</label>
                                    <select id="s_id_sucursales" name="s_id_sucursales" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="s_id_area" class="col-form-label">Área </label>
                                    <select id="s_id_area" name="s_id_area" class="form-control form-control-sm" disabled autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="s_id_departamento" class="col-form-label">Departamento</label>
                                    <select id="s_id_departamento" name="s_id_departamento" class="form-control form-control-sm" disabled autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label for="i_empleado" class="col-sm-12 col-md-3 col-form-label">Empleado</label>
                                        <div class="col-md-9">
                                            <input type="checkbox" id="ch_todos" name="ch_todos" value=""> Mostrar todos los Empleados(de la Unidad de Negocio)
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group col-md-12">
                                    <input type="text" id="i_empleado" name="i_empleado" class="form-control form-control-sm" readonly autocomplete="off">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_buscar_empleados" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="checkbox" id="ch_externo" name="ch_externo" value=""> Externo
                                </div>
                                <div class="col-md-12">
                                    <input type="text" id="i_empleado_externo" name="i_empleado_externo" class="form-control form-control-sm" autocomplete="off" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="row">
                                <label for="s_conceptos" class="col-md-3 col-form-label requerido">Concepto </label>
                                <div class="col-md-8">
                                    <select id="s_conceptos" name="s_conceptos" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="i_fecha" class="col-sm-12 col-md-3 col-form-label requerido">Fecha</label>
                                        <div class="input-group col-sm-12 col-md-8">
                                            <input type="text" name="i_fecha" id="i_fecha" class="form-control form-control-sm validate[required] fecha" autocomplete="off" readonly>
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
                                        <label for="i_total" class="col-md-3 col-form-label requerido">Total</label>
                                        <div class="col-md-8">
                                            <input type="text" id="i_total" name="i_total" class="form-control form-control-sm validate[required,custom[number],min[0.01]]" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="i_observaciones" class="col-form-label requerido">Observaciones </label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" id="i_observaciones" name="i_observaciones" class="form-control form-control-sm validate[required]" autocomplete="off">
                        </div>
                    </div>
                </form>

                <hr><!--linea gris-->
                <div class="row">
                    <div class="col-sm-12 col-md-12" style="text-align:center;">
                        <h5>Registros del Día <span id="dato_fecha_hoy"></span> de la sucursal seleccionada</h5>
                    </div>
                </div>
                <div class="row form-group" id="div_registros">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Concepto</th>
                                    <th scope="col">Folio</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Unidad de Negocio</th>
                                    <th scope="col">Sucursal</th>
                                    <th scope="col">Área</th>
                                    <th scope="col">Departamento</th>
                                    <th scope="col">Empleado</th>
                                    <th scope="col">obsrevación</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col">Cancelar</th>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_t_registros">
                            <table class="tablon"  id="t_registros">
                                <tbody>
                                    
                                </tbody>
                            </table>  
                        </div>  
                    </div>
                </div>

            <br>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
</body>

<div id="dialog_empleados" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Empleados</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_empleado" id="i_filtro_empleado" alt="renglon_empleado" class="filtrar_renglones form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off"></div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_empleados">
                        <thead>
                            <tr class="renglon">
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Iniciales</th>
                                <th scope="col">Puesto</th>
                                <th scope="col">Departamento</th>
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

<div id="dialog_buscar_caja_chica" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" style="overflow-y: scroll;" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Caja Chica</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <label for="s_filtro_unidad" class="col-md-2 col-form-label">Unidad de Negocio </label>
                <div class="col-md-4">
                    <select id="s_filtro_unidad" name="s_filtro_unidad" class="form-control form-control-sm" autocomplete="off" style="width:100%;"></select>
                </div>
                <label for="s_filtro_sucursal" class="col-md-1 col-form-label">Sucursal </label>
                <div class="col-md-4">
                    <select id="s_filtro_sucursal" name="s_filtro_sucursal" class="form-control form-control-sm filtros" autocomplete="off" style="width:100%;"></select>
                </div>
            </div>  
            <div class="row">
                <div class="col-sm-12 col-md-5">
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
                <div class="col-sm-12 col-md-6">
                    <input type="text" name="i_filtro_caja_chica" id="i_filtro_caja_chica" class="form-control form-control-sm filtrar_renglones" alt="renglon_caja_chica" placeholder="Filtrar" autocomplete="off">
                </div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_caja_chica_buscar">
                        <thead>
                            <tr class="renglon">
                                <th scope="col">Unidad de Negocio</th>
                                <th scope="col">Sucursal</th>
                                <th scope="col">Folio</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Concepto</th>
                                <th scope="col">Monto</th>
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
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
  
    var modulo='CAJA_CHICA';
    var idUnidadActual = <?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario = <?php echo $_SESSION['id_usuario']?>;
    //var anteriorClase = '';
    var saldoActual = 0;

    var matriz = <?php echo $_SESSION['sucursales']?>;
    $(function(){

        mostrarBotonAyuda(modulo);
        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        muestraSucursalesPermisoCajaChica('s_id_sucursales',idUnidadActual,modulo,idUsuario);
        muestraConceptosCxP('s_conceptos',4);  //-->busca los conceptos tipo caja chica

        muestraSelectUnidades(matriz,'s_filtro_unidad',idUnidadActual);
        muestraSucursalesPermisoCajaChica('s_filtro_sucursal',idUnidadActual,modulo,idUsuario);

        $('#i_fecha_inicio,#i_fecha_fin').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true,
        });

        console.log('**');

        $('#i_fecha_inicio').val(primerDiaMes);
        $('#i_fecha_fin').val(hoy);

        $('#i_fecha').val(hoy);
        $('#dato_fecha_hoy').text(hoy);

        //anteriorClase = $('#i_total').attr('class');

        $('#s_id_unidades').change(function(){
            muestraSucursalesPermisoCajaChica('s_id_sucursales',$('#s_id_unidades').val(),modulo,idUsuario);
        });

        $('#s_id_sucursales').change(function(){
            //anteriorClase = $('#i_total').attr('class');
            muestraAreasAcceso('s_id_area');
            $('#s_id_area').prop('disabled',false);
            muestraSaldoDisponible($('#s_id_sucursales').val());

        });

        $('#s_id_area').change(function(){
            muestraDepartamentoAreaInternos('s_id_departamento', $('#s_id_sucursales').val(), $('#s_id_area').val());
            $('#s_id_departamento').prop('disabled',false);
        });

        $('#ch_externo').change(function(){
            $('#i_empleado').val('');
            $('#ch_todos').prop('checked',false);
            if($("#ch_externo").is(':checked'))
            {
                $('#i_empleado_externo').addClass('validate[required]').prop('disabled',false);
            }else{
                $('#i_empleado_externo').removeClass('validate[required]').prop('disabled',true);
            }
        });

        $('#ch_todos').change(function(){
            $('#i_empleado_externo').val('').removeClass('validate[required]').prop('disabled',true);
            $('#ch_externo').prop('checked',false);
        });

        $('#b_buscar_empleados').click(function(){
            $('#i_filtro_empleado').val('');
            if($("#ch_todostodos").is(':checked')){
                muestraModalEmpleadosTodosUnidades('renglon_empleado','t_empleados tbody','dialog_empleados');
            }else{
                if($("#ch_todos").is(':checked')){
                    if(($('#s_id_unidades').val() != null)){
                        muestraModalEmpleadosUnidad('renglon_empleado','t_empleados tbody','dialog_empleados',$('#s_id_unidades').val());
                    }else{
                        mandarMensaje('Seleccionar Sucursal para buscar información');
                    }
                }else{
                    if(($('#s_id_sucursales').val() != null)){
                        muestraModalEmpleadosIdSucursal('renglon_empleado','t_empleados tbody','dialog_empleados',$('#s_id_sucursales').val());
                    }else{
                        mandarMensaje('Seleccionar Sucursal para buscar información');
                    }
                }
            }
        });

        $('#t_empleados').on('click', '.renglon_empleado', function() {
            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            var numeroEmpleado = $(this).attr('alt3');
            $('#i_empleado').attr('alt',id).val(numeroEmpleado+' - '+nombre);
            $('#dialog_empleados').modal('hide');

            $("#ch_externo").prop('checked',false);
            $('#i_empleado_externo').val('').removeClass('validate[required]').prop('disabled',true);
        });

        $('#i_total').on('change',function(){

            //anteriorClase = $('#i_total').attr('class');

            if($(this).validationEngine('validate')==false) {

                var monto=quitaComa($('#i_total').val());

                if(monto==''){
                    monto=0;
                }

                if(monto > 0){

                    $('#i_total').val(formatearNumero(parseFloat(monto)));

                }else{
                    $('#i_total').val(0);
                }

            }else{
                if(quitaComa($('#i_total').val()) != '')
                {
                    var monto = quitaComa($('#i_total').val());
                }else{
                    var monto = 0;
                }
                $('#i_total').val(monto);
            }
        });

        function muestraSaldoDisponible(idSucursal){
            saldoActual = 0;
            $('#i_saldo').val('');
            $.ajax({
                type: 'POST',
                url: 'php/caja_chica_saldo_actual_buscar.php',
                dataType:"json", 
                data:{'idSucursal' : idSucursal},
                success: function(data)
                {
                    if(data.length > 0)
                    {
                        $('#i_saldo').val(formatearNumero(data[0].saldo));
                        saldoActual = parseFloat(data[0].saldo);   

                        /*if(parseFloat(data[0].saldo) > 0)
                        {
                            $('#i_total').removeClass('').addClass('form-control form-control-sm validate[required,custom[number],min[0.01],max['+parseFloat(data[0].saldo)+']]');
                        }else{
                            $('#i_total').removeClass(anteriorClase).addClass('form-control form-control-sm validate[required,custom[number],min[0.01]]');
                        }*/

                        muestraRegistros(idSucursal);
                    }
                },
                error: function (xhr) {
                    console.log("caja_chica_saldo_actual_buscar.php--> "+JSON.stringify(xhr));    
                    mandarMensaje('* No se encontró información de saldo');
                }
            });
        }

        $('#b_guardar').click(function(){
            $('#b_guardar').prop('disabled',true);

            if($('#forma').validationEngine('validate'))
            {
                //NJES GASTOS (2) (DEN18-2424) verificar que exista una cuenta banco caja chica de la sucursal seleccionada cuando se insertara movimiento a caja chica de sucursal Dic/26/2019
                if(existeCajaChicaSucursal($('#s_id_sucursales').val()) == 1)
                {
                    var concepto = $('#s_conceptos option:selected').attr('alt');
                    if(concepto == 'D01'){
                        //--> Si es un cargo no comparo mi saldo disponible de la cuenta por que es un ingreso a mi
                        guardar();
                    }else{
                        if(parseFloat(quitaComa($('#i_saldo').val())) > 0)
                        { 
                            if(parseFloat(quitaComa($('#i_total').val())) <= parseFloat(quitaComa($('#i_saldo').val())))
                            {
                                guardar();
                            }else{
                                mandarMensaje('El total no puede ser mayor al saldo disponible de la caja chica de la sucursal');
                                $('#b_guardar').prop('disabled',false);
                            }
                        }else{
                            mandarMensaje('No es posible realizar un movimiento cuando el saldo es 0');
                            $('#b_guardar').prop('disabled',false);
                        }
                    }
                }else{
                    mandarMensaje('No existe una cuenta banco caja chica para la sucursal, solicita crearla o activarla.');
                    $('#b_guardar').prop('disabled',false);
                }
            }else{
                $('#b_guardar').prop('disabled',false);
            }
        });

        function guardar(){
            var info = {
                'folio' : $('#i_folio').val(),
                'idUnidadNegocio' : $('#s_id_unidades').val(),
                'idSucursal' : $('#s_id_sucursales').val(),
                'idArea' : $('#s_id_area').val(),
                'idDepartamento' :  $('#s_id_departamento').val(),
                'idConcepto' :  $('#s_conceptos').val(),
                'claveConcepto' : $('#s_conceptos option:selected').attr('alt'),
                'fecha' : $('#i_fecha').val(),
                'idEmpleado' : $('#i_empleado').attr('alt'),
                'empleado' : $('#i_empleado_externo').val(),
                'importe' : quitaComa($('#i_total').val()),
                'observaciones' : $('#i_observaciones').val(),
                'idUsuario' : idUsuario
            };

            $.ajax({
                type: 'POST',
                url: 'php/caja_chica_guardar.php',
                data:  {'datos':info},
                success: function(data) {
                    if(data > 0 )
                    { 
                        mandarMensaje('Se realizo el proceso correctamente');
                        limpiar();
                        muestraSaldoDisponible($('#s_id_sucursales').val());
                        $('#b_guardar').prop('disabled',false);
                        generaFormato(data);
                    }else{ 
                        mandarMensaje('Error al guardar.');
                        $('#b_guardar').prop('disabled',false);
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/caja_chica_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al guardar.');
                    $('#b_guardar').prop('disabled',false);
                }
            });
        }

        ///muestra los movimientos del día
        function muestraRegistros(idSucursal){
            $('#t_registros tbody').empty();
            $('#t_registros tbody').html('');
            var contF=0;
            $.ajax({
                type: 'POST',
                url: 'php/caja_chica_buscar_hoy.php',
                dataType:"json", 
                data:  {'idSucursal':idSucursal},
                success: function(data) {
                    if(data.length != 0){
                        
                        var num=data.length;
                        for(var i=0;data.length>i;i++){

                            if(data[i].nombre_empleado != '')
                            {
                                var empleado = data[i].nombre_empleado;
                            }else{
                                var empleado = data[i].empleado;
                            }

                            if(data[i].clave_concepto == 'C01')
                            {
                                var boton = '';
                                var folio = 'N/A';
                            }else{
                                var folio = data[i].folio;
                                if(data[i].estatus == 0)
                                {
                                    var boton = '';
                                    //--> compara si el dato es un valor positivo
                                    if(Math.sign(data[i].importe)  == 1)
                                    {
                                        var cancelado = 'style="background-color:#ffe6e6;"';
                                    }else{
                                        var cancelado = '';
                                    }
                                }else{
                                    var boton = '<button type="button" class="btn btn-danger btn-sm b_cancelar" alt="'+data[i].id+'">\
                                                    <i class="fa fa-ban" aria-hidden="true"></i>\
                                            </button>';

                                    var cancelado = '';
                                }

                                contF=parseInt(data[i].folio);
                                
                            }
                        
                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon" '+cancelado+'>\
                                        <td data-label="Concepto">'+data[i].concepto+'</td>\
                                        <td data-label="Folio">'+folio+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Unidad de Negocio">'+data[i].unidad_negocio+'</td>\
                                        <td data-label="Sucursal">'+data[i].sucursal+'</td>\
                                        <td data-label="Área">'+data[i].area+'</td>\
                                        <td data-label="Departamento">'+data[i].departamento+'</td>\
                                        <td data-label="Empleado">'+empleado+'</td>\
                                        <td data-label="Observación">'+data[i].observaciones+'</td>\
                                        <td data-label="Monto">$'+formatearNumero(data[i].importe)+'</td>\
                                        <td>'+boton+'</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros tbody').append(html);   
                            
                        }

                        $('#i_folio').val(contF+1);

                    }else{
                        var html='<tr class="renglon">\
                                        <td colspan="10">No se encontró información.</td>\
                                    </tr>';

                        $('#t_registros tbody').append(html);

                        //$('#i_folio').val(1);
                    }

                },
                error: function (xhr) 
                {
                    console.log('php/caja_chica_buscar_hoy.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar caja chica');
                }
            });
        }

        $(document).on('click','.b_cancelar',function(){
            var idRegistro = $(this).attr('alt');
            
            $.ajax({
                type: 'POST',
                url: 'php/caja_chica_cancelar.php',
                data:{'idRegistro':idRegistro},
                success: function(data) {
                    if(data > 0 )
                    { 
                        muestraSaldoDisponible($('#s_id_sucursales').val());
                    }else{ 
                        mandarMensaje('Error al cancelar.');
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/caja_chica_cancelar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al cancelar.');
                }
            });
        });

        function generaFormato(idRegistro){
            var tipo = 1;

            var datos = {
                'path':'formato_caja_chica',
                'idRegistro':idRegistro,
                'nombreArchivo':'caja_chica',
                'tipo':tipo
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_new');
        }

        $('#b_nuevo').click(function(){
            muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
            muestraSucursalesPermisoCajaChica('s_id_sucursales',idUnidadActual,modulo,idUsuario);
            muestraConceptosCxP('s_conceptos',4); //-->busca los conceptos tipo caja chica

            $('#s_id_area').val('').select2({placeholder: ''}).prop('disabled',true);
            $('#s_id_departamento').val('').select2({placeholder: ''}).prop('disabled',true);

            $('#forma input').val('');
            $('#i_empleado').attr('alt',0)
            $('#forma').validationEngine('hide');
            $("#ch_externo").prop('checked',false);
            $('#ch_todos').prop('checked',false);
            $('#i_empleado_externo').val('').removeClass('validate[required]').prop('disabled',true);
            $('#i_total').removeClass('form-control form-control-sm validate[required,custom[number],min[0.01],max['+saldoActual+']]').addClass('form-control form-control-sm validate[required,custom[number],min[0.01]]');
            saldoActual = 0;
            $('#i_fecha').val(hoy);
            $('#t_registros tbody').empty();
            $('#forma input, select').prop('disabled',false);
            $('#b_buscar_empleados,#b_guardar').prop('disabled',false);
            $('#i_fecha').prop('disabled',true);
            $('#b_imprimir').prop('disabled',true).attr('alt',0);
        });

        function limpiar(){
            muestraConceptosCxP('s_conceptos',4); //-->busca los conceptos tipo caja chica

            $('#s_id_area').val('').select2({placeholder: ''});
            $('#s_id_departamento').val('').select2({placeholder: ''}).prop('disabled',true);

            $('#forma input').val('');
            $('#i_empleado').attr('alt',0)
            $('#forma').validationEngine('hide');
            $("#ch_externo").prop('checked',false);
            $('#ch_todos').prop('checked',false);
            $('#i_empleado_externo').val('').removeClass('validate[required]').prop('disabled',true);
            $('#i_fecha').val(hoy);
        }

        $('#b_buscar').click(function()
        {

            $('#dialog_buscar_caja_chica').modal('show');
            $('#i_filtro_caja_chica').val('');
            $('#s_filtro_unidad,#s_filtro_sucursal').prop('disabled',false);
            muestraSucursalesPermisoCajaChica('s_filtro_sucursal',$('#s_filtro_unidad').val(),modulo,idUsuario);
            $('#t_caja_chica_buscar tbody').empty();
            // verificando
        });

        //-->NJES March/12/2020 se limpia busqueda registros
        $('#s_filtro_unidad').change(function(){
            $('.img-flag').css('height','20px');
            muestraSucursalesPermisoCajaChica('s_filtro_sucursal',$('#s_filtro_unidad').val(),modulo,idUsuario);
            $('#t_caja_chica_buscar tbody').empty();
        });

        $('#s_filtro_sucursal,#i_fecha_inicio,#i_fecha_fin').change(function(){
            //-->NJES March/12/2020 indica que tiene que seleccionar una sucursal para comeenzar la busqueda
            if($('#s_filtro_sucursal').val() > 0 || $('#s_filtro_sucursal').val() != null)
            {
                var idSucursal = $('#s_filtro_sucursal').val();
                muestraRegistrosCajaChica(idSucursal);
            }else{
                mandarMensaje('Selecciona una sucursal para comenzar a buscar.');
            }
        });

        function muestraRegistrosCajaChica(idSucursal){
            $('#t_caja_chica_buscar tbody').empty();

            var info = {
                'idSucursal' : idSucursal,
                'fechaInicio' : $('#i_fecha_inicio').val(),
                'fechaFin' : $('#i_fecha_fin').val()
            };

            $.ajax({
                type: 'POST',
                url: 'php/caja_chica_buscar.php',
                dataType:"json", 
                data:  {'datos':info},
                success: function(data) {
                    if(data.length != 0){
                        
                        var num=data.length;
                        for(var i=0;data.length>i;i++){

                            if(data[i].clave_concepto == 'C01')
                                var folio = 'N/A';
                            else
                                var folio = data[i].folio;

                        
                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_caja_chica" alt="'+data[i].id+'" sucursal="'+data[i].id_sucursal+'" area="'+data[i].id_area+'">\
                                        <td data-label="Unidad de Negocio">'+data[i].unidad_negocio+'</td>\
                                        <td data-label="Sucursal">'+data[i].sucursal+'</td>\
                                        <td data-label="Folio">'+folio+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Concepto">'+data[i].concepto+'</td>\
                                        <td data-label="Monto">'+data[i].importe+'</td>\
                                        <td data-label="Estatus">'+data[i].estatus+'</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_caja_chica_buscar tbody').append(html);   
                            
                        }

                    }else{
                        var html='<tr class="renglon">\
                                        <td colspan="7">No se encontró información</td>\
                                    </tr>';

                        $('#t_caja_chica_buscar tbody').append(html);
                    }

                },
                error: function (xhr) 
                {
                    console.log('php/caja_chica_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar caja chica');
                }
            });
        }

        $('#t_caja_chica_buscar').on('click', '.renglon_caja_chica', function()
        {

            var id = $(this).attr('alt');
            var id_sucursal = $(this).attr('sucursal');
            var id_area = $(this).attr('area');

            console.log('ID ->' + id);

            muestraDepartamentoAreaInternos('s_id_departamento', id_sucursal, id_area);

            $.ajax({
                type: 'POST',
                url: 'php/caja_chica_buscar_id.php',
                dataType:"json", 
                data:  {'idCajaChica':id},
                success: function(data)
                {

                    $('#s_id_unidades').val(data[0].id_unidad_negocio);
                    $("#s_id_unidades").select2({
                        templateResult: setCurrency,
                        templateSelection: setCurrency
                    });
                    //$('#s_almacen').select2({placeholder: $(this).data('elemento')});
                    $('.img-flag').css({'width':'50px','height':'20px'}); //Cambia el tamaño de la imagen que se mostrara en el selectB

                    console.log(' ********** ' + data[0].id_unidad_negocio);

                    var optionSurucursal = new Option(data[0].sucursal, data[0].id_sucursal, true, true);
                    $('#s_id_sucursales').append(optionSurucursal);

                    var optionArea = new Option(data[0].area, data[0].id_area, true, true);
                    $('#s_id_area').append(optionArea).trigger('change');

                    var optionDepto = new Option(data[0].departamento, data[0].id_departamento, true, true);
                    $('#s_id_departamento').append(optionDepto).trigger('change');

                    var optionConcepto = new Option(data[0].concepto, data[0].id_concepto, true, true);
                    $('#s_conceptos').append(optionConcepto).trigger('change');

                    $('#i_observaciones').val(data[0].observaciones);
                    $('#i_total').val(data[0].importe);

                    if(data[0].id_empleado > 0)
                    {
                        $('#i_empleado').val(data[0].nombre_empleado).attr('alt',data[0].id_empleado);
                    }else{
                        $('#ch_externo').prop('checked',true);
                        $('#i_empleado_externo').val(data[0].nombre_empleado);
                    }

                    $('#i_folio').val(data[0].folio);
                    console.log('FOLIO -> ' + data[0].folio);

                    ////$('#forma input, select').prop('disabled',true);
                    $('#b_buscar_empleados,#b_guardar').prop('disabled',true);

                    $('#b_imprimir').prop('disabled',false).attr('alt',id);

                    $('#i_fecha').val(data[0].fecha);

                    muestraSaldoDisponible(data[0].id_sucursal);

                },
                error: function (xhr) 
                {
                    console.log('php/caja_chica_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar caja chica');
                }
            });

            $('#dialog_buscar_caja_chica').modal('hide');
        });

        $('#b_imprimir').click(function(){
            var id = $(this).attr('alt');
            
            generaFormato(id);
        });

    });

</script>

</html>