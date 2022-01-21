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
    }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">CxP</div>
                    </div>
                    <div class="col-sm-12 col-md-3"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-danger btn-sm form-control" id="b_cancelar" disabled><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_nuevo"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_estado_cuenta" disabled><i class="fa fa-list-alt" aria-hidden="true"></i> Estado de Cuenta</button>
                    </div>
                </div>

                <div class="row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>
                    
                <form id="forma_cxp" name="forma_cxp">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row">
                                <label for="i_proveedor" class="col-md-12 col-form-label">Proveedor</label>
                                <div class="input-group col-sm-12 col-md-12">
                                    <input type="text" id="i_proveedor" name="i_proveedor" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_buscar_proveedor" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <label for="i_factura" class="col-md-12 col-form-label">Factura</label>
                                <div class="input-group col-sm-12 col-md-12">
                                    <input type="text" id="i_factura" name="i_factura" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_buscar_factura" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="s_cuenta_banco" class="col-form-label">Cuenta Banco </label>
                            <select id="s_cuenta_banco" name="s_cuenta_banco" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label for="s_concepto_cxp" class="col-form-label">Concepto </label>
                            <select id="s_concepto_cxp" name="s_concepto_cxp" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group row">
                                <label for="i_fecha" class="col-sm-12 col-md-12 col-form-label">Fecha</label>
                                <div class="input-group col-sm-12 col-md-12">
                                    <input type="text" name="i_fecha" id="i_fecha" class="form-control form-control-sm validate[required] fecha" autocomplete="off" readonly>
                                    <div class="input-group-addon input_group_span">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="i_importe" class="col-form-label">Importe</label>
                            <input type="text" id="i_importe" name="i_importe" class="form-control form-control-sm validate[required,custom[number],min[0.01]]" autocomplete="off">
                        </div>
                        <div class="col-md-3">
                            <label for="i_referencia" class="col-form-label">Referencia</label>
                            <input type="text" id="i_referencia" name="i_referencia" class="form-control form-control-sm validate[required]"  autocomplete="off">
                        </div>
                        <div class="col-md-2">
                            <br>
                            <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                        </div>
                    </div>
                </form>

                <hr><!--linea gris-->

                <div class="row form-group" id="div_registros">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Concepto</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Cargos</th>
                                    <th scope="col">Abonos</th>
                                    <th scope="col">Referencia</th>
                                    <th scope="col"></th>
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

                <div class="row">
                    <div class="col-sm-12 col-md-7"></div>
                    <div class="col-sm-12 col-md-4">
                        <div class="row">
                            <label for="i_saldo" class="col-sm-12 col-md-3 col-form-label">Saldo </label>
                            <div class="col-md-6">
                                <input type="text" id="i_saldo" name="i_saldo" class="form-control form-control-sm" autocomplete="off" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            <br>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
</body>

<div id="dialog_proveedores" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Proveedores</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <input type="text" name="i_filtro_proveedor" id="i_filtro_proveedor" alt="renglon_proveedor" class="filtrar_renglones form-control" placeholder="Filtrar" autocomplete="off">
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-1">Del: </div>
                            <div class="input-group col-sm-12 col-md-5">
                                <input type="text" name="i_fecha_inicio_p" id="i_fecha_inicio_p" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                                <div class="input-group-addon input_group_span">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-1">Al: </div>
                            <div class="input-group col-sm-12 col-md-5">
                                <input type="text" name="i_fecha_fin_p" id="i_fecha_fin_p" class="form-control form-control-sm fecha" autocomplete="off" readonly disabled>
                                <div class="input-group-addon input_group_span">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_proveedores">
                        <thead>
                            <tr class="renglon">
                            <th scope="col">Clave</th>
                            <th scope="col">RFC</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Grupo</th>
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
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
</div>

<div id="dialog_facturas" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Facturas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <input type="text" name="i_filtro_factura" id="i_filtro_factura" alt="renglon_factura" class="filtrar_renglones form-control" placeholder="Filtrar" autocomplete="off">
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-1">Del: </div>
                            <div class="input-group col-sm-12 col-md-5">
                                <input type="text" name="i_fecha_inicio_f" id="i_fecha_inicio_f" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                                <div class="input-group-addon input_group_span">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-1">Al: </div>
                            <div class="input-group col-sm-12 col-md-5">
                                <input type="text" name="i_fecha_fin_f" id="i_fecha_fin_f" class="form-control form-control-sm fecha" autocomplete="off" readonly disabled>
                                <div class="input-group-addon input_group_span">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
                <span class="label label-default" style="font-size:10px; color:#F0AD4E;">Se mostraran los cargos que tuvieron un movimiento en el rango de fechas ingresado, por defaul muestra lo del mes actual.</span>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_facturas">
                        <thead>
                            <tr class="renglon">
                                <th scope="col">Factura</th>
                                <th scope="col">Proveedor</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Concepto</th>
                                <th scope="col">Estatus</th>
                                <th scope="col">Importe</th>
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

