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
#fondo_cargando{
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
  z-index:2;
  display:none;
}
body{
  background-color:rgb(238,238,238);
}
#div_contenedor{
  background-color: #ffffff;
  padding-bottom:10px;
}
.tablon {
  font-size: 10px;
}
/* Responsive Web Design */
@media only screen and (max-width:768px){
  .tablon{
    margin-top:10px;
  }
  #div_principal{
    margin-left:0%;
  }
  .boton_eliminar{
    width:100%;
  }
}
</style>
<body>
  <div class="container-fluid" id="div_principal">
    <div class="row">
      <div class="col-md-12" id="div_contenedor">
        <br>
        <div class="form-group row">
          <div class="col-md-9">
            <div class="col-sm-12 col-md-4">
              <div class="titulo_ban">Seguimiento Activos</div>
            </div>
          </div>
          <div class="col-sm-12 col-md-2">
              <button type="button" class="btn btn-success btn-sm form-control" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> EXCEL</button>
          </div>
          <div class="col-sm-12 col-md-2" id="div_cont_estatus" style="text-align:center;">
            <div id="div_estatus"></div>
          </div>
        </div>
        <body>
          <!-- Tabla Semana - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
          <div class="col-md-12">
            <a id="link_semana" alt='2' class="collapsed" data-toggle="collapse" href="#collapse_semana" aria-expanded="true" aria-controls="collapse_semana">
              <div class="card-header badge-secondary" role="tab" id="heading_semana">
                <h4 class="mb-0">
                  <span class="badge badge-secondary">Hoy + 30</span>
                </h4>
              </div>
            </a>
            <div id="collapse_semana" class="collapse collapsed show" role="tabpanel" aria-labelledby="heading_semana" data-parent="#accordion">
              <div class="card-body">
                <div class="card">
                  <div class="card-body" style="height:300px; overflow: scroll">
                    <div class="row">
                      <div class="col-md-3">
                        <input type="text" id="i_semana_noserie" name="i_semana_noserie" class="form-control" placeholder="No. Serie" style="font-size:14px;" autocomplete="off">
                      </div>
                      <div class="col-md-3">
                        <select id="s_seguimiento_semana_tipo" class="form-control form-control-sm">
                          <option selected="true" disabled="disabled">Seleccione el Tipo:</option>
                          <option value="1">Vehículo</option>
                          <option value="2">Celular</option>
                          <option value="">Todos</option>
                        </select>
                      </div>
                    </div>
                    <table class="tablon" id="t_1">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">No. Serie</th>
                          <th scope="col">No. Económico</th>
                          <th scope="col">IMEI GPS</th>
                          <th scope="col">Tipo</th>
                          <th scope="col">DESCRIPCIÓN</th>
                          <th scope="col">Vencimiento</th>
                          <th scope="col">Fecha Vencimiento</th>
                        </tr>
                      </thead>
                      <tbody id="t_seguimiento_semana">
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <br>
          <!-- Tabla Siguiente Mes - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
          <div class="col-md-12">
            <a id="link_mes" alt='1' class="collapsed" data-toggle="collapse" href="#collapse_mes" aria-expanded="true" aria-controls="collapse_mes">
              <div class="card-header badge-secondary" role="tab" id="heading_mes">
                <h4 class="mb-0">
                  <span class="badge badge-secondary">Siguiente Mes</span>
                </h4>
              </div>
            </a>
            <div id="collapse_mes" class="collapse collapsed" role="tabpanel" aria-labelledby="heading_mes" data-parent="#accordion">
              <div class="card-body">
                <div class="card">
                  <div class="card-body" style="height:300px; overflow: scroll">
                    <div class="row">
                      <div class="col-md-3">
                        <input type="text" id="i_mes_noserie" name="i_mes_noserie" class="form-control" placeholder="No. Serie" style="font-size:14px;" autocomplete="off">
                      </div>
                      <div class="col-md-3">
                        <select id="s_seguimiento_mes_tipo" class="form-control form-control-sm">
                          <option selected="true" disabled="disabled">Seleccione el Tipo:</option>
                          <option value="1">Vehículo</option>
                          <option value="2">Celular</option>
                          <option value="">Todos</option>
                        </select>
                      </div>
                    </div>
                    <table class="tablon" id="t_2">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">No. Serie</th>
                          <th scope="col">No. Económico</th>
                          <th scope="col">IMEI GPS</th>
                          <th scope="col">Tipo</th>
                          <th scope="col">DESCRIPCIÓN</th>
                          <th scope="col">Vencimiento</th>
                          <th scope="col">Fecha Vencimiento</th>
                        </tr>
                      </thead>
                      <tbody id="t_seguimiento_mes">
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <br>
          <!-- Tabla Sin Atender - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
          <div class="col-md-12">
            <a id="link_vencido" alt='1' class="collapsed" data-toggle="collapse" href="#collapse_vencido" aria-expanded="true" aria-controls="collapse_vencido">
              <div class="card-header badge-secondary" role="tab" id="heading_vencido">
                <h4 class="mb-0">
                  <span class="badge badge-secondary">Vencido</span>
                </h4>
              </div>
            </a>
            <div id="collapse_vencido" class="collapse collapsed" role="tabpanel" aria-labelledby="heading_vencido" data-parent="#accordion">
              <div class="card-body">
                <div class="card">
                  <div class="card-body" style="height:300px; overflow: scroll">
                    <div class="row">
                      <div class="col-md-3">
                        <input type="text" id="i_sin_atender_noserie" name="i_sin_atender_noserie" class="form-control" placeholder="No. Serie" style="font-size:14px;" autocomplete="off">
                      </div>
                      <div class="col-md-3">
                        <select id="s_seguimiento_sin_atender_tipo" class="form-control form-control-sm">
                          <option selected="true" disabled="disabled">Seleccione el Tipo:</option>
                          <option value="1">Vehículo</option>
                          <option value="2">Celular</option>
                          <option value="">Todos</option>
                        </select>
                      </div>
                    </div>
                    <table class="tablon" id="t_3">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">No. Serie</th>
                          <th scope="col">No. Económico</th>
                          <th scope="col">IMEI GPS</th>
                          <th scope="col">Tipo</th>
                          <th scope="col">DESCRIPCIÓN</th>
                          <th scope="col">Vencimiento</th>
                          <th scope="col">Fecha Vencimiento</th>
                        </tr>
                      </thead>
                      <tbody id="t_seguimiento_sin_atender">
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <table class="tablon" id="t_final"  hidden> <!-- hidden -->
            <!-- Primer Tabla -->
            <thead id="table_semana">
              <tr>
                <th colspan="6"><h3>Hoy + 30</h3></th>
              </tr>
              <tr class="renglon">
                <th scope="col">No. Serie</th>
                <th scope="col">No. Economico</th>
                <th scope="col">IMEI GPS</th>
                <th scope="col">Tipo</th>
                <th scope="col">DESCRIPCION</th>
                <th scope="col">Vencimiento</th>
                <th scope="col">Fecha Vencimiento</th>
              </tr>
            </thead>
            <tbody id="t_semana_final">
            </tbody>
            <!-- Segunda Tabla -->
            <thead id="table_mes">
              <tr><th colspan="6"></th></tr>
              <tr><th colspan="6"></th></tr>
              <tr>
                <th colspan="6"><h3>Siguiente Mes<h3></th>
              </tr>
              <tr class="renglon">
                <th scope="col">No. Serie</th>
                <th scope="col">No. Economico</th>
                <th scope="col">IMEI GPS</th>
                <th scope="col">Tipo</th>
                <th scope="col">DESCRIPCION</th>
                <th scope="col">Vencimiento</th>
                <th scope="col">Fecha Vencimiento</th>
              </tr>
            </thead>
            <tbody id="t_mes_final">
            </tbody>
            <!-- Tercer Tabla -->
            <thead id="table_vencidos">
              <tr><th colspan="6"></th></tr>
              <tr><th colspan="6"></th></tr>
              <tr>
                <th colspan="6"><h3>Vencidos<h3></th>
              </tr>
              <tr class="renglon">
                <th scope="col">No. Serie</th>
                <th scope="col">No. Economico</th>
                <th scope="col">IMEI GPS</th>
                <th scope="col">Tipo</th>
                <th scope="col">DESCRIPCION</th>
                <th scope="col">Vencimiento</th>
                <th scope="col">Fecha Vencimiento</th>
              </tr>
            </thead>
            <tbody id="t_vencido_final">
            </tbody>
          </table>
          <!-- Modal -->
          <div id="dialog_licencia" class="modal fade bd-example-modal-lg" alt='' id_activo='' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Editar Datos de Licencia</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <!-- Contenido Modal -->
                  <form id="forma_licencia">
                    <div class="row">
                      <div class="col-md-3">
                        <label for="i_no_licencia" class="col-form-label requerido">No. Licencia:</label>
                      </div>
                      <div class="col-md-3">
                        <input type="text" id="i_no_licencia" name="i_no_licencia" class="form-control form-control-sm validate[required]" autocomplete="off">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <label for="i_vigencia_licencia" class="col-form-label requerido">Vigencia Licencia:</label>
                      </div>
                      <div class="col-md-4">
                        <div class="col-md-13">
                          <div class="input-group col-md-13">&nbsp;&nbsp;&nbsp;
                            <input type="text" id="i_vigencia_licencia" name="i_vigencia_licencia" class="form-control form-control-sm fecha validate[required]">
                            <div class="input-group-btn">
                              <button class="btn btn-primary" type="button" style="margin:0px;" disabled>
                                <i class="fa fa-calendar"></i>
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <label id="i_licencia_label" class="col-form-label">Licencia PDF:</label>
                      </div>
                      <div class="col-md-4">
                        <div class="input-group col-sm-12 col-md-12">
                          <input type="file" id="i_licencia" accept="application/pdf" name="i_licencia" class="form-control form-control-sm">
                          <div class="input-group-btn">
                            <!-- Boton oculto de Vista Previa - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
                            <button class="btn btn-primary" type="button" id="preview_licencia" style="margin:0px;">
                              <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" alt='' id="b_licencia_guardar"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button>
                  </div>

                </div>
              </div>
            </div>

            <!-- Modal Mostrar PDF -->
            <div class="modal fade" id="dialog_archivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            	<div class="modal-dialog modal-lg">
            		<div class="modal-content">
            			<div class="modal-header">
                        <h4 class="modal-title" id="label_pdf"></h4>
            				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
            					<span aria-hidden="true">&times;</span>
            				</button>

            			</div>
            			<div class="modal-body">
                    <label style="font-size:10px;">Nota: En caso de reemplazar el archivo y no visualizarse Deshabilitar Cache  <button type="button" class="btn2" id="b__archivo_info" style=""><i class="fa fa-info" aria-hidden="true" style="font-size:9px;"></i></button> </label>
            				<div style="width:100%" id="div_archivo"></div>
            			</div>

            		</div>
            	</div>
            </div>

        </body>
        <script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/js/bootstrap.js"></script>
        <script src="js/jquery.validationEngine.js"></script>
        <script src="js/jquery.validationEngine-es.js"></script>
        <script src="js/general.js"></script>
        <script src="js/bootstrap-datepicker.min.js"></script>
        <script src="vendor/select2/js/select2.js"></script>
