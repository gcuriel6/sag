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
    }
    #div_contenedor{
        background-color: #ffffff;
        padding-bottom:10px;
    }
    .div_t_contenido{
        max-height:250px;
        min-height:250px;
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
    #i_total_vencido,
    #i_total_vencer{
        text-align:right;
    }
    .vencidos > td{
        background-color:#ffe0b3;
    }

    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_t_vencido,#div_t_por_vencer{
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
            <div class="col-md-12" id="div_contenedor">
            <br>
                <div class="form-group row">
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Pagos CxP</div>
                    </div>
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-12 col-md-4">
                        <div class="row">
                            <label class="col-md-3">Ordenar: </label>
                            <div class="col-sm-12 col-md-4">
                                <input type="radio" name="radio_ordenar" id="r_proveedor" value="0" checked> Proveedor  
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <input type="radio" name="radio_ordenar" id="r_fecha" value="1"> Fecha
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                    </div>
                </div>
                <div class="row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>
                
                <form id="forma" name="forma">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="i_monto" class="col-form-label">Monto a Pagar</label>
                                    <input type="text" id="i_monto" name="i_monto" class="form-control form-control-sm validate[required,custom[number]]"  autocomplete="off" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="s_concepto" class="col-form-label">Concepto </label>
                                    <select id="s_concepto" name="s_concepto" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                                <div class="col-md-6">
                                    <label for="i_referencia" class="col-form-label">Referencia</label>
                                    <input type="text" id="i_referencia" name="i_referencia" class="form-control form-control-sm validate[required]"  autocomplete="off" referencia>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="s_cuenta_banco" class="col-form-label">Cuenta Banco </label>
                                    <select id="s_cuenta_banco" name="s_cuenta_banco" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="i_fecha" class="col-sm-12 col-md-12 col-form-label">Fecha de aplicación</label>
                                        <div class="input-group col-sm-12 col-md-11">
                                            <input type="text" name="i_fecha" id="i_fecha" class="form-control form-control-sm validate[required] fecha" autocomplete="off" readonly>
                                            <div class="input-group-addon input_group_span">
                                                <span class="input-group-text">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2"><br>
                                    <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <br>

                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav_1" alt="1" data-toggle="tab" href="#nav_ordenes_compra" role="tab" aria-controls="nav_ordenes_compra" aria-selected="true">Ordenes de Compra</a>
                        <a class="nav-item nav-link" id="nav_2" alt="2" data-toggle="tab" href="#nav_deudores_diversos" role="tab" aria-controls="nav_deudores_diversos" aria-selected="false">Deudores Diversos</a>
                        <a class="nav-item nav-link" id="nav_3" alt="3" data-toggle="tab" href="#nav_viaticos" role="tab" aria-controls="nav_viaticos" aria-selected="false">Viaticos</a>
                        <a class="nav-item nav-link" id="nav_4" alt="4" data-toggle="tab" href="#nav_anticipos" role="tab" aria-controls="nav_anticipos" aria-selected="false">Anticipos</a>
                        <a class="nav-item nav-link" id="nav_5" alt="5" data-toggle="tab" href="#nav_ordenes_servicio" role="tab" aria-controls="nav_ordenes_servicio" aria-selected="false">Ordenes de Servicio</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav_ordenes_compra" role="tabpanel" aria-labelledby="nav_ordenes_compra">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="titulo_tabla">
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-5">
                                            <input type="text" id="i_filtro_ordenes_compra" name="i_filtro_ordenes_compra" alt="renglon_ordenes_compra" class="form-control form-control-sm filtrar_renglones" placeholder="Filtrar..." autocomplete="off">
                                        </div>
                                        <div class="col-md-3"><h6><span class="badge badge-default">* Debes seleccionar folios del mismo proveedor</span></h6></div>
                                    </div>
                                </div>
                                <table class="tablon">
                                    <thead>
                                        <tr class="renglon">
                                            <th scope="col">Clave Unidad Negocio</th>
                                            <th scope="col">Clave Sucursal</th>
                                            <th scope="col">Proveedor/Empleado</th>
                                            <th scope="col">Folio</th>
                                            <th scope="col">Vence</th>
                                            <th scope="col">Importe</th>
                                            <th scope="col">Referencia</th>
                                            <th scope="col">Banco</th>
                                            <th scope="col">Cuenta Clabe</th>
                                            <th scope="col" width="9%">Pagar</th>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="div_t_contenido">
                                    <table class="tablon"  id="t_ordenes_compra">
                                        <tbody>
                                            
                                        </tbody>
                                    </table>  
                                </div>  
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-4"></div>
                            <div class="col-sm-12 col-md-6">
                                <div class="row">
                                    <label for="i_total_ordenes_compra" class="col-form-label col-md-3" style="text-align:center;"><strong>Total</strong></label>
                                    <div class="col-sm-12 col-md-4">
                                        <input type="text" id="i_total_ordenes_compra" name="i_total_ordenes_compra" class="form-control form-control-sm" autocomplete="off" readonly>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="tab-pane fade" id="nav_deudores_diversos" role="tabpanel" aria-labelledby="nav_deudores_diversos">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="titulo_tabla">
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-5">
                                            <input type="text" id="i_filtro_deudores_diversos" name="i_filtro_deudores_diversos" alt="renglon_deudores_diversos" class="form-control form-control-sm filtrar_renglones" placeholder="Filtrar..." autocomplete="off">
                                        </div>
                                        <div class="col-md-3"><h6><span class="badge badge-default">* Debes seleccionar folios del mismo proveedor</span></h6></div>
                                    </div>
                                </div>
                                <table class="tablon">
                                    <thead>
                                        <tr class="renglon">
                                            <th scope="col">Clave Unidad Negocio</th>
                                            <th scope="col">Proveedor/Empleado</th>
                                            <th scope="col">Folio</th>
                                            <th scope="col">Vence</th>
                                            <th scope="col">Importe</th>
                                            <th scope="col">Referencia</th>
                                            <th scope="col">Banco</th>
                                            <th scope="col">Cuenta Clabe</th>
                                            <th scope="col" width="9%">Pagar</th>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="div_t_contenido">
                                    <table class="tablon"  id="t_deudores_diversos">
                                        <tbody>
                                            
                                        </tbody>
                                    </table>  
                                </div>  
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-4"></div>
                            <div class="col-sm-12 col-md-6">
                                <div class="row">
                                    <label for="i_total_deudores_diversos" class="col-form-label col-md-3" style="text-align:center;"><strong>Total</strong></label>
                                    <div class="col-sm-12 col-md-4">
                                        <input type="text" id="i_total_deudores_diversos" name="i_total_deudores_diversos" class="form-control form-control-sm" autocomplete="off" readonly>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="tab-pane fade" id="nav_viaticos" role="tabpanel" aria-labelledby="nav_viaticos">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="titulo_tabla">
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-5">
                                            <input type="text" id="i_filtro_viaticos" name="i_filtro_viaticos" alt="renglon_viaticos" class="form-control form-control-sm filtrar_renglones" placeholder="Filtrar..." autocomplete="off">
                                        </div>
                                        <div class="col-md-3"><h6><span class="badge badge-default">* Debes seleccionar folios del mismo proveedor</span></h6></div>
                                    </div>
                                </div>
                                <table class="tablon">
                                    <thead>
                                        <tr class="renglon">
                                            <th scope="col">Clave Unidad Negocio</th>
                                            <th scope="col">Clave Sucursal</th>
                                            <th scope="col">Proveedor/Empleado</th>
                                            <th scope="col">Folio</th>
                                            <th scope="col">Vence</th>
                                            <th scope="col">Importe</th>
                                            <th scope="col">Referencia</th>
                                            <th scope="col">Banco</th>
                                            <th scope="col">Cuenta Clabe</th>
                                            <th scope="col" width="9%">Pagar</th>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="div_t_contenido">
                                    <table class="tablon"  id="t_viaticos">
                                        <tbody>
                                            
                                        </tbody>
                                    </table>  
                                </div>  
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-4"></div>
                            <div class="col-sm-12 col-md-6">
                                <div class="row">
                                    <label for="i_total_viaticos" class="col-form-label col-md-3" style="text-align:center;"><strong>Total</strong></label>
                                    <div class="col-sm-12 col-md-4">
                                        <input type="text" id="i_total_viaticos" name="i_total_viaticos" class="form-control form-control-sm" autocomplete="off" readonly>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="tab-pane fade" id="nav_anticipos" role="tabpanel" aria-labelledby="nav_anticipos">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="titulo_tabla">
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-5">
                                            <input type="text" id="i_filtro_anticipos" name="i_filtro_anticipos" alt="renglon_anticipos" class="form-control form-control-sm filtrar_renglones" placeholder="Filtrar..." autocomplete="off">
                                        </div>
                                        <div class="col-md-3"><h6><span class="badge badge-default">* Debes seleccionar folios del mismo proveedor</span></h6></div>
                                    </div>
                                </div>
                                <table class="tablon">
                                    <thead>
                                        <tr class="renglon">
                                            <th scope="col">Clave Unidad Negocio</th>
                                            <th scope="col">Clave Sucursal</th>
                                            <th scope="col">Proveedor/Empleado</th>
                                            <th scope="col">Folio</th>
                                            <th scope="col">Vence</th>
                                            <th scope="col">Importe</th>
                                            <th scope="col">Referencia</th>
                                            <th scope="col">Banco</th>
                                            <th scope="col">Cuenta Clabe</th>
                                            <th scope="col" width="9%">Pagar</th>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="div_t_contenido">
                                    <table class="tablon"  id="t_anticipos">
                                        <tbody>
                                            
                                        </tbody>
                                    </table>  
                                </div>  
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-4"></div>
                            <div class="col-sm-12 col-md-6">
                                <div class="row">
                                    <label for="i_total_anticipos" class="col-form-label col-md-3" style="text-align:center;"><strong>Total</strong></label>
                                    <div class="col-sm-12 col-md-4">
                                        <input type="text" id="i_total_anticipos" name="i_total_anticipos" class="form-control form-control-sm" autocomplete="off" readonly>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="tab-pane fade" id="nav_ordenes_servicio" role="tabpanel" aria-labelledby="nav_ordenes_servicio">
                    <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="titulo_tabla">
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-5">
                                            <input type="text" id="i_filtro_ordenes_servicio" name="i_filtro_ordenes_servicio" alt="renglon_ordenes_servicio" class="form-control form-control-sm filtrar_renglones" placeholder="Filtrar..." autocomplete="off">
                                        </div>
                                        <div class="col-md-3"><h6><span class="badge badge-default">* Debes seleccionar folios del mismo proveedor</span></h6></div>
                                    </div>
                                </div>
                                <table class="tablon">
                                    <thead>
                                        <tr class="renglon">
                                            <th scope="col">Clave Unidad Negocio</th>
                                            <th scope="col">Clave Sucursal</th>
                                            <th scope="col">Proveedor/Empleado</th>
                                            <th scope="col">Folio</th>
                                            <th scope="col">Vence</th>
                                            <th scope="col">Importe</th>
                                            <th scope="col">Referencia</th>
                                            <th scope="col">Banco</th>
                                            <th scope="col">Cuenta Clabe</th>
                                            <th scope="col" width="9%">Pagar</th>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="div_t_contenido">
                                    <table class="tablon"  id="t_ordenes_servicio">
                                        <tbody>
                                            
                                        </tbody>
                                    </table>  
                                </div>  
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-4"></div>
                            <div class="col-sm-12 col-md-6">
                                <div class="row">
                                    <label for="i_total_ordenes_servicio" class="col-form-label col-md-3" style="text-align:center;"><strong>Total</strong></label>
                                    <div class="col-sm-12 col-md-4">
                                        <input type="text" id="i_total_ordenes_servicio" name="i_total_ordenes_servicio" class="form-control form-control-sm" autocomplete="off" readonly>
                                    </div>
                                </div>
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