<div id="dialog_cancelar" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cancelar CxP</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="form_cancelar" name="form_cancelar">
                <div class="row">
                    <div class="col-md-12">
                        <label for="ta_justificacion">Justificación</label>
                        <textarea class="form-control validate[required]" id="ta_justificacion" rows="3"></textarea>
                    </div>
                </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="b_guardar_cancelar" class="btn btn-danger"><i class="fa fa-floppy-o" aria-hidden="true"></i> Cancelar</button>
      </div>
    </div>
  </div>
</div>

<div id="dialog_cancelar_partida" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cancelar partida CxP</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="form_cancelar" name="form_cancelar">
                <div class="row">
                    <div class="col-md-12">
                        <label for="ta_justificacion_partida">Justificación</label>
                        <textarea class="form-control validate[required]" id="ta_justificacion_partida" rows="3"></textarea>
                    </div>
                </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="b_guardar_cancelar_partida" class="btn btn-danger"><i class="fa fa-floppy-o" aria-hidden="true"></i> Cancelar</button>
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
  
    var modulo='CXP';
    var idUnidadActual = <?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario = <?php echo $_SESSION['id_usuario']?>;
    var saldoActual = 0;
    var cargoInicial = 0;
    var anteriorClase = '';
    var banderaCancela='';
    var saldoDisponibleCuentaB=0;

    var matriz = <?php echo $_SESSION['sucursales']?>;
    $(function(){

        mostrarBotonAyuda(modulo);

        muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);
        //NJES Jan/21/2020 solo mostrar las cuentas bancos de tipo banco porque en cxp solo se puede pagar de bancos
        //en el tercer parametro se especifica 1= solo mostrar cuentas tipo banco, 0= mostrar todos tipos de cuentas
        //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
        muestraCuentasBancosSaldosPermiso('s_cuenta_banco', 0,1,idUnidadActual);
        muestraConceptosCxP('s_concepto_cxp',1);

        $(document).on('change','#s_concepto_cxp',function(){
            var concepto = $('#s_concepto_cxp option:selected').attr('alt');
            $('#s_cuenta_banco').removeClass('validate[required]');
            if(concepto=='A02'){
                $('#s_cuenta_banco').prop('disabled',true);
            }else{
                $('#s_cuenta_banco').addClass('validate[required]');
                $('#s_cuenta_banco').prop('disabled',false);
            }
        });

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        });
        
        $('#b_buscar_proveedor').click(function(){
            $('#i_filtro_proveedor').val('');
            $('#i_fecha_inicio_p').val('');
            $('#i_fecha_fin_p').val('');

            if($('#i_factura').val() == '')
            {
                muestraModalProveedoresCxP('renglon_proveedor','t_proveedores tbody','dialog_proveedores',0,$('#i_fecha_inicio_p').val(),$('#i_fecha_fin_p').val());
            }else{
                var factura = $('#i_factura').attr('alt');
                muestraModalProveedoresCxP('renglon_proveedor','t_proveedores tbody','dialog_proveedores',factura,$('#i_fecha_inicio_p').val(),$('#i_fecha_fin_p').val());
            }
        });

        $('#i_fecha_inicio_p').change(function(){
            if($('#i_fecha_inicio_p').val() != '')
            {
                $('#i_fecha_fin_p').prop('disabled',false);
                if($('#i_factura').val() == '')
                {
                    muestraModalProveedoresCxP('renglon_proveedor','t_proveedores tbody','dialog_proveedores',0,$('#i_fecha_inicio_p').val(),$('#i_fecha_fin_p').val());
                }else{
                    var factura = $('#i_factura').attr('alt');
                    muestraModalProveedoresCxP('renglon_proveedor','t_proveedores tbody','dialog_proveedores',factura,$('#i_fecha_inicio_p').val(),$('#i_fecha_fin_p').val());
                }
            }
        });

        $('#i_fecha_fin_p').change(function(){
            if($('#i_factura').val() == '')
            {
                muestraModalProveedoresCxP('renglon_proveedor','t_proveedores tbody','dialog_proveedores',0,$('#i_fecha_inicio_p').val(),$('#i_fecha_fin_p').val());
            }else{
                var factura = $('#i_factura').attr('alt2');
                muestraModalProveedoresCxP('renglon_proveedor','t_proveedores tbody','dialog_proveedores',factura,$('#i_fecha_inicio_p').val(),$('#i_fecha_fin_p').val());
            }
        });

        $('#t_proveedores').on('click', '.renglon_proveedor', function() {
            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            $('#i_proveedor').attr('alt',id).val(nombre);
            $('#dialog_proveedores').modal('hide');
            $('#b_estado_cuenta').prop('disabled',false);
        });

        $('#b_buscar_factura').click(function(){
            $('#i_filtro_factura').val('');
            $('#i_fecha_inicio_f').val('');
            $('#i_fecha_fin_f').val('');

            if($('#i_proveedor').val() == '')
            {
                muestraModalFacturasCxP('renglon_factura','t_facturas tbody','dialog_facturas',0,$('#i_fecha_inicio_f').val(),$('#i_fecha_fin_f').val());
            }else{
                var idProveedor = $('#i_proveedor').attr('alt');
                muestraModalFacturasCxP('renglon_factura','t_facturas tbody','dialog_facturas',idProveedor,$('#i_fecha_inicio_f').val(),$('#i_fecha_fin_f').val());
            }
        });

        $('#i_fecha_inicio_f').change(function(){
            if($('#i_fecha_inicio_f').val() != '')
            {
                $('#i_fecha_fin_f').prop('disabled',false);
                if($('#i_proveedor').val() == '')
                {
                    muestraModalFacturasCxP('renglon_factura','t_facturas tbody','dialog_facturas',0,$('#i_fecha_inicio_f').val(),$('#i_fecha_fin_f').val());
                }else{
                    var idProveedor = $('#i_proveedor').attr('alt');
                    muestraModalFacturasCxP('renglon_factura','t_facturas tbody','dialog_facturas',idProveedor,$('#i_fecha_inicio_f').val(),$('#i_fecha_fin_f').val());
                }
            }
        });

        $('#i_fecha_fin_f').change(function(){
            if($('#i_proveedor').val() == '')
            {
                muestraModalFacturasCxP('renglon_factura','t_facturas tbody','dialog_facturas',0,$('#i_fecha_inicio_f').val(),$('#i_fecha_fin_f').val());
            }else{
                var idProveedor = $('#i_proveedor').attr('alt');
                muestraModalFacturasCxP('renglon_factura','t_facturas tbody','dialog_facturas',idProveedor,$('#i_fecha_inicio_f').val(),$('#i_fecha_fin_f').val());
            }
        });

        $('#t_facturas').on('click', '.renglon_factura', function() {
            var id = $(this).attr('alt');
            var factura = $(this).attr('alt2');
            $('#i_factura').attr('alt',id).val(factura);
            $('#dialog_facturas').modal('hide');
            $('#i_proveedor').attr('alt',$(this).attr('alt6')).val($(this).attr('alt7'));
            $('#b_estado_cuenta').prop('disabled',false);
            
            muestraSaldoDisponible(id);
            anteriorClase = $('#i_importe').attr('class');
            cargoInicial = parseFloat($(this).attr('alt4'));
            banderaCancela = $(this).attr('alt5');
        });

        $('#s_cuenta_banco').change(function(){
            var idCuentaBanco = $('#s_cuenta_banco').val();
            var tipo = $('#s_cuenta_banco option:selected').attr('alt2');
            var idSucursal = $('#s_cuenta_banco option:selected').attr('alt3');
           
            if(tipo == 0)
            {
                muestraSaldoDisponibleCuentaBanco(idCuentaBanco);
                $('#s_concepto_cxp').prop('disabled',false);
            }else{
                muestraSaldoDisponibleCajaChica(idSucursal);
                $('#s_concepto_cxp').val(7).select2({placeholder: $(this).data('elemento')}).prop('disabled',true);
            }
        });

        function muestraSaldoDisponibleCuentaBanco(idCuentaBanco){
            saldoDisponibleCuentaB = 0;
            $.ajax({
                type: 'POST',
                url: 'php/movimientos_cuentas_saldo_disponible.php',
                dataType:"json", 
                data:{'idCuentaBanco' : idCuentaBanco},
                success: function(data)
                {
                    var arreglo=data;
                    for(var i=0;i<arreglo.length;i++)
                    {
                        var dato=arreglo[i];
                        
                        saldoDisponibleCuentaB = dato.saldo_disponible;
              
                    }
                },
                error: function (xhr) {
                    console.log("movimientos_cuentas_saldo_disponible.php--> "+JSON.stringify(xhr));    
                    mandarMensaje('* No se encontró información de saldo disponible de la cuenta');
                }
            });
        }

        function muestraSaldoDisponibleCajaChica(idSucursal){
            saldoDisponibleCuentaB = 0;
            $.ajax({
                type: 'POST',
                url: 'php/caja_chica_saldo_actual_buscar.php',
                dataType:"json", 
                data:{'idSucursal' : idSucursal},
                success: function(data)
                {
                    var arreglo=data;
                    if(arreglo.length>0)
                    {
                        saldoDisponibleCuentaB = arreglo[0].saldo;
                    }
                },
                error: function (xhr) {
                    console.log("caja_chica_saldo_actual_buscar.php--> "+JSON.stringify(xhr));    
                    mandarMensaje('* No se encontró información de saldo');
                }
            });
        }

        $('#i_importe').on('change',function(){

            anteriorClase = $('#i_importe').attr('class');

            if($(this).validationEngine('validate')==false) {

                var monto=quitaComa($('#i_importe').val());

                if(monto==''){
                    monto=0;
                }

                if(monto > 0){

                    $('#i_importe').val(formatearNumero(parseFloat(monto)));

                }else{
                    $('#i_importe').val(0);
                }

            }else{
                if(quitaComa($('#i_importe').val()) != '')
                {
                    var monto = quitaComa($('#i_importe').val());
                }else{
                    var monto = 0;
                }
                $('#i_importe').val(monto);
            }
        });

        $('#b_guardar').click(function(){
            $('#b_guardar').prop('disabled',true);

            if($('#forma_cxp').validationEngine('validate'))
            {
                if(parseFloat(quitaComa($('#i_saldo').val())) > 0)
                {   
                    console.log(parseFloat(saldoDisponibleCuentaB)+' - '+parseFloat(quitaComa($('#i_importe').val())));
                    if(parseFloat(saldoDisponibleCuentaB) >= parseFloat(quitaComa($('#i_importe').val())))
                    {  
                        guardar();
                    }else{
                        mandarMensaje('El saldo actual de la cuenta banco '+$('#s_cuenta_banco option:selected').text()+' es insuficiente para realizar el movimiento.');
                        $('#b_guardar').prop('disabled',false);
                    }
                }else{
                    var concepto = $('#s_concepto_cxp option:selected').attr('alt');
                    var res = concepto.substr(0, 1);
                    if(res == 'C'){
                        //--> Si es un cargo no comparo mi saldo disponible de la cuenta por que es un ingreso a mi
                        guardar();
                    }else{
                        mandarMensaje('No es posible realizar un abono cuando el saldo es 0');
                        $('#b_guardar').prop('disabled',false);
                    }
                }

            }else{
                $('#b_guardar').prop('disabled',false);
            }
        });

        function guardar(){

            var info = {
                'idCxP' : $('#i_factura').attr('alt'),
                'factura' : $('#i_factura').val(),
                'idProveedor' : $('#i_proveedor').attr('alt'),
                'idConcepto' :  $('#s_concepto_cxp').val(),
                'claveConcepto' : $('#s_concepto_cxp option:selected').attr('alt'),
                'fecha' : $('#i_fecha').val(),
                'importe' : quitaComa($('#i_importe').val()),
                'referencia' : $('#i_referencia').val(),
                'idBanco' : $('#s_cuenta_banco option:selected').attr('alt'),
                'idCuentaBanco' : $('#s_cuenta_banco').val(),
                'idUsuario' : idUsuario,
                'tipoCuenta' : $('#s_cuenta_banco option:selected').attr('alt2'),
                'concepto' : $('#s_concepto_cxp option:selected').text(),
                'estatus' : 'P'
            };

            $.ajax({
                type: 'POST',
                url: 'php/cxp_guardar.php',
                data:  {'datos':info},
                success: function(data) {
                    //console.log(data);
                    if(data > 0 )
                    { 
                        var idCxP=data;
                        mandarMensaje('Se realizo el proceso correctamente');
                        $('#s_concepto_cxp').prop('disabled',false);
                        //NJES Jan/21/2020 solo mostrar las cuentas bancos de tipo banco porque en cxp solo se puede pagar de bancos
                        //en el tercer parametro se especifica 1= solo mostrar cuentas tipo banco, 0= mostrar todos tipos de cuentas
                        //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
                        muestraCuentasBancosSaldosPermiso('s_cuenta_banco', 0,1,idUnidadActual);
                        muestraConceptosCxP('s_concepto_cxp',1);
                        $('#i_fecha,#i_importe,#i_referencia').val('');

                        muestraSaldoDisponible(idCxP);
                        $('#b_guardar').prop('disabled',false);
                    
                    }else{ 
                        mandarMensaje('Error al guardar.');
                        $('#b_guardar').prop('disabled',false);
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/cxp_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al guardar.');
                    $('#b_guardar').prop('disabled',false);
                }
            });
        }

        function muestraSaldoDisponible(idCxP){
            saldoActual = 0;
            $.ajax({
                type: 'POST',
                url: 'php/cxp_saldo_actual_buscar.php',
                dataType:"json", 
                data:{'idCxP' : idCxP},
                success: function(data)
                {
                    var arreglo=data;
                    for(var i=0;i<arreglo.length;i++)
                    {
                        var dato=arreglo[i];
                        $('#i_saldo').val(formatearNumero(dato.saldo));
                        saldoActual = parseFloat(dato.saldo);   

                        if(parseFloat(dato.saldo) > 0)
                        {
                            $('#i_importe').removeClass(anteriorClase).addClass('form-control form-control-sm validate[required,custom[number],min[0.01],max['+parseFloat(dato.saldo)+']]');
                        }else{
                            $('#i_importe').removeClass(anteriorClase).addClass('form-control form-control-sm validate[required,custom[number],min[0.01]]');
                        }

                        muestraRegistros(idCxP);
                    }
                },
                error: function (xhr) {
                    console.log("cxp_saldo_actual_buscar.php--> "+JSON.stringify(xhr));    
                    mandarMensaje('* No se encontró información de saldo de la factura');
                }
            });
        }

        function muestraRegistros(idCxP){
            $('#t_registros tbody').empty();
            $.ajax({
                type: 'POST',
                url: 'php/cxp_registros_idCxP_buscar.php',
                dataType:"json", 
                data:{'idCxP':idCxP},
                success: function(data) {
                    if(data.length != 0){

                        for(var i=0;data.length>i;i++){
                            
                            if(data[i].id == idCxP)
                            {
                                if(data[i].estatus == 'C')
                                {
                                    $('#b_cancelar').prop('disabled',true);
                                    $('#b_guardar').prop('disabled',true);
                                }else{
                                    if(parseFloat(saldoActual) == parseFloat(cargoInicial))
                                    {
                                        $('#b_cancelar').prop('disabled',false);
                                    }else{
                                        if(parseFloat(saldoActual) == 0)
                                        {
                                            $('#b_cancelar').prop('disabled',false);
                                        }else{
                                            $('#b_cancelar').prop('disabled',true);
                                        }
                                    }

                                    $('#b_guardar').prop('disabled',false);
                                }
                            }

                            if(data[i].estatus == 'C')
                            {
                                var boton = '';

                                //--> compara si el dato es un valor positivo 
                                if(Math.sign(data[i].abonos)  == 1 || Math.sign(data[i].cargos)  == 1)
                                {
                                    var cancelado = 'style="background-color:#ffe6e6;"';
                                }else{
                                    var cancelado = '';
                                }
                            }else{
                                if(i > 0)
                                {
                                    var boton = '<button type="button" class="btn btn-danger btn-sm b_cancelar_p" alt="'+data[i].id+'">\
                                                    <i class="fa fa-ban" aria-hidden="true"></i>\
                                                </button>';
                                }else{
                                    var boton = '';
                                }
                                var cancelado = '';
                            }

                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon" '+cancelado+'>\
                                        <td data-label="Concepto">'+data[i].clave_concepto+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Descripción">'+data[i].concepto_cxp+'</td>\
                                        <td data-label="Cargos">'+formatearNumero(data[i].cargos)+'</td>\
                                        <td data-label="Abonos">'+formatearNumero(data[i].abonos)+'</td>\
                                        <td data-label="Referencia">'+data[i].referencia+'</td>\
                                        <td>'+boton+'</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros tbody').append(html);   
                            
                        }

                        if(banderaCancela == 0){
                            $('#b_cancelar').prop('disabled',true);
                        }

                    }else{
                        var html='<tr class="renglon">\
                                        <td colspan="6">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros tbody').append(html);
                    }

                },
                error: function (xhr) 
                {
                    console.log('php/cxp_registros_idCxP_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar datos de factura');
                }
            });
        }

        $(document).on('click','.b_cancelar_p',function(){
            var idRegistro = $(this).attr('alt');
              
            //cancelarCxP('partida',idRegistro);
            $('#b_guardar_cancelar_partida').attr('alt',idRegistro);
            $('#dialog_cancelar_partida').modal('show');
        });

        $('#b_guardar_cancelar_partida').click(function(){
            var idRegistro = $(this).attr('alt');

            $('#b_guardar_cancelar_partida').prop('disabled',true);

            if($('#form_cancelar_partida').validationEngine('validate'))
            {
                cancelarCxP('partida',idRegistro,$('#ta_justificacion_partida').val());
            }else{
                $('#b_guardar_cancelar_partida').prop('disabled',false);
            }
        });

        $('#b_cancelar').click(function(){
            //cancelarCxP('factura',$('#i_factura').attr('alt'));
            $('#dialog_cancelar').modal('show');
        });

        $('#b_guardar_cancelar').click(function(){
            $('#b_guardar_cancelar').prop('disabled',true);

            if($('#form_cancelar').validationEngine('validate'))
            {
                cancelarCxP('factura',$('#i_factura').attr('alt'),$('#ta_justificacion').val());
            }else{
                $('#b_guardar_cancelar').prop('disabled',false);
            }
        });

        function cancelarCxP(tipo,idRegistro,justificacion){
            $.ajax({
                type: 'POST',
                url: 'php/cxp_cargo_abono_cancelar.php',
                data:{'tipo':tipo,
                      'idRegistro':idRegistro,
                      'idUsuario':idUsuario,
                      'justificacion':justificacion
                    },
                success: function(data) {
                    //console.log(data);
                    if(data > 0 )
                    { 
                        muestraSaldoDisponible($('#i_factura').attr('alt'));
                        $('#b_guardar_cancelar').prop('disabled',false);
                        $('#dialog_cancelar,#dialog_cancelar_partida').modal('hide');
                        $('#ta_justificacion,#ta_justificacion_partida').val('');
                    }else{ 
                        mandarMensaje('Error al cancelar.');
                        $('#b_guardar').prop('disabled',false);
                        $('#b_guardar_cancelar').prop('disabled',false);
                    }

                    $('#b_guardar_cancelar,#b_guardar_cancelar_partida').prop('disabled',false);

                    $('#b_cancelar').prop('disabled',true);
                },
                error: function (xhr) 
                {
                    console.log('php/cxp_cargo_abono_cancelar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al cancelar.');
                    $('#b_guardar').prop('disabled',false);
                }
            });
        }

        $('#b_nuevo').click(function(){
            limpiar();
        });

        $('#b_estado_cuenta').click(function(){
            window.open('fr_cxp_estado_de_cuenta.php?idProveedor='+$('#i_proveedor').attr('alt')+'&proveedor='+$('#i_proveedor').val(),'_self');
        });

        function limpiar(){
            $('form').validationEngine('hide');
            $('#s_concepto_cxp').prop('disabled',false);
            //NJES Jan/21/2020 solo mostrar las cuentas bancos de tipo banco porque en cxp solo se puede pagar de bancos
            //en el tercer parametro se especifica 1= solo mostrar cuentas tipo banco, 0= mostrar todos tipos de cuentas
            //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
            muestraCuentasBancosSaldosPermiso('s_cuenta_banco', 0,1,idUnidadActual);
            muestraConceptosCxP('s_concepto_cxp',1);
            $('input').val('');
            $('#t_registros tbody').empty();
            $('#b_estado_cuenta,#b_cancelar').prop('disabled',true);
            $('#b_guardar').prop('disabled',false);
            $('#i_importe').removeClass('form-control form-control-sm validate[required,custom[number],min[0.01],max['+saldoActual+']]').addClass('form-control form-control-sm validate[required,custom[number],min[0.01]]');
            saldoActual = 0;
            cargoInicial = 0;
            banderaCancela = '';
            saldoDisponibleCuentaB = 0;
        }

    });

</script>

</html>