<script>
$(document).ready(function(){
  return semanaCelular(),semanaPoliza(), semanaCirculacion(), semanaLicencia();
});
// -----------------------------------------------------------------------------
//  Busqueda de Celular con  Contrato por expirar dentro de la semana actual
// -----------------------------------------------------------------------------
function semanaCelular(){
$.ajax({
  type: "POST",
  url: "php/activos_seguimiento_semana_celular.php",
  data: {},
  dataType: 'json',
  success: function(data){
    salida="";
    for (var i = 0; i < data.length; i++) {
      actual=data[i];
      salida += "<tr id=semana"+actual.tipo+">";
      salida += "<td> &nbsp;" + actual.no_serie + "</td>";
      salida += "<td> &nbsp;" + actual.num_economico + "</td>";
      salida += "<td></td>";
      salida += "<td> Celular </td>";
      salida += "<td>" + actual.descripcion + "</td>";
      salida += "<td> Vigencia de Contrato </td>";
      salida += "<td>" + (actual.vigencia=='0000-00-00'? "Sin Fecha" : actual.vigencia) + "</td>";
      salida += "</tr>";
    }
    $("#t_seguimiento_semana").append(salida);
    st=$('#link_semana').attr('alt');
    if (st==1 || st=='1') {
      $("#t_semana_final").empty();
      $("#t_semana_final").html('');
    }
    else {
      $("#t_semana_final").append(salida);
    }

  },
  error: function (data){
    mandarMensaje("Error con la Busqueda.");
  }
});
}
// Semana Licencia
function semanaLicencia(){
$.ajax({
  type: "POST",
  url: "php/activos_seguimiento_semana_licencia.php",
  data: {},
  dataType: 'json',
  success: function(data){
    salida="";
    for (var i = 0; i < data.length; i++) {
      actual=data[i];
      salida += "<tr class='101' id_activo='"+actual.id_activo+"' alt="+actual.id+" no_licencia='"+actual.no_licencia+"' vigencia='"+actual.vigencia_licencia+"' id=semana"+actual.tipo+">";
      salida += "<td> &nbsp;" + actual.no_serie + "</td>";
      salida += "<td> &nbsp;" + actual.num_economico + "</td>";
      salida += "<td> &nbsp;" + actual.imei_gps + "</td>";
      salida += "<td> Vehiculo </td>";
      salida += "<td>" + actual.descripcion + "</td>";
      salida += "<td> Licencia de Conducir </td>";
      salida += "<td>" + (actual.vigencia_licencia=='0000-00-00'? "Sin Fecha" : actual.vigencia_licencia) + "</td>";
      salida += "</tr>";
    }
    $("#t_seguimiento_semana").append(salida);
    st=$('#link_semana').attr('alt');
    if (st==1 || st=='1') {
      $("#t_semana_final").empty();
      $("#t_semana_final").html('');
    }
    else {
      $("#t_semana_final").append(salida);
    }

  },
  error: function (data){
    mandarMensaje("Error con la Busqueda.");
  }
});
}

