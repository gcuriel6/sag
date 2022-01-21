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

    
    #dialog_buscar_vales_gasolina > .modal-lg{
        min-width: 95%;
        max-width: 95%;
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
        #dialog_buscar_vales_gasolina > .modal-lg{
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
                        <div class="titulo_ban">Vales de Gasolina</div>
                    </div>
                    <div class="col-sm-1 col-md-1"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-primary btn-sm form-control" id="b_buscar"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_nuevo"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
                    </div>
                    
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_imprimir"><i class="fa fa-print" aria-hidden="true"></i> Imprimr</button>
                    </div>
                </div>

                <form id="forma" name="forma">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="i_folio" class="col-md-1 col-form-label">Folio </label>
                            <input type="text" id="i_folio" name="i_folio" class="form-control form-control-sm" autocomplete="off" readonly>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-3">
                            <label for="i_saldo" class="col-md-1 col-form-label">Saldo </label>
                            <input type="text" id="i_saldo" name="i_saldo" class="form-control form-control-sm" autocomplete="off" readonly>
                        </div>
                        <div class="col-sm-12 col-md-1"></div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label for="i_empleado" class="col-sm-12 col-md-3 col-form-label">Empleado</label>
                                        <!--<div class="col-md-9">
                                            <input type="checkbox" id="ch_todos" name="ch_todos" value=""> Todos por Unidad de Negocio
                                        </div>-->
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
                        </div>
                        
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
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="checkbox" id="ch_externo" name="ch_externo" value=""> Empleado Externo
                                </div>
                                <div class="col-md-12">
                                    <input type="text" id="i_empleado_externo" name="i_empleado_externo" class="form-control form-control-sm" autocomplete="off" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="checkbox" id="ch_externo_no_economico" name="ch_externo_no_economico" value=""> Externo
                                    <label for="i_vehiculo" id='l_vehiculo' class="col-auto col-md-auto col-form-label">No Ecónomico Vehículo </label>
                                </div>
                                <div class="input-group col-sm-12 col-md-12">
                                    <input type="hidden" id="i_servicio" name="i_servicio">
                                    <input type="text" id="i_no_economico" name="i_no_economico" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                                    <div class="input-group-btn">
                                        <button class="btn btn-info" type="button" id="b_buscar_activo" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    
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
                                            <input type="text" name="i_fecha" id="i_fecha" class="form-control form-control-sm validate[required]" autocomplete="off" readonly>
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
                        <h5>Registros del Día <span id="dato_fecha_hoy"></span></h5>
                        <!--<span class="notaVerde"> * En la Sucursal Selecionada</span>-->
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
                                    <th scope="col">No Economico</th>
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
    <div class="modal-dialog modal-lg">
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
                                <th scope="col">No. Nómina</th>
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

<!-- Modal Buscar Activo -->
<div id="dialog_buscar_activos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="padding-right: 17px;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Buscar Activos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Contenido Modal -->
        <form id="forma_buscar_activos">
          <div class="row">
             <div class="col-auto">
              <label class="col-form-label">No. Económico:</label>
            </div>
            <div class="col-md-3">
              <input type="text" id="i_busca_no_economico" name="i_busca_no_economico" class="form-control form-control-sm" autocomplete="off">
            </div>

            <div class="col-auto">
              <label for="s_buscar_tipo" class="col-form-label"> Tipo:</label>
            </div>
            <div class="col-md-4">
              <select id="s_buscar_tipo" name="s_buscar_tipo" class="form-control form-control-sm">
                <option selected="true" disabled="disabled">Seleccione el Tipo:</option>
                <option value="1">Vehículo</option>
                <option value="2">Celular</option>
                <option value="3">Equipo de Computo</option>
                <option value="4">Otro</option>
                <option value="">Todos</option>
              </select>
            </div>

          </div>

          <div class="row">
            <div class="col-auto">
              <label class="col-form-label">Filtrar</label>
            </div>
            <div class="col-md-3">
                <input type="text" name="i_filtro_activos" id="i_filtro_activos" alt="activo_renglon" class="form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off"> 
            </div>
          </div>

          <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-sm-12 col-md-12" style="height:480px; overflow: scroll">
              <table class="tablon">
                <thead>
                  <tr class="renglon">
                    <th scope="col">No. Serie</th>
                    <th scope="col">No. Economico</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Tipo</th>
                  </tr>
                </thead>
                <tbody id="t_buscar_activo">

                </tbody>
              </table>
            </div>
            <div class="col-md-2">
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="dialog_justificacion" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Justificación de la Cancelación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id='form_justificacion' name='form_justificacion'>
            <div class="form-group row">
                <label for="ta_justificacion" class="col-sm-2 col-md-2 col-form-label requerido">Justificación </label>
                <div class="col-sm-9 col-md-9">
                    <textarea  id="ta_justificacion" name="ta_justificacion" class="form-control validate[required]" autocomplete="off"></textarea>
                </div>
            </div> 
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger btn-sm" id="b_cancelar_registro">Cancelar</button>
      </div>
    </div>
  </div>