<div id="dialog_proveedores_datos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Datos Proveedor: <span id="nombre_proveedor"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div id="div_datos_proveedor"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="dialog_empleado_datos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Datos Empleado: <span id="nombre_empleado"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div id="div_datos_empleado"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="dialog_detalles" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle CxP Factura: <span id="dato_factura"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div id="div_datos_detalle"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="dialog_visor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Archivo</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			    
			</div>
			<div class="modal-body">
					<div style="width:100%" id="div_archivo"></div>
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
  
    var modulo='PAGOS_CXP';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;

    var matriz = <?php echo $_SESSION['sucursales']?>;

    var saldoDisponibleCuentaB = 0;
    $(function()
    {

        console.log('**');

        mostrarBotonAyuda(modulo);

        //NJES Jan/21/2020 solo mostrar las cuentas bancos de tipo banco porque en cxp pagos solo se puede pagar de bancos
        //en el tercer parametro se especifica 1= solo mostrar cuentas tipo banco, 0= mostrar todos tipos de cuentas
        //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
        muestraCuentasBancosSaldosPermiso('s_cuenta_banco',0,1,idUnidadActual);
        muestraConceptosCxPAbonos('s_concepto');

        verificaRadioOrden();

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        });

        $('#s_cuenta_banco').change(function(){
            var idCuentaBanco = $('#s_cuenta_banco').val();
            var tipo = $('#s_cuenta_banco option:selected').attr('alt2');
            var idSucursal = $('#s_cuenta_banco option:selected').attr('alt3');
           
            if(tipo == 0)
            {
                muestraSaldoDisponibleCuentaBanco(idCuentaBanco);
                $('#s_concepto').prop('disabled',false);
            }else{
                muestraSaldoDisponibleCajaChica(idSucursal);
                $('#s_concepto').val(7).select2({placeholder: $(this).data('elemento')}).prop('disabled',true);
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

                        let saldo = 999999999;

                        if(dato.saldo_disponible > 0){
                            saldo = dato.saldo_disponible;
                        }
                        
                        saldoDisponibleCuentaB = saldo;
              
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

        $('input[name=radio_ordenar]').change(function(){
            $('#i_monto').val('');
            verificaRadioOrden();
        });

        function verificaRadioOrden(){
            if($("#r_proveedor").is(':checked')) 
                var radio_orden = $("#r_proveedor").val();
            else
                var radio_orden = $("#r_fecha").val();
            
            // verificando
            muestraRegistrosOC(radio_orden);
            muestraRegistrosDD(radio_orden);
            muestraRegistrosViaticos(radio_orden);
            muetraRegistrosAnticipos(radio_orden);
            muetraRegistrosOS(radio_orden);
        }

        function muestraRegistrosOC(ordenar){
            $('#t_ordenes_compra tbody').empty();

            $.ajax({
                type: 'POST',
                url: 'php/cxpPagos_buscar.php',
                dataType:"json", 
                data:{'ordenar':ordenar,
                      'tipo':1 },
                success: function(data) {
                    if(data.length != 0){
                        for(var i=0;data.length>i;i++){

                            if(data[i].b_provedor == 0){
                                var tipo='empleado';
                            }else{
                                var tipo='proveedor';
                            }
                            var botonVerXml='';
                            var botonVerPdf='';
                            var rutaXML = '';
                            var rutaPDF ='';
                            /*var botonDetalle='<button type="button" class="btn btn-success btn-sm b_detalle" alt="'+data[i].id+'" tipo="'+data[i].tipo+'">\
                                                    <i class="fa fa-eye" aria-hidden="true"></i>\
                                                </button>';*/

                            //if(data[i].tipo=='cxp_oc'){
                                var nombreXml="xml_"+data[i].id_proveedor+"_"+data[i].idE01+".xml"; //-- obtengo el nombre del archivo guardado
                                rutaXML = "portal_proveedores/XML/"+nombreXml;
                                var nombrePDF="pdf_"+data[i].id_proveedor+"_"+data[i].idE01+".pdf"; //-- obtengo el nombre del archivo guardado
                                rutaPDF = "portal_proveedores/PDF/"+nombrePDF;
                                botonVerXml='<a style="text-decoration: none;" border="0" type="button" class="btn btn-info btn-sm"  href="'+rutaXML+'" download="'+nombreXml+'"><i class="fa fa-download" aria-hidden="true"></i></a>';
                                botonVerPdf='<button type="button" class="btn btn-danger btn-sm b_ver_pdf" alt="'+data[i].id_proveedor+'"   alt2="'+data[i].idE01+'"tipo="'+data[i].tipo+'"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>';
                                botonDetalle='';
                            //}

                            if(data[i].vencidos == 1)
                                var vencidos = 'vencidos';
                            else
                                var vencidos = '';

                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_ordenes_compra '+vencidos+'" alt="'+data[i].id+'" alt2="'+data[i].id_proveedor+'" tipo="'+tipo+'">\
                                        <td class="ver_info" data-label="Clave Unidad Negocio">'+data[i].clave_unidad_negocio+'</td>\
                                        <td class="ver_info" data-label="Clave Sucursal">'+data[i].clave_sucursal+'</td>\
                                        <td class="ver_info" data-label="Proveedor">'+data[i].proveedor+'</td>\
                                        <td data-label="Factura">'+data[i].factura+' '+botonDetalle+' '+botonVerXml+' '+botonVerPdf+'</td>\
                                        <td class="ver_info" data-label="vence">'+data[i].fecha+'</td>\
                                        <td data-label="Importe" class="ver_info importe_vencido">'+formatearNumero(data[i].importe)+'</td>\
                                        <td class="ver_info" data-label="Referencia">'+data[i].referencia+'</td>\
                                        <td class="ver_info" data-label="Banco">'+data[i].banco+'</td>\
                                        <td class="ver_info" data-label="Cuenta Clabe">'+data[i].cuenta_clabe+'</td>\
                                        <td width="7%">\
                                            <input type="checkbox" class="ch_pagar" name="ch_pagar" value="'+data[i].id+'" id="ch_pagar_'+data[i].id+'" alt="'+data[i].importe+'" tipo="'+data[i].tipo+'" ref="'+data[i].referencia+'" rutaXml="'+rutaXML+'" rutaPDF="'+rutaPDF+'" idProveedor="'+data[i].id_proveedor+'">\
                                        </td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_ordenes_compra tbody').append(html);   
                            
                        }

                        sumaTotal('renglon_ordenes_compra','i_total_ordenes_compra');
                    }else{
                        var html='<tr class="renglon">\
                                        <td colspan="7">No se encontró información</td>\
                                    </tr>';

                        $('#t_ordenes_compra tbody').append(html);

                        $('#t_ordenes_compra').val('');
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/cxpPagos_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar datos');
                }
            });
        }

        function muestraRegistrosDD(ordenar){
            $('#t_deudores_diversos tbody').empty();

            $.ajax({
                type: 'POST',
                url: 'php/cxpPagos_buscar.php',
                dataType:"json", 
                data:{'ordenar':ordenar,
                    'tipo':2 },
                success: function(data) {
                    if(data.length != 0){
                        for(var i=0;data.length>i;i++){

                            if(data[i].b_provedor == 0){
                                var tipo='empleado';
                            }else{
                                var tipo='proveedor';
                            }
                            var botonVerXml='';
                            var botonVerPdf='';
                            var rutaXML = '';
                            var rutaPDF ='';
                            var botonDetalle='<button type="button" class="btn btn-success btn-sm b_detalle" alt="'+data[i].id+'" tipo="'+data[i].tipo+'">\
                                                    <i class="fa fa-eye" aria-hidden="true"></i>\
                                                </button>';

                            if(data[i].vencidos == 1)
                                var vencidos = 'vencidos';
                            else
                                var vencidos = '';

                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_deudores_diversos '+vencidos+'" alt="'+data[i].id+'" alt2="'+data[i].id_proveedor+'" tipo="'+tipo+'">\
                                        <td class="ver_info" data-label="Clave Unidad Negocio">'+data[i].clave_unidad_negocio+'</td>\
                                        <td class="ver_info" data-label="Proveedor">'+data[i].proveedor+'</td>\
                                        <td data-label="Factura">'+data[i].factura+' '+botonDetalle+' '+botonVerXml+' '+botonVerPdf+'</td>\
                                        <td class="ver_info" data-label="vence">'+data[i].fecha+'</td>\
                                        <td data-label="Importe" class="ver_info importe_vencido">'+formatearNumero(data[i].importe)+'</td>\
                                        <td class="ver_info" data-label="Referencia">'+data[i].referencia+'</td>\
                                        <td class="ver_info" data-label="Banco">'+data[i].banco+'</td>\
                                        <td class="ver_info" data-label="Cuenta Clabe">'+data[i].cuenta_clabe+'</td>\
                                        <td width="7%">\
                                            <input type="checkbox" class="ch_pagar" name="ch_pagar" value="'+data[i].id+'" id="ch_pagar_'+data[i].id+'" alt="'+data[i].importe+'" tipo="'+data[i].tipo+'" ref="'+data[i].referencia+'" rutaXml="'+rutaXML+'" rutaPDF="'+rutaPDF+'" idProveedor="'+data[i].id_proveedor+'">\
                                        </td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_deudores_diversos tbody').append(html);   
                            
                        }

                        sumaTotal('renglon_deudores_diversos','i_total_deudores_diversos');
                    }else{
                        var html='<tr class="renglon">\
                                        <td colspan="7">No se encontró información</td>\
                                    </tr>';

                        $('#t_deudores_diversos tbody').append(html);

                        $('#t_deudores_diversos').val('');
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/cxpPagos_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar datos');
                }
            });
        }

        function muestraRegistrosViaticos(ordenar){
            $('#t_viaticos tbody').empty();

            $.ajax({
                type: 'POST',
                url: 'php/cxpPagos_buscar.php',
                dataType:"json", 
                data:{'ordenar':ordenar,
                    'tipo':3 },
                success: function(data) {
                    if(data.length != 0){
                        for(var i=0;data.length>i;i++){

                            if(data[i].b_provedor == 0){
                                var tipo='empleado';
                            }else{
                                var tipo='proveedor';
                            }
                            var botonVerXml='';
                            var botonVerPdf='';
                            var rutaXML = '';
                            var rutaPDF ='';
                            var botonDetalle='<button type="button" class="btn btn-success btn-sm b_detalle" alt="'+data[i].id+'" tipo="'+data[i].tipo+'">\
                                                    <i class="fa fa-eye" aria-hidden="true"></i>\
                                                </button>';

                            if(data[i].vencidos == 1)
                                var vencidos = 'vencidos';
                            else
                                var vencidos = '';

                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_viaticos '+vencidos+'" alt="'+data[i].id+'" alt2="'+data[i].id_proveedor+'" tipo="'+tipo+'">\
                                        <td class="ver_info" data-label="Clave Unidad Negocio">'+data[i].clave_unidad_negocio+'</td>\
                                        <td class="ver_info" data-label="Clave Sucursal">'+data[i].clave_sucursal+'</td>\
                                        <td class="ver_info" data-label="Proveedor">'+data[i].proveedor+'</td>\
                                        <td data-label="Factura">'+data[i].factura+' '+botonDetalle+' '+botonVerXml+' '+botonVerPdf+'</td>\
                                        <td class="ver_info" data-label="vence">'+data[i].fecha+'</td>\
                                        <td data-label="Importe" class="ver_info importe_vencido">'+formatearNumero(data[i].importe)+'</td>\
                                        <td class="ver_info" data-label="Referencia">'+data[i].referencia+'</td>\
                                        <td class="ver_info" data-label="Banco">'+data[i].banco+'</td>\
                                        <td class="ver_info" data-label="Cuenta Clabe">'+data[i].cuenta_clabe+'</td>\
                                        <td width="7%">\
                                            <input type="checkbox" class="ch_pagar" name="ch_pagar" value="'+data[i].id+'" id="ch_pagar_'+data[i].id+'" alt="'+data[i].importe+'" tipo="'+data[i].tipo+'" ref="'+data[i].referencia+'" rutaXml="'+rutaXML+'" rutaPDF="'+rutaPDF+'" idProveedor="'+data[i].id_proveedor+'">\
                                        </td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_viaticos tbody').append(html);   
                            
                        }

                        sumaTotal('renglon_viaticos','i_total_viaticos');
                    }else{
                        var html='<tr class="renglon">\
                                        <td colspan="7">No se encontró información</td>\
                                    </tr>';

                        $('#t_viaticos tbody').append(html);

                        $('#t_viaticos').val('');
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/cxpPagos_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar datos');
                }
            });
        }

        function muetraRegistrosAnticipos(ordenar)
        {

            // verificando            
            $('#t_anticipos tbody').empty();

            $.ajax({
                type: 'POST',
                url: 'php/cxpPagos_buscar.php',
                dataType:"json", 
                data:{'ordenar':ordenar,
                    'tipo':4 },
                success: function(data) {
                    if(data.length != 0){
                        for(var i=0;data.length>i;i++){

                            if(data[i].b_provedor == 0){
                                var tipo='empleado';
                            }else{
                                var tipo='proveedor';
                            }
                            var botonVerXml='';
                            var botonVerPdf='';
                            var rutaXML = '';
                            var rutaPDF ='';
                            var botonDetalle='<button type="button" class="btn btn-success btn-sm b_detalle" alt="'+data[i].id+'" tipo="'+data[i].tipo+'">\
                                                    <i class="fa fa-eye" aria-hidden="true"></i>\
                                                </button>';

                            if(data[i].vencidos == 1)
                                var vencidos = 'vencidos';
                            else
                                var vencidos = '';

                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_anticipos '+vencidos+'" alt="'+data[i].id+'" alt2="'+data[i].id_proveedor+'" tipo="'+tipo+'">\
                                        <td class="ver_info" data-label="Clave Unidad Negocio">'+data[i].clave_unidad_negocio+'</td>\
                                        <td class="ver_info" data-label="Clave Sucursal">'+data[i].clave_sucursal+'</td>\
                                        <td class="ver_info" data-label="Proveedor">'+data[i].proveedor+'</td>\
                                        <td data-label="Factura">'+data[i].factura+' '+botonDetalle+' '+botonVerXml+' '+botonVerPdf+'</td>\
                                        <td class="ver_info" data-label="vence">'+data[i].fecha+'</td>\
                                        <td data-label="Importe" class="ver_info importe_vencido">'+formatearNumero(data[i].importe)+'</td>\
                                        <td renglon_anticipos class="ver_info" data-label="Referencia">'+data[i].referencia+'</td>\
                                        <td class="ver_info" data-label="Banco">'+data[i].banco+'</td>\
                                        <td class="ver_info" data-label="Cuenta Clabe">'+data[i].cuenta_clabe+'</td>\
                                        <td width="7%">\
                                            <input type="checkbox" class="ch_pagar" name="ch_pagar" value="'+data[i].id+'" id="ch_pagar_'+data[i].id+'" alt="'+data[i].importe+'" tipo="'+data[i].tipo+'" ref="'+data[i].referencia+'" rutaXml="'+rutaXML+'" rutaPDF="'+rutaPDF+'" idProveedor="'+data[i].id_proveedor+'">\
                                        </td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_anticipos tbody').append(html);   
                            
                        }

                        sumaTotal('renglon_anticipos','i_total_anticipos');
                    }else{
                        var html='<tr class="renglon">\
                                        <td colspan="7">No se encontró información</td>\
                                    </tr>';

                        $('#t_anticipos tbody').append(html);

                        $('#t_anticipos').val('');
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/cxpPagos_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar datos');
                }
            });
        }

        function muetraRegistrosOS(ordenar){
            $('#t_ordenes_servicio tbody').empty();

            $.ajax({
                type: 'POST',
                url: 'php/cxpPagos_buscar.php',
                dataType:"json", 
                data:{'ordenar':ordenar,
                      'tipo':5 },
                success: function(data) {
                    if(data.length != 0){
                        for(var i=0;data.length>i;i++){

                            if(data[i].b_provedor == 0){
                                var tipo='empleado';
                            }else{
                                var tipo='proveedor';
                            }
                            var botonVerXml='';
                            var botonVerPdf='';
                            var rutaXML = '';
                            var rutaPDF ='';

                            var nombreXml="xml_"+data[i].id_proveedor+"_"+data[i].idE01+".xml"; //-- obtengo el nombre del archivo guardado
                            rutaXML = "portal_proveedores/XML/"+nombreXml;
                            var nombrePDF="pdf_"+data[i].id_proveedor+"_"+data[i].idE01+".pdf"; //-- obtengo el nombre del archivo guardado
                            rutaPDF = "portal_proveedores/PDF/"+nombrePDF;
                            botonVerXml='<a style="text-decoration: none;" border="0" type="button" class="btn btn-info btn-sm"  href="'+rutaXML+'" download="'+nombreXml+'"><i class="fa fa-download" aria-hidden="true"></i></a>';
                            botonVerPdf='<button type="button" class="btn btn-danger btn-sm b_ver_pdf" alt="'+data[i].id_proveedor+'"   alt2="'+data[i].idE01+'"tipo="'+data[i].tipo+'"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>';
                            botonDetalle='';

                            if(data[i].vencidos == 1)
                                var vencidos = 'vencidos';
                            else
                                var vencidos = '';

                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_ordenes_servicio '+vencidos+'" alt="'+data[i].id+'" alt2="'+data[i].id_proveedor+'" tipo="'+tipo+'">\
                                        <td class="ver_info" data-label="Clave Unidad Negocio">'+data[i].clave_unidad_negocio+'</td>\
                                        <td class="ver_info" data-label="Clave Sucursal">'+data[i].clave_sucursal+'</td>\
                                        <td class="ver_info" data-label="Proveedor">'+data[i].proveedor+'</td>\
                                        <td data-label="Factura">'+data[i].factura+' '+botonDetalle+' '+botonVerXml+' '+botonVerPdf+'</td>\
                                        <td class="ver_info" data-label="vence">'+data[i].fecha+'</td>\
                                        <td data-label="Importe" class="ver_info importe_vencido">'+formatearNumero(data[i].importe)+'</td>\
                                        <td class="ver_info" data-label="Referencia">'+data[i].referencia+'</td>\
                                        <td class="ver_info" data-label="Banco">'+data[i].banco+'</td>\
                                        <td class="ver_info" data-label="Cuenta Clabe">'+data[i].cuenta_clabe+'</td>\
                                        <td width="7%">\
                                            <input type="checkbox" class="ch_pagar" name="ch_pagar" value="'+data[i].id+'" id="ch_pagar_'+data[i].id+'" alt="'+data[i].importe+'" tipo="'+data[i].tipo+'" ref="'+data[i].referencia+'" rutaXml="'+rutaXML+'" rutaPDF="'+rutaPDF+'" idProveedor="'+data[i].id_proveedor+'">\
                                        </td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_ordenes_servicio tbody').append(html);   
                            
                        }

                        sumaTotal('renglon_ordenes_servicio','i_total_ordenes_servicio');
                    }else{
                        var html='<tr class="renglon">\
                                        <td colspan="7">No se encontró información</td>\
                                    </tr>';

                        $('#t_ordenes_servicio tbody').append(html);

                        $('#t_ordenes_servicio').val('');
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/cxpPagos_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar datos');
                }
            });
        }

        function sumaTotal(renglon,input){
            var total=0;
            $('.'+renglon+' .importe_vencido').each(function(){
                if($(this).parent().css('display')!='none')
                {
                    var valor= parseFloat(quitaComa($(this).text()));

                    total=total+valor;
                }
            });

            $('#'+input).val(formatearNumero(total));
        }

        $('#i_filtro_ordenes_compra').keyup(function(){
            sumaTotal('renglon_ordenes_compra','i_total_ordenes_compra');
            calculaMontoAPagar(opcionTab());
        });

        $('#i_filtro_deudores_diversos').keyup(function(){
            sumaTotal('renglon_deudores_diversos','i_total_deudores_diversos');
            calculaMontoAPagar(opcionTab());
        });

        $('#i_filtro_viaticos').keyup(function(){
            sumaTotal('renglon_viaticos','i_total_viaticos');
            calculaMontoAPagar(opcionTab());
        });

        $('#i_filtro_anticipos').keyup(function(){
            sumaTotal('renglon_anticipos','i_total_anticipos');
            calculaMontoAPagar(opcionTab());
        });

        $('#i_filtro_ordenes_servicio').keyup(function(){
            sumaTotal('renglon_ordenes_servicio','i_total_ordenes_servicio');
            calculaMontoAPagar(opcionTab());
        });

        function opcionTab(){
            var opcion = 0;

            if($('#nav_1').hasClass('active')) 
                opcion = 1; //ordenes de compra
            else if($('#nav_2').hasClass('active'))
                opcion = 2; //deudores diversos
            else if($('#nav_3').hasClass('active'))
                opcion = 3; //viaticos
            else if($('#nav_4').hasClass('active'))
                opcion = 4; //anticipos requisición
            else
                opcion = 5; //ordenes de servicio
            
            return opcion;
        }

        function calculaMontoAPagar(opcion){
            var total=0;
            var renglon='';

            $('#i_monto').val('');

            if(opcion == 1)
                renglon='renglon_ordenes_compra';
            else if(opcion == 2)
                renglon='renglon_deudores_diversos';
            else if(opcion == 3)
                renglon='renglon_viaticos';
            else if(opcion == 4)
                renglon='renglon_anticipos';
            else
                renglon='renglon_ordenes_servicio';

            $('.'+renglon+' .ch_pagar').each(function(){
                if($(this).is(':checked'))
                {
                    if($(this).parent().parent().css('display')!='none')
                    {
                        var valor= parseFloat($(this).attr('alt'));

                        total=total+valor;
                    }
                }
            });

            $('#i_monto').val(formatearNumero(total));
        }

        $(document).on('click','.ch_pagar',function(){
            calculaMontoAPagar(opcionTab());
        });

        $('.nav-link').click(function(){
            calculaMontoAPagar($(this).attr('alt'));
        });

        function verificarProveedor(opcion){

            var primerProveedor=0;
            var diferenteProveedor=0;
            var cont=0;

            var renglon='';

            if(opcion == 1)
                renglon='renglon_ordenes_compra';
            else if(opcion == 2)
                renglon='renglon_deudores_diversos';
            else if(opcion == 3)
                renglon='renglon_viaticos';
            else if(opcion == 4)
                renglon='renglon_anticipos';
            else
                renglon='renglon_ordenes_servicio';

            $('.'+renglon+' .ch_pagar').each(function(){

                if($(this).is(':checked'))
                {
                    if($(this).parent().parent().css('display')!='none')
                    {
                        if(cont==0){
                            primerProveedor=$(this).attr('idProveedor');
                            cont++;
                        }
                        if(primerProveedor!=$(this).attr('idProveedor')){
                        
                            diferenteProveedor++;

                        }
                        
                    
                    }
                }
            });
            //--- O = ES E MISMO PROVEEDOR 1<= HAY DIFERENTES PROVEEDORES
            return diferenteProveedor;
        }

        $('#b_guardar').click(function(){
           
           $('#b_guardar').prop('disabled',true);

            if($('#forma').validationEngine('validate'))
            {
                // if(parseFloat(saldoDisponibleCuentaB) >= parseFloat(quitaComa($('#i_monto').val())))
                // {
                    //2022-06-03 GCM - Se quita validador de saldo disponible para que siempre deje hacer el movimiento aun que no tenga saldo disponible
                    //--MGFS SE AGREGA VALIDACION PARA QUE SE SELECCIONES FOLIOS DE MISMO PROVVEDOR
                    if(verificarProveedor(opcionTab())==0){
                        guardar();
                    }else{
                        mandarMensaje('No puedes guardar un pago a diferentes proveedores, verifica que los folios a pagar sean del mismo proveedor');
                        $('#b_guardar').prop('disabled',false);
                    }
                   
                // }else{
                //     mandarMensaje('El saldo actual de la cuenta banco '+$('#s_cuenta_banco option:selected').text()+' es insuficiente para realizar el pago.');
                //     $('#b_guardar').prop('disabled',false);
                // }
            }else{
                $('#b_guardar').prop('disabled',false);
            }
        });

        function guardar(){
            if($('#i_monto').val()!='' && parseFloat(quitaComa($('#i_monto').val()))>0){
                var info = {
                    'idConcepto' :  $('#s_concepto').val(),
                    'claveConcepto' : $('#s_concepto option:selected').attr('alt'),
                    'referenciaN' : $('#i_referencia').val(),
                    'idBanco' : $('#s_cuenta_banco option:selected').attr('alt'),
                    'idCuentaBanco' : $('#s_cuenta_banco').val(),
                    'idUsuario' : idUsuario,
                    'tipoCuenta' : $('#s_cuenta_banco option:selected').attr('alt2'),
                    'fechaAplicacion':$('#i_fecha').val(),
                    'registros' : obtieneRegistrosAPagar(opcionTab())
                };
                console.log(JSON.stringify(info));
                $.ajax({
                    type: 'POST',
                    url: 'php/cxpPagos_guardar.php',
                    data:  {'datos':info},
                    success: function(data) {
                        console.log('data: '+data);
                        if(data > 0 )
                        {

                            mandarMensaje('Se realizo el proceso correctamente');
                            //NJES Jan/21/2020 solo mostrar las cuentas bancos de tipo banco porque en cxp pagos solo se puede pagar de bancos
                            //en el tercer parametro se especifica 1= solo mostrar cuentas tipo banco, 0= mostrar todos tipos de cuentas
                            //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
                            muestraCuentasBancosSaldosPermiso('s_cuenta_banco',0,1,idUnidadActual);
                            muestraConceptosCxPAbonos('s_concepto');
                            $('#i_referencia,#i_filtro_vencer,#i_monto').val('');
                            $('#i_filtro_ordenes_compra,#i_filtro_deudores_diversos,#i_filtro_viaticos,#i_filtro_anticipos')
                            
                            var opcion = opcionTab();
                            if($("#r_proveedor").is(':checked')) 
                                var radio_orden = $("#r_proveedor").val();
                            else
                                var radio_orden = $("#r_fecha").val();

                            if(opcion == 1)
                                muestraRegistrosOC(radio_orden);
                            else if(opcion == 2)
                                muestraRegistrosDD(radio_orden);
                            else if(opcion == 3)
                                muestraRegistrosViaticos(radio_orden);
                            else if(opcion == 4)
                                muetraRegistrosAnticipos(radio_orden);
                            else
                                muetraRegistrosOS(radio_orden);
                            
                            $('#b_guardar').prop('disabled',false); 

                        }
                        else
                        { 
                            mandarMensaje('Error al guardar.');
                            $('#b_guardar').prop('disabled',false);
                        }
                    },
                    error: function (xhr) 
                    {
                        console.log('php/cxpPagos_guardar.php --> '+JSON.stringify(xhr));
                        mandarMensaje('* Error al guardar.');
                        $('#b_guardar').prop('disabled',false);
                    }
                });
            }else{
                mandarMensaje('Debes selecciona por lo menos un registro');
            }
        }

        function obtieneRegistrosAPagar(opcion){
            var j = 0;
            var arreglo = [];

            var renglon='';

            if(opcion == 1)
                renglon='renglon_ordenes_compra';
            else if(opcion == 2)
                renglon='renglon_deudores_diversos';
            else if(opcion == 3)
                renglon='renglon_viaticos';
            else if(opcion == 4)
                renglon='renglon_anticipos';
            else
                renglon='renglon_ordenes_servicio';

            $('.'+renglon+' .ch_pagar').each(function(){
                if($(this).is(':checked'))
                {
                    var mismoProveedor=0;
                    var cont=0;
                    if($(this).parent().parent().css('display')!='none')
                    {
                        var id = $(this).val();
                        var tipo =$(this).attr('tipo');
                        var referencia =$(this).attr('ref'); 
                        var importe =$(this).attr('alt');
                        var rutaXML =  $(this).attr('rutaXML');
                        var rutaPDF =  $(this).attr('rutaPDF');
                        
                        j++;


                        arreglo[j] = {
                            'id' : id,
                            'tipo' : tipo,
                            'referencia' : referencia,
                            'importe' : importe,
                            'rutaXml' : rutaXML,
                            'rutaPdf' : rutaPDF
                        };
                    }
                }
            });

            arreglo[0] = j;
            return arreglo;
        }

        $(document).on('click','.b_ver_pdf',function(){
            
            var idProveedor=$(this).attr('alt');
            var idE01=$(this).attr('alt2');
            var nombrePdf="pdf_"+idProveedor+"_"+idE01+".pdf"; //-- obtengo el nombre del archivo guardado
            var rutaPDF = "portal_proveedores/PDF/"+nombrePdf;
           
            $("#div_archivo").empty(); 
           
            var fil="<embed width='100%' height='500px' src='"+rutaPDF+"'>";
            $("#div_archivo").append(fil);  

            $('#dialog_visor').modal('show');
        });

        function muestraInfoProveedor(idProveedor){
            $.ajax({
                type: 'POST',
                url: 'php/proveedores_buscar_id.php',
                dataType:"json", 
                data:{
                    'idProveedor':idProveedor
                },
                success: function(data) {
                    if(data.length > 0){
                        if(data[0].num_int != '')
                        {
                            var num_int=' Int.'+data[0].num_int;
                        }else{
                            var num_int='';
                        }

                        $('#nombre_proveedor').text(data[0].nombre);

                        var detalles = '<p>Nombre: '+data[0].nombre+'</p>';
                            detalles += '<p>RFC: '+data[0].rfc+'</p>';
                            detalles += '<p>Domicilio: '+data[0].domicilio+' '+data[0].num_ext+' '+num_int+'. '+data[0].colonia+', '+data[0].municipio+', '+data[0].estado+', '+data[0].pais+'</p>';
                            detalles += '<p>Código Postal: '+data[0].cp+'</p>';
                            detalles += '<p>Telefono: '+data[0].telefono+'</p>';
                            detalles += '<p>Dias Credito: '+data[0].dias_credito+'</p>';
                            detalles += '<p>Web: '+data[0].web+'</p>';
                            detalles += '<p>Contacto: '+data[0].contacto+'</p>';
                            detalles += '<p>Condiciones: '+data[0].condiciones+'</p>';

                        $('#div_datos_proveedor').html(detalles);

                    }

                    $('#dialog_proveedores_datos').modal('show');
                    
                },
                error: function (xhr) 
                {
                    console.log('php/proveedores_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar proveedor');
                }
            });
        }

        function muestraInfoEmpleado(idEmpleado){
            $.ajax({
                type: 'POST',
                url: 'php/empleados_buscar_id.php',
                dataType:"json", 
                data:{
                    'idEmpleado':idEmpleado
                },
                success: function(data) {
                    if(data.length > 0){
                        $('#nombre_empleado').text(data[0].empleado);

                        var detalles = '<p>Nombre: '+data[0].empleado+'</p>';
                            detalles += '<p>Iniciales: '+data[0].iniciales+'</p>';
                            detalles += '<p>Domicilio: '+data[0].direccion+'. '+data[0].colonia+', '+data[0].municipio+', '+data[0].estado+'</p>';
                            detalles += '<p>Telefono: '+data[0].telefono+'</p>';
                            detalles += '<p>Email: '+data[0].correo+'</p>';

                        $('#div_datos_empleado').html(detalles);

                    }

                    $('#dialog_empleado_datos').modal('show');
                    
                },
                error: function (xhr) 
                {
                    console.log('php/empleados_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar empleado');
                }
            });
        }

        function mostrarDetalleGasto(id){
            $.ajax({
                type: 'POST',
                url: 'php/gastos_buscar_id.php',
                dataType:"json", 
                data:{
                    'idGasto':id
                },
                success: function(data) {
                    if(data.length > 0){
                        $('#dato_factura').text(data[0].referencia);

                        var detalles = '<p><b>Unidad de Negocio:</b> '+data[0].unidad+'</p>';
                            detalles += '<p><b>Sucursal:</b> '+data[0].sucursal+'</p>';
                            detalles += '<p><b>Familia:</b> '+data[0].familia_gastos+'</p>';
                            detalles += '<p><b>Clasificacion:</b> '+data[0].clasificacion_gasto+'</p>';
                            detalles += '<p><b>Área:</b> '+data[0].are+'</p>';
                            detalles += '<p><b>Departamento:</b> '+data[0].departamento+'</p>';
                            if(data[0].id_cuenta_banco > 0)
                            { 
                                detalles += '<p><b>Cuenta Banco:</b> '+data[0].banco+' - '+data[0].cuenta+'</p>';
                            }
                            detalles += '<p><b>Concepto:</b> '+data[0].concepto+'</p>';
                            detalles += '<p><b>Observaciones:</b> '+data[0].observaciones+'</p>';
                            detalles += '<p><b>Monto:</b> $'+formatearNumero(data[0].total)+'</p>';
                            detalles += '<p><b>Empleado:</b> '+data[0].nombre+'</p>';
                            detalles += '<p><b>Proveedor:</b> '+data[0].proveedor+'</p>';

                        $('#div_datos_detalle').html(detalles);

                    }

                    $('#dialog_detalles').modal('show');
                    
                },
                error: function (xhr) 
                {
                    console.log('php/gastos_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar detalle del registro');
                }
            });
        }

        function mostrarDetalleViatico(id,factura){
            $.ajax({
                type: 'POST',
                url: 'php/viaticos_buscar_id.php',
                dataType:"json", 
                data:{
                    'idViatico':id
                },
                success: function(data) {
                    if(data.length > 0){
                        $('#dato_factura').text(factura);

                        var detalles = '<p><b>Unidad de Negocio:</b> '+data[0].unidad+'</p>';
                            detalles += '<p><b>Sucursal:</b> '+data[0].sucursal+'</p>';
                            detalles += '<p><b>Área:</b> '+data[0].are+'</p>';
                            detalles += '<p><b>Departamento:</b> '+data[0].departamento+'</p>';
                            detalles += '<p><b>Solicitó:</b> '+data[0].solicito+'</p>';
                            detalles += '<p><b>Destino:</b> '+data[0].destino+'</p>';
                            detalles += '<p><b>Distancia:</b> '+data[0].distancia+'</p>';
                            detalles += '<p><b>Motivos del Viaje:</b> '+data[0].motivos+'</p>';
                            detalles += '<p><b>Del:</b> '+data[0].fecha_inicio+' <b>Al:</b> '+data[0].fecha_fin+'</p>';
                            detalles += '<p><b>Días:</b> '+data[0].dias+' <b>Noches:</b> '+data[0].noches+'</p>';
                            detalles += '<p><b>Monto:</b> $'+formatearNumero(data[0].total)+'</p>';
                            detalles += '<p><b>Autorizó:</b> '+data[0].autorizo+'</p>';
                            detalles += '<p><b>Empleado:</b> '+data[0].empleado+'</p>';

                        $('#div_datos_detalle').html(detalles);

                    }

                    $('#dialog_detalles').modal('show');
                    
                },
                error: function (xhr) 
                {
                    console.log('php/viaticos_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar detalle del registro');
                }
            });
        }

        function mostrarDetalleCxP(id,factura,tipo){
            $.ajax({
                type: 'POST',
                url: 'php/cxpPagos_buscar_id.php',
                dataType:"json", 
                data:{
                    'id':id,
                    'tipo':tipo
                },
                success: function(data) {
                    if(data.length > 0){
                        if(tipo == 'cxp_viatico')
                        {
                            $('#dato_factura').text(factura);
                        }else{
                            $('#dato_factura').text(factura+ ' de Anticipo Requisición');
                        }

                        var detalles = '<p><b>Unidad de Negocio:</b> '+data[0].unidad+'</p>';
                            detalles += '<p><b>Sucursal:</b> '+data[0].sucursal+'</p>';
                            detalles += '<p><b>Área:</b> '+data[0].are+'</p>';
                            detalles += '<p><b>Departamento:</b> '+data[0].departamento+'</p>';
                            detalles += '<p><b>Solicitó:</b> '+data[0].solicito+'</p>';
                            if(tipo == 'cxp_viatico')
                            {
                                detalles += '<p><b>Destino:</b> '+data[0].destino+'</p>';
                                detalles += '<p><b>Distancia:</b> '+data[0].distancia+'</p>';
                                detalles += '<p><b>Motivos del Viaje:</b> '+data[0].motivos+'</p>';
                                detalles += '<p><b>Del:</b> '+data[0].fecha_inicio+' <b>Al:</b> '+data[0].fecha_fin+'</p>';
                                detalles += '<p><b>Días:</b> '+data[0].dias+' <b>Noches:</b> '+data[0].noches+'</p>';
                                detalles += '<p><b>Monto:</b> $'+formatearNumero(data[0].total)+'</p>';
                                detalles += '<p><b>Autorizó:</b> '+data[0].autorizo+'</p>';
                                detalles += '<p><b>Empleado:</b> '+data[0].empleado+'</p>';
                            }else{
                                detalles += '<p><b>Proveedor:</b> '+data[0].proveedor+'</p>';
                                detalles += '<p><b>Fecha Pedido:</b> '+data[0].fecha_pedido+'</p>';
                                detalles += '<p><b>Días Entrega:</b> '+data[0].dias_entrega+'</p>';
                                detalles += '<p><b>Saldo CxP:</b> $'+formatearNumero(data[0].saldo)+'</p>';
                                detalles += '<p><b>Total:</b> $'+formatearNumero(data[0].total)+'</p>';
                                detalles += '<p><b>Monto Anticipo:</b> $'+formatearNumero(data[0].monto_anticipo)+'</p>';
                                detalles += '<p><b>Folio Requisición:</b> '+data[0].folio+'</p>';
                            }

                        $('#div_datos_detalle').html(detalles);

                    }

                    $('#dialog_detalles').modal('show');
                    
                },
                error: function (xhr) 
                {
                    console.log('php/cxpPagos_buscar_id.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar detalle del registro');
                }
            });
        }

        $(document).on('click', '.b_detalle', function() {
            var id = $(this).attr('alt');
            var tipo = $(this).attr('tipo');
            var factura = $(this).parent().text();

            if(tipo == 'gasto')
                mostrarDetalleGasto(id);
            else if(tipo == 'viatico')
                mostrarDetalleViatico(id,factura);
            else
                mostrarDetalleCxP(id,factura,tipo);
            
        });

        $(document).on('click', '.ver_info', function() {
            var id = $(this).parent().attr('alt2');
            var tipo = $(this).parent().attr('tipo');
            
            if(tipo == 'proveedor')
            {
                muestraInfoProveedor(id);
            }else{
                muestraInfoEmpleado(id);
            }
        });

        $('#b_excel').click(function(){
            var datos = {
                'orden':$('input[name=radio_ordenar]:checked').val(),
                'tipo':opcionTab()
            }; 

            var nombre = '';
            if(opcionTab() == 1)
                nombre = 'CxP Ordenes de Compra';
            else if(opcionTab() == 2)
                nombre = 'CxP Deudores Diversos';
            else if(opcionTab() == 3)
                nombre = 'CxP Viaticos';
            else if(opcionTab() == 4)
                nombre = 'CxP Anticipos';
            else
                nombre = 'CxP Ordenes de Servicio';

            $("#i_nombre_excel").val(nombre);
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(datos));

            $("#f_imprimir_excel").submit();
        });

    });

</script>

</html>