// -----------------------------------------------------------------------------
//  Busqueda de Celular con  Contrato por expirar dentro de un mes
// -----------------------------------------------------------------------------
function mesCelular(){
$.ajax({
  type: "POST",
  url: "php/activos_seguimiento_mes_celular.php",
  data: {},
  dataType: 'json',
  success: function(data){
    salida="";
    for (var i = 0; i < data.length; i++) {
      actual=data[i];
      salida += "<tr id=mes"+actual.tipo+">";
      salida += "<td> &nbsp;" + actual.no_serie + "</td>";
      salida += "<td> &nbsp;" + actual.num_economico + "</td>";
      salida += "<td></td>";
      salida += "<td> Celular </td>";
      salida += "<td>" + actual.descripcion + "</td>";
      salida += "<td> Vigencia de Contrato </td>";
      salida += "<td>" + (actual.vigencia=='0000-00-00'? "Sin Fecha" : actual.vigencia) + "</td>";
      salida += "</tr>";
    }
    $("#t_seguimiento_mes").append(salida);
    st=$('#link_mes').attr('alt');
    if (st==1 || st=='1') {
      $("#t_mes_final").empty();
      $("#t_mes_final").html('');
    }
    else {
      $("#t_mes_final").append(salida);
    }
  },
  error: function (data){
    mandarMensaje("Error con la Busqueda.");
  }
});
}