</div>


<div id="dialog_buscar_vales_gasolina" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Busqueda de Vales de Gasolina</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row">
        <div class="col-sm-12 col-md-4">
            <div class="form-group row">
                <label for="s_id_unidades_filtro" class="col-sm-12 col-md-5 col-form-label">Unidad de Negocio</label>
                <div class="col-sm-12 col-md-7">
                    <select id="s_id_unidades_filtro" name="s_id_unidades_filtro" class="form-control form-control-sm" autocomplete="off" style="width:100%;"></select>
                </div>
            </div>
            <div class="row">
                <label for="s_id_sucursales_filtro" class="col-sm-12 col-md-5 col-form-label">Sucursal</label>
                <div class="col-sm-12 col-md-7">
                    <select id="s_id_sucursales_filtro" name="s_id_sucursales_filtro" class="form-control form-control-sm" autocomplete="off" style="width:100%;"></select>
                </div>
            </div>
        </div>
            <div class="col-sm-12 col-md-8">
                <div class="form-group row">
                    <div class="col-sm-12 col-md-7">
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
                    <div class="col-sm-12 col-md-5">
                        <div class="row">
                            <label for="i_saldo_inicial" class="col-auto col-form-label">Saldo Inicial</label> 
                            <div class="col-sm-12 col-md-8">
                                <input type="text" name="i_saldo_inicial" id="i_saldo_inicial" class="form-control form-control-sm" autocomplete="off" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-7">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <input type="text" name="i_filtro" id="i_filtro" alt="renglon_registros" class="form-control form-control-sm filtrar_renglones" placeholder="Filtrar" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-5">
                        <div class="row">
                            <label for="i_saldo_final" class="col-auto col-form-label">Saldo Final</label> 
                            <div class="col-sm-12 col-md-8">
                                <input type="text" name="i_saldo_final" id="i_saldo_final" class="form-control form-control-sm" autocomplete="off" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      </div>

        <div class="row" id="div_resgitros">
            <div class="col-sm-12 col-md-12">
                <table class="tablon">
                    <thead>
                        <tr class="renglon">
                            <th scope="col">Folio</th>
                            <th scope="col">Unidad de Negocio</th>
                            <th scope="col">Sucursal</th>
                            <th scope="col">Área</th>
                            <th scope="col">Departamento</th>
                            <th scope="col">Empleado</th>
                            <th scope="col">Observaciones</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">No Economico</th>
                            <th scope="col">Concepto</th>
                            <th scope="col">Monto</th>
                        </tr>
                    </thead>
                </table>
                <div id="div_t_registros">
                    <table class="tablon"  id="t_buqueda_vales">
                        <tbody>
                            
                        </tbody>
                    </table>  
                </div>  
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger btn-sm" id="b_cancelar_registro">Cancelar</button>
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
  
    var modulo='VALES_DE_GASOLINA';
    var idUnidadActual = <?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario = <?php echo $_SESSION['id_usuario']?>;
    var anteriorClase = '';
    var saldoActual = 0;

    var matriz = <?php echo $_SESSION['sucursales']?>;
    $(function(){

        mostrarBotonAyuda(modulo);
        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);

        muestraSelectUnidades(matriz,'s_id_unidades_filtro',idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursales_filtro',idUnidadActual,modulo,idUsuario);
        muestraConceptosCxP('s_conceptos',2);  //-->busca los conceptos tipo vales de gasolina


        $('#b_imprimir').prop("disabled", true);

        $('#i_fecha').val(hoy);
        $('#dato_fecha_hoy').text(hoy);
        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        });

        anteriorClase = $('#i_total').attr('class');


        if($('#s_id_sucursales').val() != null)
        {
            muestraAreasAcceso('s_id_area');
            $('#s_id_area').prop('disabled', false);
            muestraSaldoDisponible($('#s_id_sucursales').val());
            console.log('si hay ' + $('#s_id_sucursales').val());
        }
        else
            console.log('no hay ' + $('#s_id_sucursales').val())

        //muestraAreasAcceso('s_id_area');
        //$('#s_id_area').prop('disabled', false);
        //muestraSaldoDisponible($('#s_id_sucursales').val());


        $('#s_id_unidades').change(function(){
            muestraSucursalesPermiso('s_id_sucursales',$('#s_id_unidades').val(),modulo,idUsuario);
        });

        $('#s_id_sucursales').change(function(){
            anteriorClase = $('#i_total').attr('class');
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
            //$('#ch_todos').prop('checked',false);
            if($("#ch_externo").is(':checked'))
            {
                $('#i_empleado_externo').addClass('validate[required]').prop('disabled',false);
            }else{
                $('#i_empleado_externo').removeClass('validate[required]').prop('disabled',true);
            }
        });

        //-->NJES March/24/2020 Eliminar opcion todos por unidad porque ya se buscan de todoas las sucursales a las que tiene permiso
        /*$('#ch_todos').change(function(){
            $('#i_empleado_externo').val('').removeClass('validate[required]').prop('disabled',true);
            $('#ch_externo').prop('checked',false);
        });*/

        $('#b_buscar_empleados').click(function(){
            $('#i_filtro_empleado').val('');
            //if($("#ch_todos").is(':checked'))
            //{
                //if(($('#s_id_unidades').val() != null))
                //{
                    //muestraModalEmpleadosUnidad('renglon_empleado','t_empleados tbody','dialog_empleados',$('#s_id_unidades').val());
                    //-->NJES March/24/2020 se envia lista de las sucursales a las que tiene permiso el usuario en el modulo sin importar la unidad seleccionada
                    //-->NJES July/23/2020 se agrega parametro modulo si viene del modulo salida de uniformes, sin importar si es administrativo 1 o 2 
                    //mostrar todos los empleados sin importar la unidad y sucursal
                    buscarEmpleadosIdsSucursales('renglon_empleado','t_empleados tbody','dialog_empleados',muestraSucursalesPermisoUsuarioLista(modulo,idUsuario),modulo);
                /*}else{
                    mandarMensaje('Seleccionar Sucursal para buscar información');
                }*/
            /*}else{
                if(($('#s_id_sucursales').val() != null))
                {
                    muestraModalEmpleadosIdSucursal('renglon_empleado','t_empleados tbody','dialog_empleados',$('#s_id_sucursales').val());
                }else{
                    mandarMensaje('Seleccionar Sucursal para buscar información');
                }
            }*/
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

            anteriorClase = $('#i_total').attr('class');

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
            $.ajax({
                type: 'POST',
                url: 'php/vales_gasolina_saldo_actual_buscar.php',
                dataType:"json", 
                data:{'idSucursal' : idSucursal},
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
                            $('#i_total').removeClass('').addClass('form-control form-control-sm validate[required,custom[number],min[0.01],max['+parseFloat(dato.saldo)+']]');
                        }else{
                            $('#i_total').removeClass(anteriorClase).addClass('form-control form-control-sm validate[required,custom[number],min[0.01]]');
                        }

                        muestraRegistroHoy(idSucursal); //--> muestra registros de hoy
                    }
                },
                error: function (xhr) {
                    console.log("vales_gasolina_saldo_actual_buscar.php--> "+JSON.stringify(xhr));    
                    mandarMensaje('* No se encontró información de saldo');
                }
            });
        }

        $('#b_guardar').click(function(){
            $('#b_guardar').prop('disabled',true);

            if($('#forma').validationEngine('validate'))
            {
                if(parseFloat(quitaComa($('#i_saldo').val())) > 0)
                { 
                    guardar();
                }else{
                    var concepto = $('#s_conceptos option:selected').attr('alt');
                    if(concepto == 'D01'){
                        //--> Si es un cargo no comparo mi saldo disponible de la cuenta por que es un ingreso a mi
                        guardar();
                    }else{
                        mandarMensaje('No es posible realizar un movimiento cuando el saldo es 0');
                        $('#b_guardar').prop('disabled',false);
                    }
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
                'idUsuario' : idUsuario,
                'externoNoEconomico': $("#ch_externo_no_economico").is(':checked')? 1 : 0 ,
                'noEconomico':$('#i_no_economico').val()
            };

            $.ajax({
                type: 'POST',
                url: 'php/vales_gasolina_guardar.php',
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
                    console.log('php/vales_gasolina_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al guardar.');
                    $('#b_guardar').prop('disabled',false);
                }
            });
        }

        ///muestra los movimientos del día
        function muestraRegistroHoy(idSucursal){

            $('#t_registros tbody').empty();
            var contF=0;
            $.ajax({
                type: 'POST',
                url: 'php/vales_gasolina_buscar_hoy.php',
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
                                        <td data-label="Empleado">'+data[i].no_economico+'</td>\
                                        <td data-label="Observación">'+data[i].observaciones+'</td>\
                                        <td data-label="Monto">$'+formatearNumero(data[i].importe)+'</td>\
                                        <td>'+boton+'</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros tbody').append(html);   
                            
                        }

                        //$('#i_folio').val(contF+1);

                    }else{
                        var html='<tr class="renglon">\
                                        <td colspan="10">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros tbody').append(html);

                        //$('#i_folio').val(1);
                    }

                },
                error: function (xhr) 
                {
                    console.log('php/vales_gasolina_buscar_hoy.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar vales de gasolina');
                }
            });
        }

        //--- MGFS 08-01-2020 SE AGREGA LA CANCELACION 
        $(document).on('click','.b_cancelar',function(){

           var idRegistro = $(this).attr('alt');
           $('#b_cancelar_registro').attr('alt',idRegistro);

           $('#dialog_justificacion').modal('show');
           $('#b_cancelar_registro').prop('disabled',false);
           $('#form_justificacion').validationEngine('hide');
           $('#ta_justificacion').prop('disabled',false);
       });

       $(document).on('click','#b_cancelar_registro',function(){

           $('#b_cancelar_registro').prop('disabled',true);
           var idRegistro = $(this).attr('alt');
           if($('#form_justificacion').validationEngine('validate')){
              
               cancelarRegistro(idRegistro);
               $('#dialog_justificacion').modal('hide');
           }else{
               $('#b_cancelar_registro').prop('disabled',false);
           }
           
       });

        function cancelarRegistro(idRegistro){
            
            $.ajax({
                type: 'POST',
                url: 'php/vales_gasolina_cancelar.php',
                data:{
                    'idRegistro':idRegistro,
                    'justificacion':$('#ta_justificacion').val()
                },
                success: function(data) {
                    console.log(data);
                    if(data > 0 )
                    { 
                        muestraSaldoDisponible($('#s_id_sucursales').val());
                    }else{ 
                        mandarMensaje('Error al cancelar.');
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/vales_gasolina_cancelar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al cancelar.');
                }
            });
        }

        function generaFormato(idRegistro){
            var tipo = 1;

            var datos = {
                'path':'formato_vales_gasolina',
                'idRegistro':idRegistro,
                'nombreArchivo':'vales_gasolina',
                'tipo':tipo
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_new')
        }

        $('#b_nuevo').click(function(){
            location.reload();
           /* muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
            muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
            muestraConceptosCxP('s_conceptos',2); //-->busca los conceptos tipo vales de gasolina

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
            $("#ch_externo_no_economico").prop('checked',false);
            $("#i_no_economico").val('').prop('disabled',false);
            $('#b_buscar_activo').prop('disabled',false);
            $('#b_imprimir').attr('alt',0).prop('disabled',true);*/
        });

        function limpiar(){
            muestraConceptosCxP('s_conceptos',2); //-->busca los conceptos tipo vales de gasolina

            $('#s_id_area').val('').select2({placeholder: ''});
            $('#s_id_departamento').val('').select2({placeholder: ''}).prop('disabled',true);

            $('#forma input').val('');
            $('#i_empleado').attr('alt',0)
            $('#forma').validationEngine('hide');
            $("#ch_externo").prop('checked',false);
            //$('#ch_todos').prop('checked',false);
            $('#i_empleado_externo').val('').removeClass('validate[required]').prop('disabled',true);
            $('#i_fecha').val(hoy);
        }

        


        /**** MODULO DE NO ECONOMICO QUE VIENE DE ACTIVOS */
        $('#ch_externo_no_economico').change(function(){
 
            if($("#ch_externo_no_economico").is(':checked'))
            {
                $('#l_vehiculo').removeClass('requerido');
                $('#i_no_economico').val('').removeAttr('class').addClass('form-control form-control-sm');
                //$('#i_servicio').val(0);
                $('#b_buscar_activo').prop('disabled',true);

            }else{

                $('#l_vehiculo').addClass('requerido');
                $('#i_no_economico').removeAttr('class').addClass('form-control form-control-sm validate[required]');
                //$('#i_servicio').val(1);
                $('#b_buscar_activo').prop('disabled',false);

            }
        });

         $('#b_buscar_activo').click(function(){
            $("#dialog_buscar_activos").modal('show');
            $("#i_busca_no_economico").val('');
            $("#i_fecha_buscar_activo").val('');
            $("#i_fecha_buscar_activo_fin").val('');
            $("#s_buscar_tipo").val();
            $('#s_buscar_propietario').val('1');
        });

        // Filtros de Historial de Bitacora
        $("#i_busca_no_economico").keyup(function(e){
            buscarActivosFijos();
        });

        // Filtros de Historial de Bitacora
        $("#s_buscar_tipo").on('change',function(e){
            buscarActivosFijos();
        });

        function buscarActivosFijos()
        {

            $("#i_busca_no_economico").focus();
            var noEconomico = $("#i_busca_no_economico").val();
            var tipo = $("#s_buscar_tipo").val();
    
            $.ajax({
                type: "POST",
                url: "php/activos_buscar_filtro_E01.php",
                data: {'noEconomico':noEconomico,'tipo':tipo},
                dataType: 'json',
                success: function(data)
                {
                  
                    salida = "";
                    tipo = "";
                        for (var i = 0; i < data.length; i++) {
                            actual=data[i];
                            if (actual.tipo==1) {tipo="Vehiculo";}
                            else if (actual.tipo=="2") {tipo="Celular";}
                            else if (actual.tipo==3) {tipo="Equipo de Computo";}
                            else {tipo="Otro";}
                            salida += "<tr class='activo_renglon' alt="+actual.no_economico+">";
                            salida += "<td>" + actual.no_serie + "</td>";
                            salida += "<td>" + actual.no_economico + "</td>";
                            salida += "<td>" + actual.descripcion + "</td>";
                            salida += "<td>" + tipo + "</td>";
                            salida += "</tr>";
                        }
                    
                    $("#t_buscar_activo").empty();
                    $("#t_buscar_activo").html(salida);

                },
                error: function (data){
                    console.log( "php/activos_buscar_filtro_E01.php -->"+JSON.stringify(data));
                    mandarMensaje("* Error con la Busqueda.");
                }
            });
        }

        $('#t_buscar_activo').on('click', '.activo_renglon', function() {
            var noEconomico = $(this).attr('alt');

            $('#i_no_economico').val(noEconomico);

            $('#dialog_buscar_activos').modal('hide');
        });

        /***************************** BUSQUEDA *****************************************/
        //---MGFS 08-01-2020 SE AGREGA BUSQUEDA DE VALES DE GASOLINA POR RANGO DE FECHAS

        $('#b_buscar').click(function(){
            muestraSelectUnidades(matriz,'s_id_unidades_filtro',idUnidadActual);
            muestraSucursalesPermiso('s_id_sucursales_filtro',idUnidadActual,modulo,idUsuario);
            $('#dialog_buscar_vales_gasolina').modal('show');
        });

        $('#s_id_unidades_filtro').change(function(){
            muestraSucursalesPermiso('s_id_sucursales_filtro',$('#s_id_unidades_filtro').val(),modulo,idUsuario);
            $('#b_excel').prop('disabled',false);
            $('#b_pdf').prop('disabled',false);
        });

        $('#s_id_sucursales_filtro').change(function(){
            $('#b_excel').prop('disabled',false);
            $('#b_pdf').prop('disabled',false);

            mostrarSaldos($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
            buscarValesGasolina($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
        });


        $('#i_fecha_inicio').val(primerDiaMes);
        $('#i_fecha_fin').val(ultimoDiaMes);

        $('#i_fecha_inicio').change(function(){
            if($('#s_id_sucursales_filtro').val() != null)
            {
                if($('#i_fecha_inicio').val() == '')
                {
                    $('#i_fecha_inicio').val(primerDiaMes);
                    mostrarSaldos(primerDiaMes,$('#i_fecha_fin').val());
                    buscarValesGasolina(primerDiaMes,$('#i_fecha_fin').val());
                }else{
                    mostrarSaldos($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
                    buscarValesGasolina($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
                }
            }else{
                mandarMensaje('Selecciona una sucursal');
            }
        });

        $('#i_fecha_fin').change(function(){
            if($('#s_id_sucursales_filtro').val() != null)
            {
                if($('#i_fecha_fin').val() == '')
                {
                    $('#i_fecha_fin').val(ultimoDiaMes);
                    mostrarSaldos($('#i_fecha_inicio').val(),ultimoDiaMes);
                    buscarValesGasolina($('#i_fecha_inicio').val(),ultimoDiaMes);
                }else{
                    mostrarSaldos($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
                    buscarValesGasolina($('#i_fecha_inicio').val(),$('#i_fecha_fin').val());
                }
            }else{
                mandarMensaje('Selecciona una sucursal');
            }
        });

        function mostrarSaldos(fechaInicio,FechaFin){
            var datos = {
                'idSucursal':$('#s_id_sucursales_filtro').val(),
                'fechaInicio':fechaInicio,
                'fechaFin':FechaFin
            };

            $.ajax({
                type: 'POST',
                url: 'php/vales_gasolina_saldos_buscar.php',
                dataType:"json", 
                data:  {'datos':datos},
                success: function(data) {
                    $('#i_saldo_inicial').val(formatearNumero(data.saldo_inicial));
                    $('#i_saldo_final').val(formatearNumero(data.saldo_final));
                },
                error: function (xhr) 
                {
                    console.log('php/vales_gasolina_saldos_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de saldos de vales de gasolina');
                }
            });
        }

        function buscarValesGasolina(fechaInicio,FechaFin){
            $('.renglon_registros_vales').remove();

            var datos = {
                'idSucursal':$('#s_id_sucursales_filtro').val(),
                'fechaInicio':fechaInicio,
                'fechaFin':FechaFin
            };
           
            $.ajax({
                type: 'POST',
                url: 'php/vales_gasolina_buscar.php',
                dataType:"json", 
                data:  {'datos':datos},
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
                        
                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_registros_vales" alt="'+data[i].id+'" alt2="'+data[i].folio+'">\
                                        <td data-label="Folio">'+data[i].folio+'</td>\
                                        <td data-label="Unidad de Negocio">'+data[i].unidad_negocio+'</td>\
                                        <td data-label="Sucursal">'+data[i].sucursal+'</td>\
                                        <td data-label="Área">'+data[i].area+'</td>\
                                        <td data-label="Departamento">'+data[i].departamento+'</td>\
                                        <td data-label="Empleado">'+empleado+'</td>\
                                        <td data-label="Observaciones">'+data[i].observaciones+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="No Economico">'+data[i].no_economico+'</td>\
                                        <td data-label="Concepto">'+data[i].concepto+'</td>\
                                        <td data-label="Monto">'+formatearNumero(data[i].importe)+'</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_buqueda_vales tbody').append(html);   
                            
                        }

                    }else{
                        var html='<tr class="renglon_registros_vales">\
                                        <td colspan="11">No se encontró información</td>\
                                    </tr>';

                        $('#t_buqueda_vales tbody').append(html);

                    }
                },
                error: function (xhr) 
                {
                    console.log('php/vales_gasolina_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar reporte de vales de gasolina');
                }
            });
        }



        $(document).on('click','.renglon_registros_vales',function(){
            var idVale = $(this).attr('alt');
            var folioVale = $(this).attr('alt2');
            buscarValeGasolinaId(idVale,folioVale);
            $('#b_imprimir').attr('alt',idVale).prop('disabled',false);
            $('#b_guardar').prop('disabled',true);
        });

        function buscarValeGasolinaId(idVale,folioVale){
        
            $.ajax({
                type: 'POST',
                url: 'php/vales_gasolina_buscar_id.php',
                dataType:"json", 
                data:  {'idVale':idVale},
                success: function(data) {
                    if(data.length != 0){
                        
                        for(var i=0; data.length>i; i++){

                            var vale = data[i];
                        
                            var idVale = vale.id;
                            var idUnidad = vale.id_unidad_negocio;
                            var idSucursal = vale.id_sucursal;
                            var idArea = vale.id_area;
                            var idDepartamento = vale.id_departamento;
                            var claveConcepto = vale.clave_concepto;
                          
                            $('#i_folio').val('').val(vale.folio);
                            $('#s_id_unidad').val(idUnidad);
                            $("#s_id_unidad").select2({
                                templateResult: setCurrency,
                                templateSelection: setCurrency
                            });
                            $('.img-flag').css({'width':'50px','height':'20px'}); //Cambia el tamaño de la imagen que se mostrara en el selectB

                            optionSurucursal = new Option(vale.sucursal, vale.id_sucursal, true, true);
                            $('#s_id_sucursales').append(optionSurucursal).trigger('change');

                            optionArea = new Option(vale.area, vale.id_area, true, true);
                            $('#s_id_area').append(optionArea).trigger('change');

                            optionDepto = new Option(vale.departamento, vale.id_departamento, true, true);
                            $('#s_id_departamento').append(optionDepto).trigger('change');

                            optionConcepto = new Option(vale.concepto, vale.clave_concepto, true, true);
                            $('#s_conceptos').append(optionConcepto).trigger('change');
                            $('#s_conceptos').prop('disabled',true);

                            $("#s_id_unidad").prop("disabled", true)
                            $("#s_id_sucursal").prop("disabled", true)
                            $("#s_id_area").prop("disabled", true)
                            $("#s_id_departamento").prop("disabled", true)
                           
                            if(vale.id_empleado>0){
                                $('#i_empleado').attr('alt', 0).val('');
                                $('#i_empleado').attr('alt', vale.id_empleado).val(vale.empleado);
                                $('#ch_externo').prop('checked', false);
                            }else{
                                $('#i_empleado_externo').attr('alt', 0).val('');
                                $('#i_empleado_externo').attr('alt', vale.id_empleado).val(vale.nombre_empleado);
                                $('#ch_externo').prop('checked', true);
                            }

                            $('#i_observaciones').val(vale.observaciones).prop('disabled',true);
                            $('#i_fecha').val(vale.fecha).prop('disabled',true);
                            $('#i_total').val(vale.importe).prop('disabled',true);
                            
                            //$('#ch_todos').prop('disabled',true);
                            $('#ch_externo').prop('disabled',true);
                            $('#ch_externo_no_economico').prop('disabled',true);
                            $('#i_no_economico').prop('disabled',true); 
                            if(vale.externo_no_economico==1){
                                $('#ch_externo_no_economico').prop('checked', true);
                                $('#i_no_economico').val('');
                            }else{
                                $('#ch_externo_no_economico').prop('checked', false);
                                $('#i_no_economico').val(vale.no_economico); 
                            }
                            

                            
                            $('#dialog_buscar_vales_gasolina').modal('hide');
                        }

                    }else{
                        mandarMensaje('No se encontro información sobre el vale de gasolina con folio: '+folioVale);
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/vales_gasolina_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar reporte de vales de gasolina');
                }
            });    
        }

        /***************************** BUSQUEDA *****************************************/
        //---MGFS 09-01-2020 SE AGREGALA IMPRESION DE CUALQUIERE VALE DE GASOLINA

        $('#b_imprimir').on('click',function(){
            var idRegistro= $(this).attr('alt');
            generaFormato(idRegistro);
        });

    });

</script>

</html>