// Semana Licencia
function mesLicencia(){
$.ajax({
  type: "POST",
  url: "php/activos_seguimiento_mes_licencia.php",
  data: {},
  dataType: 'json',
  success: function(data){
    salida="";
    for (var i = 0; i < data.length; i++) {
      actual=data[i];
      salida += "<tr class='101' id_activo='"+actual.id_activo+"' alt="+actual.id+" no_licencia='"+actual.no_licencia+"' vigencia='"+actual.vigencia_licencia+"' id=mes"+actual.tipo+">";
      salida += "<td> &nbsp;" + actual.no_serie + "</td>";
      salida += "<td> &nbsp;" + actual.num_economico + "</td>";
      salida += "<td> &nbsp;" + actual.imei_gps + "</td>";
      salida += "<td> Vehiculo </td>";
      salida += "<td>" + actual.descripcion + "</td>";
      salida += "<td> Licencia de Conducir </td>";
      salida += "<td>" + (actual.vigencia_licencia=='0000-00-00'? "Sin Fecha" : actual.vigencia_licencia) + "</td>";
      salida += "</tr>";
    }
    $("#t_seguimiento_mes").append(salida);
    st=$('#link_mes').attr('alt');
    if (st==1 || st=='1') {
      $("#t_mes_final").empty();
      $("#t_mes_final").html('');
    }
    else {
      $("#t_mes_final").append(salida);
    }

  },
  error: function (data){
    mandarMensaje("Error con la Busqueda.");
  }
});
}
// -----------------------------------------------------------------------------
//  Busqueda de Celular con  Contrato expirado o sin atender (0000-00-00)
// -----------------------------------------------------------------------------
function vencidoCelular(){
$.ajax({
  type: "POST",
  url: "php/activos_seguimiento_sin_atender_celular.php",
  data: {},
  dataType: 'json',
  success: function(data){
    salida="";
    for (var i = 0; i < data.length; i++) {
      actual=data[i];
      salida += "<tr id=sinatender"+actual.tipo+">";
      salida += "<td> &nbsp;" + actual.no_serie + "</td>";
      salida += "<td> &nbsp;" + actual.num_economico + "</td>";
      salida += "<td></td>";
      salida += "<td> Celular </td>";
      salida += "<td>" + actual.descripcion + "</td>";
      salida += "<td> Vigencia de Contrato </td>";
      salida += "<td>" + (actual.vigencia=='0000-00-00'? "Sin Fecha" : actual.vigencia) + "</td>";
      salida += "</tr>";
    }
    $("#t_seguimiento_sin_atender").append(salida);
    st=$('#link_vencido').attr('alt');
    if (st==1 || st=='1') {
      $("#t_vencido_final").empty();
      $("#t_vencido_final").html('');
    }
    else {
      $("#t_vencido_final").append(salida);
    }
  },
  error: function (data){
    mandarMensaje("Error con la Busqueda.");
  }
});
}

function vencidoLicencia(){
$.ajax({
  type: "POST",
  url: "php/activos_seguimiento_sin_atender_licencia.php",
  data: {},
  dataType: 'json',
  success: function(data){
    salida="";
    for (var i = 0; i < data.length; i++) {
      actual=data[i];
      salida += "<tr class='101' alt="+actual.id+" id_activo='"+actual.id_activo+"' no_licencia='"+actual.no_licencia+"' vigencia='"+actual.vigencia_licencia+"' id=mes"+actual.tipo+">";
      salida += "<td> &nbsp;" + actual.no_serie + "</td>";
      salida += "<td> &nbsp;" + actual.num_economico + "</td>";
      salida += "<td> &nbsp;" + actual.imei_gps + "</td>";
      salida += "<td> Vehiculo </td>";
      salida += "<td>" + actual.descripcion + "</td>";
      salida += "<td> Licencia de Conducir </td>";
      salida += "<td>" + (actual.vigencia_licencia=='0000-00-00'? "Sin Fecha" : actual.vigencia_licencia) + "</td>";
      salida += "</tr>";
    }
    $("#t_seguimiento_sin_atender").append(salida);
    st=$('#link_vencido').attr('alt');
    if (st==1 || st=='1') {
      $("#t_vencido_final").empty();
      $("#t_vencido_final").html('');
    }
    else {
      $("#t_vencido_final").append(salida);
    }
  },
  error: function (data){
    mandarMensaje("Error con la Busqueda.");
  }
});
}

// -----------------------------------------------------------------------------
//  Busqueda de Vehiculos con  Poliza expira en un una semana
// -----------------------------------------------------------------------------
function semanaPoliza(){
$.ajax({
  type: "POST",
  url: "php/activos_seguimiento_semana_vehiculo_poliza.php",
  data: {},
  dataType: 'json',
  success: function(data){
    salida="";
    for (var i = 0; i < data.length; i++) {
      actual=data[i];
      salida += "<tr id=semana"+actual.tipo+">";
      salida += "<td> &nbsp;" + actual.no_serie + "</td>";
      salida += "<td> &nbsp;" + actual.num_economico + "</td>";
      salida += "<td> &nbsp;" + actual.imei_gps + "</td>";
      salida += "<td> Vehiculo </td>";
      salida += "<td>" + actual.descripcion + "</td>";
      salida += "<td> Vigencia Poliza </td>";
      salida += "<td>" + (actual.vigencia_poliza=='0000-00-00'? "Sin Fecha" : actual.vigencia_poliza) + "</td>";
      salida += "</tr>";
    }
    $("#t_seguimiento_semana").append(salida);
    st=$('#link_semana').attr('alt');
    if (st==1 || st=='1') {
      $("#t_semana_final").empty();
      $("#t_semana_final").html('');
    }
    else {
      $("#t_semana_final").append(salida);
    }
  },
  error: function (data){
    mandarMensaje("Error con la Busqueda.");
  }
});
}
// -----------------------------------------------------------------------------
//  Busqueda de Vehiculos con  Poliza expirada o sin Atender
// -----------------------------------------------------------------------------
function vencidoPoliza(){
$.ajax({
  type: "POST",
  url: "php/activos_seguimiento_sin_atender_vehiculo_poliza.php",
  data: {},
  dataType: 'json',
  success: function(data){
    salida="";
    for (var i = 0; i < data.length; i++) {
      actual=data[i];
      salida += "<tr id=sinatender"+actual.tipo+">";
      salida += "<td> &nbsp;" + actual.no_serie + "</td>";
      salida += "<td> &nbsp;" + actual.num_economico + "</td>";
      salida += "<td> &nbsp;" + actual.imei_gps + "</td>";
      salida += "<td> Vehiculo </td>";
      salida += "<td>" + actual.descripcion + "</td>";
      salida += "<td> Vigencia Poliza </td>";
      salida += "<td>" + (actual.vigencia_poliza=='0000-00-00'? "Sin Fecha" : actual.vigencia_poliza) + "</td>";
      salida += "</tr>";
    }
    $("#t_seguimiento_sin_atender").append(salida);
    st=$('#link_vencido').attr('alt');
    if (st==1 || st=='1') {
      $("#t_vencido_final").empty();
      $("#t_vencido_final").html('');
    }
    else {
      $("#t_vencido_final").append(salida);
    }
  },
  error: function (data){
    mandarMensaje("Error con la Busqueda.");
  }
});
}
// -----------------------------------------------------------------------------
//  Busqueda de Vehiculos con  Poliza expira en un Mes
// -----------------------------------------------------------------------------
function mesPoliza(){
$.ajax({
  type: "POST",
  url: "php/activos_seguimiento_mes_vehiculo_poliza.php",
  data: {},
  dataType: 'json',
  success: function(data){
    salida="";
    for (var i = 0; i < data.length; i++) {
      actual=data[i];
      salida += "<tr id=mes"+actual.tipo+">";
      salida += "<td> &nbsp;" + actual.no_serie + "</td>";
      salida += "<td> &nbsp;" + actual.num_economico + "</td>";
      salida += "<td> &nbsp;" + actual.imei_gps + "</td>";
      salida += "<td> Vehiculo </td>";
      salida += "<td>" + actual.descripcion + "</td>";
      salida += "<td> Vigencia Poliza </td>";
      salida += "<td>" + (actual.vigencia_poliza=='0000-00-00'? "Sin Fecha" : actual.vigencia_poliza) + "</td>";
      salida += "</tr>";
    }
    $("#t_seguimiento_mes").append(salida);
    st=$('#link_mes').attr('alt');
    if (st==1 || st=='1') {
      $("#t_mes_final").empty();
      $("#t_mes_final").html('');
    }
    else {
      $("#t_mes_final").append(salida);
    }
  },
  error: function (data){
    mandarMensaje("Error con la Busqueda.");
  }
});
}
// -----------------------------------------------------------------------------
//  Busqueda de Vehiculos con Targeta de Circulacion que expira en la semana actual
// -----------------------------------------------------------------------------
function semanaCirculacion(){
$.ajax({
  type: "POST",
  url: "php/activos_seguimiento_semana_vehiculo_circulacion.php",
  data: {},
  dataType: 'json',
  success: function(data){
    salida="";
    for (var i = 0; i < data.length; i++) {
      actual=data[i];
      salida += "<tr id=semana"+actual.tipo+">";
      salida += "<td> &nbsp;" + actual.no_serie + "</td>";
      salida += "<td> &nbsp;" + actual.num_economico + "</td>";
      salida += "<td> &nbsp;" + actual.imei_gps + "</td>";
      salida += "<td> Vehiculo </td>";
      salida += "<td>" + actual.descripcion + "</td>";
      salida += "<td> Vigencia Targeta de Circulacion </td>";
      salida += "<td>" + (actual.vigencia_tarjeta_circulacion=='0000-00-00'? "Sin Fecha" : actual.vigencia_tarjeta_circulacion) + "</td>";
      salida += "</tr>";
    }
    $("#t_seguimiento_semana").append(salida);
    st=$('#link_semana').attr('alt');
    if (st==1 || st=='1') {
      $("#t_semana_final").empty();
      $("#t_semana_final").html('');
    }
    else {
      $("#t_semana_final").append(salida);
    }
  },
  error: function (data){
    mandarMensaje("Error con la Busqueda.");
  }
});
}
// -----------------------------------------------------------------------------
//  Busqueda de Vehiculos con Targeta de Circulacion que expira dentro de 30 dias
// -----------------------------------------------------------------------------
function mesCirculacion(){
$.ajax({
  type: "POST",
  url: "php/activos_seguimiento_mes_vehiculo_circulacion.php",
  data: {},
  dataType: 'json',
  success: function(data){
    salida="";
    for (var i = 0; i < data.length; i++) {
      actual=data[i];
      salida += "<tr id=mes"+actual.tipo+">";
      salida += "<td> &nbsp;" + actual.no_serie + "</td>";
      salida += "<td> &nbsp;" + actual.num_economico + "</td>";
      salida += "<td> &nbsp;" + actual.imei_gps + "</td>";
      salida += "<td> Vehiculo </td>";
      salida += "<td>" + actual.descripcion + "</td>";
      salida += "<td> Vigencia Targeta de Circulacion </td>";
      salida += "<td>" + (actual.vigencia_tarjeta_circulacion=='0000-00-00'? "Sin Fecha" : actual.vigencia_tarjeta_circulacion) + "</td>";
      salida += "</tr>";
    }
    $("#t_seguimiento_mes").append(salida);
    st=$('#link_mes').attr('alt');
    if (st==1 || st=='1') {
      $("#t_mes_final").empty();
      $("#t_mes_final").html('');
    }
    else {
      $("#t_mes_final").append(salida);
    }
  },
  error: function (data){
    mandarMensaje("Error con la Busqueda.");
  }
});
}
// -----------------------------------------------------------------------------
//  Busqueda de Vehiculos con Targeta de Circulacion expirada o sin atender
// -----------------------------------------------------------------------------
function vencidoCirculacion(){
$.ajax({
  type: "POST",
  url: "php/activos_seguimiento_sin_atender_vehiculo_circulacion.php",
  data: {},
  dataType: 'json',
  success: function(data){
    salida="";
    for (var i = 0; i < data.length; i++) {
      actual=data[i];
      salida += "<tr id=sinatender"+actual.tipo+">";
      salida += "<td> &nbsp;" + actual.no_serie + "</td>";
      salida += "<td> &nbsp;" + actual.num_economico + "</td>";
      salida += "<td> &nbsp;" + actual.imei_gps + "</td>";
      salida += "<td> Vehiculo </td>";
      salida += "<td>" + actual.descripcion + "</td>";
      salida += "<td> Vigencia Targeta de Circulacion </td>";
      salida += "<td>" + (actual.vigencia_tarjeta_circulacion=='0000-00-00'? "Sin Fecha" : actual.vigencia_tarjeta_circulacion) + "</td>";
      salida += "</tr>";
    }
    $("#t_seguimiento_sin_atender").append(salida);
    st=$('#link_vencido').attr('alt');
    if (st==1 || st=='1') {
      $("#t_vencido_final").empty();
      $("#t_vencido_final").html('');
    }
    else {
      $("#t_vencido_final").append(salida);
    }
  },
  error: function (data){
    mandarMensaje("Error con la Busqueda.");
  }
});
}
// -----------------------------------------------------------------------------
//  Busqueda por Tipo en la primera tabla
// -----------------------------------------------------------------------------
$("#s_seguimiento_semana_tipo").change(function(){
  tipo = $("#s_seguimiento_semana_tipo option:selected").val();
  $('#i_semana_noserie').val('');
  if (tipo=="1") {
    $("tr#semana2").hide();
    $("tr#semana1").show();
  }
  else if (tipo=="2") {
    $("tr#semana1").hide();
    $("tr#semana2").show();
  }
  else {
    $("tr#semana1").show();
    $("tr#semana2").show();
  }
});

// -----------------------------------------------------------------------------
//  Busqueda por numero de serie en la primera tabla
// -----------------------------------------------------------------------------
$("#i_semana_noserie").keyup(function(){
  input = document.getElementById("i_semana_noserie");
  filter = input.value.toUpperCase();
  table = document.getElementById("t_seguimiento_semana");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
});

$("#i_semana_noserie").keyup(function(){
  input = document.getElementById("i_semana_noserie");
  filter = input.value.toUpperCase();
  table = document.getElementById("t_semana_final");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
});

// -----------------------------------------------------------------------------
//  Busqueda por tipo en la segunda tabla
// -----------------------------------------------------------------------------
$("#s_seguimiento_mes_tipo").change(function(){
  tipo = $("#s_seguimiento_mes_tipo option:selected").val();
  $('#i_mes_noserie').val('');
  if (tipo=="1") {
    $("tr#mes2").hide();
    $("tr#mes1").show();
  }
  else if (tipo=="2") {
    $("tr#mes1").hide();
    $("tr#mes2").show();
  }
  else {
    $("tr#mes1").show();
    $("tr#mes2").show();
  }
});
// -----------------------------------------------------------------------------
//  Busqueda por no. serie en la segunda tabla
// -----------------------------------------------------------------------------
$("#i_mes_noserie").keyup(function(){
  input = document.getElementById("i_mes_noserie");
  filter = input.value.toUpperCase();
  table = document.getElementById("t_seguimiento_mes");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
});

$("#i_mes_noserie").keyup(function(){
  input = document.getElementById("i_mes_noserie");
  filter = input.value.toUpperCase();
  table = document.getElementById("t_mes_final");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
});

// -----------------------------------------------------------------------------
//  Busqueda por tipo en la tercer tabla
// -----------------------------------------------------------------------------
$("#s_seguimiento_sin_atender_tipo").change(function(){
  tipo = $("#s_seguimiento_sin_atender_tipo option:selected").val();
  $('#i_sin_atender_noserie').val('');
  if (tipo=="1") {
    $("tr#sinatender2").hide();
    $("tr#sinatender1").show();
  }
  else if (tipo=="2") {
    $("tr#sinatender1").hide();
    $("tr#sinatender2").show();
  }
  else {
    $("tr#sinatender1").show();
    $("tr#sinatender2").show();
  }
});
// -----------------------------------------------------------------------------
//  Busqueda por no. serie en la tercer tabla
// -----------------------------------------------------------------------------
$("#i_sin_atender_noserie").keyup(function(){
  input = document.getElementById("i_sin_atender_noserie");
  filter = input.value.toUpperCase();
  table = document.getElementById("t_seguimiento_sin_atender");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
});

$("#i_sin_atender_noserie").keyup(function(){
  input = document.getElementById("i_sin_atender_noserie");
  filter = input.value.toUpperCase();
  table = document.getElementById("t_vencido_final");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
});

// -----------------------------------------------------------------------------
//  Exportar a Excel
// -----------------------------------------------------------------------------
$("#b_excel").click(function(e) {
    var aux = new Date();
    var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
    filename = 'Seguimiento_Activos_'+hoy;
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById('t_final');
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');  //'&nbsp;'
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    // Create download link element
    downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
        // Setting the file name
        downloadLink.download = filename;
        //triggering the function
        downloadLink.click();
    }
});

$('#link_semana').click(function(){
  $("#t_seguimiento_semana").html('');
  st = $('#link_semana').attr('alt');
  if (st == 2){
    $('#link_semana').attr('alt',1);
  }
  else{
    $('#link_semana').attr('alt',2);
  }
  return semanaPoliza(), semanaCirculacion(), semanaCelular(), semanaLicencia();
});

$('#link_mes').click(function(){
  $("#t_seguimiento_mes").html('');
  st = $('#collapse_mes').attr('class');
  if (st == 'collapsed collapse show'){
    $('#link_mes').attr('alt',1);
  }
  else{
    $('#link_mes').attr('alt',2);
  }
   return mesPoliza(), mesCirculacion(), mesCelular(), mesLicencia();
});

$('#link_vencido').click(function(){
  $("#t_seguimiento_sin_atender").html('');
  st = $('#collapse_vencido').attr('class');
  if (st == 'collapsed collapse show'){
    $('#link_vencido').attr('alt',1);
  }
  else{
    $('#link_vencido').attr('alt',2);
  }
  return vencidoPoliza(), vencidoCirculacion(), vencidoCelular(), vencidoLicencia();
});

// Modal Editar campos Licencia al dar dos click en Licencia
$('#t_seguimiento_semana').on('dblclick', '.101', function(){
  idActivo = $(this).attr('alt');
  licencia = $(this).attr('no_licencia');
  vigencia = $(this).attr('vigencia');
  id = $(this).attr('id_activo');
  $("#dialog_licencia").attr('alt',idActivo);
  $("#i_no_licencia").val(licencia);
  $("#i_vigencia_licencia").val(vigencia);
  $('#preview_licencia').attr('alt',id);
  $("#dialog_licencia").modal('show');
});

$('#t_seguimiento_mes').on('dblclick', '.101', function(){
  idActivo = $(this).attr('alt');
  licencia = $(this).attr('no_licencia');
  vigencia = $(this).attr('vigencia');
  id = $(this).attr('id_activo');
  $("#dialog_licencia").attr('alt',idActivo);
  $("#i_no_licencia").val(licencia);
  $("#i_vigencia_licencia").val(vigencia);
  $('#preview_licencia').attr('alt',id);
  $("#dialog_licencia").modal('show');
});

$('#t_seguimiento_sin_atender').on('dblclick', '.101', function(){
  idActivo = $(this).attr('alt');
  licencia = $(this).attr('no_licencia');
  vigencia = $(this).attr('vigencia');
  id = $(this).attr('id_activo');
  $("#dialog_licencia").attr('alt',idActivo);
  $("#i_no_licencia").val(licencia);
  $("#i_vigencia_licencia").val(vigencia);
  $('#preview_licencia').attr('alt',id);
  $("#dialog_licencia").modal('show');
});


// Validar Entradas Modal Licencia
$("#b_licencia_guardar").click(function(){
  $('#b_licencia_guardar').prop('disabled',true);
  if ($('#forma_licencia').validationEngine('validate')){

    $('#b_licencia_guardar').prop('disabled',false);
    return actualizarLicencia();
  }else{
    $('#b_licencia_guardar').prop('disabled',false);
  }
});

$('#b__archivo_info').click(function(){
  mandarMensaje("<h5>Deshabilitar Cache:</h5> <br> <h8> 1. Click Derecho sobre cualquier parte del Sistema y Abrir 'Inspeccionar' <br> 2. Ir a la pestaña Network en la ventana que se abrio <br> 3. Marcar la casilla 'Disable Cache' y cerrar la ventana <br> 4. Recargar la pagina y seleccionar el activo.</h8>");
});

function actualizarLicencia(){
  no_lic = $("#i_no_licencia").val();
  vig_lic = $("#i_vigencia_licencia").val();
  id = $('#dialog_licencia').attr('alt');
  id_activo = $('#preview_licencia').attr('alt');
  $.ajax({
    type: "POST",
    url: "php/activos_actualizar_licencia.php",
    data: {'no_lic':no_lic, 'vig_lic':vig_lic, 'id':id, 'id_activo':id_activo},
    // dataType: 'json',
    success: function(data){
      if (data==true) {
        mandarMensaje("Modificado con Exito!.");
      }
      else {
        mandarMensaje("Ocurrio un Error, intentelo mas tarde.");
      }
      // vencidoCelular(), mesCelular(), semanaCelular(), vencidoPoliza(), mesPoliza(), semanaPoliza(), vencidoCirculacion(), mesCirculacion(), semanaCirculacion()
      return guardarLicenciaPDF();
    },
    error: function (data){
      mandarMensaje("Error con la Peticion.");
    }
  });

}

// Mostrar PDF Licencia en Modal
$('#preview_licencia').click(function(){
  return licenciaPDF();
});
function licenciaPDF(){
    $("#div_archivo").empty();
    id = $('#preview_licencia').attr('alt');
    if (id=='' || id==null) {
      mandarMensaje("No se ah Guardado o Seleccionado un Activo");
    }
    else {
      var ruta='activosPdf/formato_licencia_'+id+'.pdf';
      var fil="<embed width='100%' height='500px' src='"+ruta+"'>";
      $('#label_pdf').html('Licencia PDF')
      $.ajax({
        url:ruta,
        type:'HEAD',
        error: function()
        {
          mandarMensaje('Este activo no contiene archivo PDF guardado');
        },
        success: function()
        {
          $("#div_archivo").append(fil);
          $('#dialog_archivo').modal('show');
        }
      });
    }
}

function guardarLicenciaPDF(){
  var form = $('#forma_licencia');
  var file2 = $('#i_licencia');

  var archivo = file2[0].files;
  var formData = new FormData(form[0]);
  formData.append('archivo',archivo);
  jQuery.ajax({
    url: 'php/activos_guardar_pdf_licencia.php',
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    type: 'POST',
    success: function(data){
      console.log(data);
      location.reload();
    },
    error: function(data){
      mandarMensaje("Error al Subir el archivo");
    }
  });
}

// input fecha ----------------------------------------------------------------------------------------------
$('.fecha').datepicker({
  format : "yyyy-mm-dd",
  autoclose: true,
  language: "es",
  todayHighlight: true
});

</script>
</html>
