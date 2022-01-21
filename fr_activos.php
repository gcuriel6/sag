<?php
session_start();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="expires" content="0">
  <meta http-equiv="Cache-Control" content="no-cache">
  <meta http-equiv="Pragma" CONTENT="no-cache">
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

.modal-lg{
        min-width: 1000px;
        max-width: 1000px;
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
  .modal-lg{
        min-width: 900px;
        max-width: 900px;
    }
}
@media screen and(max-width: 1030px){
    .modal-lg{
        min-width: 900px;
        max-width: 900px;
    }
}
.btn2 {
  background-color: DodgerBlue;
  border: none;
  color: white;
  padding: 5px 5px;
  font-size: 16px;
  cursor: pointer;
}

/* Darker background on mouse-over */
.btn2:hover {
  background-color: RoyalBlue;
}
#dialog_responsable >  .modal-lg{
   
   min-width: 70%;
   max-width: 70%;
}
</style>

<body>
  <div class="container-fluid" id="div_principal">
    <div class="row">
      <div class="col-md-12" id="div_contenedor">
        <br>
        <div class="form-group row">
          <div class="col-sm-12 col-md-2">
            <div class="titulo_ban">Activos Fijos</div>
          </div>
          <div class="col-sm-12 col-md-2" id="div_cont_estatus" style="text-align:center;">
            <div id="div_estatus"></div>
          </div>
          <div class="col-sm-12 col-md-2">
            <button type="button" class="btn btn-dark btn-sm form-control" id="b_buscar_activo"><i class="fa fa-search" aria-hidden="true"></i> Buscar Activo</button>
          </div>
          <div class="col-sm-12 col-md-2">
            <button type="button" class="btn btn-dark btn-sm form-control" id="b_nuevo"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
          </div>

          <div class="col-sm-12 col-md-2" id="div_b_guardar_activo">
            <button type="button" alt='' alt2='' class="btn btn-dark btn-sm form-control" id="b_guardar_activo"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
          </div>
        </div>

        <!-- Acordeon Datos Generales - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->

        <div class="col-md-12">
          <a id="link_generales" class="collapsed" data-toggle="collapse" href="#collapse_generales" aria-expanded="true" aria-controls="collapse_generales">
            <div class="card-header badge-secondary" role="tab" id="heading_generales">
              <h4 class="mb-0">
                <div class="row">
                  <div class="col-md-11">
                    <span class="badge badge-secondary">Datos Generales</span>
                  </div>
                  <div class="col-md-1">
                    <div id="flotante" style="display:none;"><i style="color:green;" class="fa fa-check"></i></div>
                  </div>
                </div>
              </h4>
            </div>
          </a>
          <div id="collapse_generales" class="collapsed collapse show" role="tabpanel" aria-labelledby="heading_generales" data-parent="#accordion">
            <div class="card-body">
              <form id="forma_generales" name="forma_generales" action="" method="post" enctype="multipart/form-data">
                <!-- formulario -->
                <div class="row">
                  <div class="col-md-2">
                    <label for="s_propietario" class="col-form-label requerido">Propietario:</label>
                  </div>
                  <div class="col-md-3">
                    <select id="s_propietario" name="s_propietario" class="form-control form-control-sm validate[required]"></select>
                  </div>
                  <!--<div class="col-md-1">
                    <label for="s_filtro_sucursal" class="col-form-label requerido">Sucursal:</label>
                  </div>
                  <div class="col-sm-2 col-md-2">
                    <select id="s_filtro_sucursal" name="s_filtro_sucursal" class="form-control validate[required]" placeholder="Sucursal" autocomplete="off"></select>
                  </div>-->
                  <div class="col-md-auto">
                    <label for="i_no_serie" class="col-form-label requerido">Folio Recepción:</label>
                  </div>
                  <div class="col-md-2">
                    <div class="input-group col-md-12">
                      <input type="text" id="i_folio_recepcion"  name="i_folio_recepcion" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                      <div class="input-group-btn">
                        <!-- Boton busqueda recepcion - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
                        <button class="btn btn-primary" type="button" id="b_buscar_recepcion"  style="margin:0px;">
                          <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3">
                    <div class="row">
                      <div class="col-sm-12 col-md-8"></div> 
                      <div class="col-sm-12 col-md-4">
                        Inactivo <input type="checkbox" id="ch_inactivo" name="ch_inactivo" value="" disabled>
                      </div>  
                    </div>
                    <div class="row">
                      <div class="col-sm-12 col-md-12">
                        <label id="label_reactivar"></label>
                      </div> 
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label for="i_no_serie" class="col-form-label requerido">No. Serie:</label>
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-md-8">
                        <input type="text" id="i_no_serie" name="i_no_serie" class="form-control form-control-sm validate[required]" autocomplete="off">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2"></div>
                  
                  
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label for="i_num_eco" class="col-form-label requerido">Número económico:</label>
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-md-8">
                        <input type="text" id="i_num_eco" name="i_num_eco" class="form-control form-control-sm validate[required]" autocomplete="off">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label for="i_descripcion" class="col-form-label requerido">Descripción:</label>
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-md-8">
                        <input style="width:600px;"type="text" id="i_descripcion" name="i_descripcion" class="form-control form-control-sm validate[required]" autocomplete="off">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label for="i_cod_barras" class="col-form-label">Código de Barras:</label>
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-md-8">
                        <input type="text" id="i_cod_barras" name="i_cod_barras" class="form-control form-control-sm" autocomplete="off">
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-md-2">
                    <label for="i_fecha_adq" class="col-form-label requerido">Fecha Adquisición:</label>
                  </div>
                  <div class="col-md-2">
                    <div class="input-group col-md-13">
                      <input type="text" id="i_fecha_adq" name="i_fecha_adq" class="form-control form-control-sm validate[required] fecha" readonly autocomplete="off" >
                      <div class="input-group-btn">
                        <button class="btn btn-primary" type="button" style="margin:0px;" disabled>
                          <i class="fa fa-calendar"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="col-auto"><!--4 -->
                    <div class="col-md-12">
                      <label for="i_val_adq" class="col-form-label requerido">Valor Adquisición:</label>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="col-md-12">
                      <input type="text" id="i_val_adq" name="i_val_adq" class="form-control form-control-sm validate[required,custom[number],min[0.01]]" autocomplete="off">
                    </div>
                  </div>
                  <div class="col-auto">
                    <div class="col-md-12">
                      <label for="i_fecha_baja" class="col-form-label" id="label_fecha_baja">Fecha de Baja:</label>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="input-group col-md-13">
                      <input type="text" id="i_fecha_baja" name="i_fecha_baja" class="form-control form-control-sm fecha" readonly disabled autocomplete="off">
                      <div class="input-group-btn">
                        <button class="btn btn-primary" type="button" style="margin:0px;" disabled>
                          <i class="fa fa-calendar"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-auto">
                    <input type="radio" name="r_compra" id="r_contado" value="1" checked>
                    <label for="r_contado" class="col-form-label">Contado</label>
                  </div>
                  <div class="col-auto">
                    <input type="radio" name="r_compra" id="r_credito" value="2">
                    <label for="i_credito" class="col-form-label">Crédito</label>
                  </div>
                  <div class="col-auto">
                    <input type="radio" name="r_compra" id="r_arrendamiento" value="3">
                    <label for="i_arrendamiento" class="col-form-label">Arrendamiento</label>
                  </div>
                  <div class="col-md-2">
                  </div>
                  <div class="col-auto">
                    <label for="i_anticipo" class="col-form-label">Anticipo:</label>
                  </div>
                  <div class="col-auto">
                    <input type="text" id="i_anticipo" name="i_anticipo" class="form-control form-control-sm validate[custom[number],min[0.00]]" value="0.00" autocomplete="off">
                  </div>
                  <div class="col-auto">
                    <label for="i_mensualidades" class="col-form-label">  Mensualidades:</label>
                  </div>
                  <div class="col-auto">
                    <input type="text" id="i_mensualidades" name="i_mensualidades" class="form-control form-control-sm validate[custom[integer],minSize[1]]" value="0" autocomplete="off">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label for="i_amortizacion" class="col-form-label">Tabla de Amortización:</label>
                  </div>
                  <div class="col-md-4">
                    <div class="input-group col-md-12">
                      <input type="file" id="i_amortizacion" accept="application/pdf" name="i_amortizacion" class="form-control form-control-sm">
                      <div class="input-group-btn">
                        <!-- Boton oculto de Vista Previa - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
                        <button class="btn btn-primary" type="button" id="preview_amortizacion"  style="margin:0px;">
                          <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="col-auto">
                    <label id="l_fecha_fin_credito" class="col-form-label requerido">Fin de Crédito o Arrendamiento:</label>
                  </div>
                  <div class="col-md-2">
                    <div class="input-group col-md-13">
                      <input type="text" id="i_fecha_fin_credito" name="i_fecha_fin_credito" class="form-control form-control-sm validate[required] fecha" autocomplete="off">
                      <div class="input-group-btn">
                        <button class="btn btn-primary" type="button" style="margin:0px;" disabled>
                          <i class="fa fa-calendar"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-2">
                    <label for="i_observaciones" class="col-form-label">Observaciones:</label>
                  </div>
                  <div class="col-md-10">
                    <textarea type="text" id="i_observaciones" name="i_observaciones" class="form-control form-control-sm" autocomplete="off"></textarea>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label class="col-form-label">Tipo:</label>
                  </div>
                  <div class="col-auto div_r_global" style="display:none;">
                    <input type="radio" name="r_tipo" id="r_vehiculo" value="1">
                    <label for="i_vehiculo" class="col-form-label">Vehículo</label>
                  </div>
                  <div class="col-md-1 div_r_global" style="display:none;">
                    <input type="radio" name="r_tipo" id="r_celular" value="2">
                    <label for="i_celular" class="col-form-label">Celular</label>
                  </div>
                  <div class="col-md-2 div_r_global" style="display:none;">
                    <input type="radio" name="r_tipo" id="r_eq_computo" value="3">
                    <label for="i_eq_computo" class="col-form-label">Equipo de Computo</label>
                  </div>
                  <div class="col-md-1"  id="div_r_armas" style="display:none;">
                    <input type="radio" name="r_tipo" id="r_armas" value="5">
                    <label for="i_armas" class="col-form-label">Armas</label>
                  </div>
                  <div class="col-md-2 div_r_global" style="display:none;">
                    <input type="radio" name="r_tipo" id="r_otro" value="4" checked>
                    <label for="i_otro" class="col-form-label">Otro</label>
                  </div>
                </div>

                <!-- fin tabla -->
              </form>
            </div>
          </div>
        </div>
        

        <!-- Acordeon Vehiculo - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  -->
        <div class="col-md-12">
          <a id="link_vehiculo" class="collapsed" data-toggle="collapse" href="#collapse_vehiculo" aria-expanded="true" aria-controls="collapse_vehiculo">
            <div class="card-header badge-secondary" role="tab" id="heading_vehiculo">
              <h4 class="mb-0">
                <div class="row">
                  <div class="col-md-3">
                    <span class="badge badge-secondary">Vehículo</span>
                  </div>
                </div>
              </h4>
            </div>
          </a>
          <div id="collapse_vehiculo" class="collapse collapsed" role="tabpanel" aria-labelledby="heading_vehiculo" data-parent="#accordion">
            <div class="card-body">

              <form id="forma_vehiculo" name="forma_vehiculo">
                <div class="row">
                  <div class="col-md-1">
                    <label for="s_veh_tipo" class="col-form-label requerido">Tipo:</label>
                  </div>
                  <div class="col-md-3">
                    <div class="input-group col-md-13">
                      <select id="s_veh_tipo" name="s_veh_tipo" class="form-control form-control-sm validate[required]" autocomplete="off"></select>
                      <button id="b_veh_tipo" class="btn btn-primary" type="button" style="margin:0px;" onclick="">
                        <i class="fa fa-plus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <label for="i_veh_poliza" class="col-form-label">Póliza:</label>
                  </div>
                  <div class="col-md-4">
                    <div class="input-group col-sm-12 col-md-12">
                      <input type="file" id="i_veh_poliza" accept="application/pdf" name="i_veh_poliza" class="form-control form-control-sm">
                      <div class="input-group-btn">
                        <!-- Boton oculto de Vista Previa - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
                        <button class="btn btn-primary" type="button" id="preview_poliza" style="margin:0px;">
                          <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-1">
                    <label for="s_veh_marca" class="col-form-label requerido">Marca:</label>
                  </div>
                  <div class="col-md-3">
                    <div class="input-group col-md-13">
                      <select id="s_veh_marca" name="s_veh_marca" class="form-control form-control-sm validate[required]" autocomplete="off"></select>
                      <button id="b_veh_marca" class="btn btn-primary" type="button" style="margin:0px;" onclick="">
                        <i class="fa fa-plus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <label for="i_veh_vigencia" class="col-form-label">Vigencia Póliza:</label>
                  </div>
                  <div class="col-md-2">
                    <div class="input-group col-md-13">&nbsp;&nbsp;&nbsp;
                      <input type="text" id="i_veh_vigencia" name="i_veh_vigencia" class="form-control form-control-sm fecha" autocomplete="off">
                      <div class="input-group-btn">
                        <button class="btn btn-primary" type="button" style="margin:0px;" disabled>
                          <i class="fa fa-calendar"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-1">
                    <label for="s_veh_color" class="col-form-label requerido">Color:</label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" id="i_veh_color" name="i_veh_color" class="form-control form-control-sm validate[required]" autocomplete="off">
                  </div>
                  <div class="col-md-2">
                    <label for="i_veh_circulacion" class="col-form-label">Tarjeta de Circulación:</label>
                  </div>
                  <div class="col-md-4">
                    <div class="input-group col-sm-12 col-md-12">
                      <input type="file" id="i_veh_circulacion" accept="application/pdf" name="i_veh_circulacion" class="form-control form-control-sm">
                      <div class="input-group-btn">
                        <!-- Boton oculto de Vista Previa - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
                        <button class="btn btn-primary" type="button" id="preview_circulacion" style="margin:0px;">
                          <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-1">
                    <label for="i_veh_modelo" class="col-form-label requerido">Modelo:</label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" id="i_veh_modelo" name="i_veh_modelo" class="form-control form-control-sm validate[required]" autocomplete="off">
                  </div>
                  <div class="col-md-2">
                    <label for="i_veh_vigencia_circulacion" class="col-form-label">Vigencia Tarjeta Circ.:</label>
                  </div>
                  <div class="col-md-2">
                    <div class="input-group col-md-13">&nbsp;&nbsp;&nbsp;
                      <input type="text" id="i_veh_vigencia_circulacion" name="i_veh_vigencia_circulacion" class="form-control form-control-sm fecha" autocomplete="off">
                      <div class="input-group-btn">
                        <button class="btn btn-primary" type="button" style="margin:0px;" disabled>
                          <i class="fa fa-calendar"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-1">
                    <label for="i_veh_placas" class="col-form-label requerido">Placas:</label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" id="i_veh_placas" name="i_veh_placas" class="form-control form-control-sm validate[required]" autocomplete="off">
                  </div>
                  <div class="col-md-1">
                    <label for="i_imei_gps" class="col-form-label">IMEI GPS:</label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" id="i_imei_gps" name="i_imei_gps" class="form-control form-control-sm" autocomplete="off">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-1">
                    <label for="i_veh_anio" class="col-form-label requerido">Año:</label>
                  </div>
                  <div class="col-md-2">
                    <input type="text" id="i_veh_anio" name="i_veh_anio" class="form-control form-control-sm validate[required,custom[integer],minSize[4],maxSize[4]]" autocomplete="off">
                  </div>
                  <div class="col-md-1"></div>
                  <div class="col-md-2">
                    <label for="i_veh_responsiva_firmada" class="col-form-label">Salida por Responsiva Firmada:</label>
                  </div>
                  <div class="col-md-4">
                    <div class="input-group col-sm-12 col-md-12">
                      <input type="file" id="i_veh_responsiva_firmada" accept="application/pdf" name="i_veh_responsiva_firmada" class="form-control form-control-sm">
                      <div class="input-group-btn">
                        <!-- Boton oculto de Vista Previa - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
                        <button class="btn btn-primary" type="button" id="preview_i_veh_responsiva_firmada" disabled style="margin:0px;">
                          <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        

        <!-- Acordeon Celular - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
        <div class="col-md-12">
          <a id="link_celular" class="collapsed" data-toggle="collapse" href="#collapse_celular" aria-expanded="true" aria-controls="collapse_celular">
            <div class="card-header badge-secondary" role="tab" id="heading_celular">
              <h4 class="mb-0">
                <span class="badge badge-secondary">Celular</span>
              </h4>
            </div>
          </a>
          <div id="collapse_celular" class="collapse collapsed" role="tabpanel" aria-labelledby="heading_celular" data-parent="#accordion">
            <div class="card-body">
              <form id="forma_celular" name="forma_celular">
                <div class="row">
                  <div class="col-md-2">
                    <label for="s_cel_marca" class="col-form-label requerido">Marca:</label>
                  </div>
                  <div class="col-md-3">
                    <div class="input-group col-md-13">
                      <select id="s_cel_marca" name="s_cel_marca" class="form-control form-control-sm validate[required]" autocomplete="off"></select>
                      <button id="b_cel_marca" class="btn btn-primary" type="button" style="margin:0px;" onclick="">
                        <i class="fa fa-plus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <label for="s_cel_compania" class="col-form-label requerido">Compañía:</label>
                  </div>
                  <div class="col-md-3">
                    <div class="input-group col-md-13">
                      <select id="s_cel_compania" name="s_cel_compania" class="form-control form-control-sm validate[required]" autocomplete="off"></select>
                      <button id="b_cel_compania" class="btn btn-primary" type="button" style="margin:0px;" onclick="">
                        <i class="fa fa-plus"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label for="i_cel_modelo" class="col-form-label requerido">Modelo:</label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" id="i_cel_modelo" name="i_cel_modelo" class="form-control form-control-sm validate[required]" autocomplete="off">
                  </div>
                  <div class="col-md-2">
                    <label for="i_cel_paquete" class="col-form-label">Paquete:</label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" id="i_cel_paquete" name="i_cel_paquete" class="form-control form-control-sm" autocomplete="off">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label for="i_cel_imei" class="col-form-label">Código IMEI:</label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" id="i_cel_imei" name="i_cel_imei" class="form-control form-control-sm validate[custom[integer],minSize[14],maxSize[15]]" autocomplete="off">
                  </div>
                  <div class="col-md-2">
                    <label for="i_cel_contrato" class="col-form-label">No. Contrato:</label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" id="i_cel_contrato" name="i_cel_contrato" class="form-control form-control-sm" autocomplete="off">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label for="i_cel_numero" class="col-form-label">Numero Telefónico:</label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" id="i_cel_numero" name="i_cel_numero" class="form-control form-control-sm validate[custom[integer],minSize[10],maxSize[10]]" autocomplete="off">
                  </div>
                  <div class="col-md-2">
                    <label for="i_cel_vigencia_contrato" class="col-form-label">Vigencia de Contrato:</label>
                  </div>
                  <div class="col-md-2">
                    <div class="input-group col-md-13">
                      <input type="text" id="i_cel_vigencia_contrato" name="i_cel_vigencia_contrato" class="form-control form-control-sm fecha" autocomplete="off">
                      <div class="input-group-btn">
                        <button class="btn btn-primary" type="button" style="margin:0px;" disabled>
                          <i class="fa fa-calendar"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                <div class="col-md-2">
                  <label for="i_cel_responsiva_firmada" class="col-form-label">Salida por Responsiva Firmada:</label>
                </div>
                <div class="col-md-4">
                <div class="row">
                  <div class="input-group col-sm-12 col-md-12">
                    <input type="file" id="i_cel_responsiva_firmada" accept="application/pdf" name="i_cel_responsiva_firmada" class="form-control form-control-sm">
                    <div class="input-group-btn">
                      <!-- Boton oculto de Vista Previa - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
                      <button class="btn btn-primary" type="button" id="preview_i_cel_responsiva_firmada" disabled style="margin:0px;">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                      </button>
                    </div>
                  </div>
                  </div>
                </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        

        <!-- Acordeon E. Computo - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->

        <div class="col-md-12">
          <a id="link_computo" class="collapsed" data-toggle="collapse" href="#collapse_computo" aria-expanded="true" aria-controls="collapse_computo">
            <div class="card-header badge-secondary" role="tab" id="heading_computo">
              <h4 class="mb-0">
                <span class="badge badge-secondary">Equipo de Computo</span>
              </h4>
            </div>
          </a>
          <div id="collapse_computo" class="collapse collapsed" role="tabpanel" aria-labelledby="heading_computo" data-parent="#accordion">
            <div class="card-body">
              <form id="forma_computo" name="forma_computo">
                <div class="row">
                  <div class="col-md-2">
                    <label for="s_eq_marca" class="col-form-label requerido">Marca:</label>
                  </div>
                  <div class="col-md-3">
                    <div class="input-group col-md-13">
                      <select id="s_eq_marca" name="s_eq_marca" class="form-control form-control-sm validate[required]" autocomplete="off"></select>
                      <button id="b_eq_marca" class="btn btn-primary" type="button" style="margin:0px;" onclick="">
                        <i class="fa fa-plus"></i>
                      </button>
                    </div>
                  </div>

                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label for="i_eq_modelo" class="col-form-label requerido">Modelo:</label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" id="i_eq_modelo" name="i_eq_modelo" class="form-control form-control-sm validate[required]" autocomplete="off">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label for="s_eq_tipo" class="col-form-label requerido">Tipo:</label>
                  </div>
                  <div class="col-md-3">
                    <div class="input-group col-md-13">
                      <select id="s_eq_tipo" name="s_eq_tipo" class="form-control form-control-sm validate[required]" autocomplete="off"></select>
                      <button id="b_eq_tipo" class="btn btn-primary" type="button" style="margin:0px;" onclick="">
                        <i class="fa fa-plus"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label class="col-form-label requerido">No. Serie Cargador</label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" id="i_cargador" name="i_cargador" class="form-control form-control-sm validate[required]" autocomplete="off">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label for="i_eq_responsiva_firmada" class="col-form-label">Salida por Responsiva Firmada:</label>
                  </div>
                  <div class="col-md-4">
                  <div class="row">
                    <div class="input-group col-sm-12 col-md-12">
                      <input type="file" id="i_eq_responsiva_firmada" accept="application/pdf" name="i_eq_responsiva_firmada" class="form-control form-control-sm">
                      <div class="input-group-btn">
                        <!-- Boton oculto de Vista Previa - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
                        <button class="btn btn-primary" type="button" id="preview_i_eq_responsiva_firmada" disabled style="margin:0px;">
                          <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                      </div>
                    </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label for="i_eq_caracteristicas" class="col-form-label">Características:</label>
                  </div>
                  <div class="col-md-10">
                    <textarea type="text" id="i_eq_caracteristicas" name="i_eq_caracteristicas" class="form-control form-control-sm" autocomplete="off"></textarea>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Acordeon Armas - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
        <div class="col-md-12">
          <a id="link_armas" class="collapsed" data-toggle="collapse" href="#collapse_armas" aria-expanded="true" aria-controls="collapse_armas">
            <div class="card-header badge-secondary" role="tab" id="heading_armas">
              <h4 class="mb-0">
                <span class="badge badge-secondary">Armas</span>
              </h4>
            </div>
          </a>
          <div id="collapse_armas" class="collapse collapsed" role="tabpanel" aria-labelledby="heading_armas" data-parent="#accordion">
            <div class="card-body">
              <form id="forma_armas" name="forma_armas">
                <div class="row">
                  <div class="col-md-2">
                    <label for="s_armas_marca" class="col-form-label requerido">Marca:</label>
                  </div>
                  <div class="col-md-3">
                    <div class="input-group col-md-13">
                      <select id="s_armas_marca" name="s_armas_marca" class="form-control form-control-sm validate[required]" autocomplete="off"></select>
                      <button id="b_armas_marca" class="btn btn-primary" type="button" style="margin:0px;" onclick="">
                        <i class="fa fa-plus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="col-md-1"></div>
                  <div class="col-md-2">
                    <label for="s_armas_clase" class="col-form-label requerido">Clase:</label>
                  </div>
                  <div class="col-md-3">
                    <div class="input-group col-md-13">
                      <select id="s_armas_clase" name="s_armas_clase" class="form-control form-control-sm validate[required]" autocomplete="off"></select>
                      <button id="b_armas_clase" class="btn btn-primary" type="button" style="margin:0px;" onclick="">
                        <i class="fa fa-plus"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label for="i_armas_calibre" class="col-form-label requerido">Calibre:</label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" id="i_armas_calibre" name="i_armas_calibre" class="form-control form-control-sm validate[required]" autocomplete="off">
                  </div>
                  <div class="col-md-1"></div>
                  <div class="col-md-2">
                    <label for="i_armas_fecha_ingreso" class="col-form-label requerido">Fecha Ingreso:</label>
                  </div>
                  <div class="col-md-2">
                    <div class="input-group col-md-13">
                      <input type="text" id="i_armas_fecha_ingreso" name="i_armas_fecha_ingreso" class="form-control form-control-sm fecha" autocomplete="off">
                      <div class="input-group-btn">
                        <button class="btn btn-primary" type="button" style="margin:0px;" disabled>
                          <i class="fa fa-calendar"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label for="i_armas_modelo" class="col-form-label requerido">Modelo:</label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" id="i_armas_modelo" name="i_armas_modelo" class="form-control form-control-sm validate[required]" autocomplete="off">
                  </div>
                  <div class="col-md-1"></div>
                  <div class="col-md-2">
                    <label for="i_armas_fecha_baja" class="col-form-label requerido">Fecha Baja:</label>
                  </div>
                  <div class="col-md-2">
                    <div class="input-group col-md-13">
                      <input type="text" id="i_armas_fecha_baja" name="i_armas_fecha_baja" class="form-control form-control-sm fecha" autocomplete="off">
                      <div class="input-group-btn">
                        <button class="btn btn-primary" type="button" style="margin:0px;" disabled>
                          <i class="fa fa-calendar"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label for="i_armas_matricula" class="col-form-label requerido">Matricula:</label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" id="i_armas_matricula" name="i_armas_matricula" class="form-control form-control-sm validate[required]" autocomplete="off">
                  </div>
                  <div class="col-md-1"></div>
                  <div class="col-md-2">
                    <label for="i_armas_responsiva_firmada" class="col-form-label">Salida por Responsiva Firmada:</label>
                  </div>
                  <div class="col-md-4">
                  <div class="row">
                    <div class="input-group col-sm-12 col-md-12">
                      <input type="file" id="i_armas_responsiva_firmada" accept="application/pdf" name="i_armas_responsiva_firmada" class="form-control form-control-sm">
                      <div class="input-group-btn">
                        <!-- Boton oculto de Vista Previa - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
                        <button class="btn btn-primary" type="button" id="preview_i_armas_responsiva_firmada" disabled style="margin:0px;">
                          <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                      </div>
                    </div>
                    </div>
                  </div>
                </div>
                <!--<div class="row">
                  <div class="col-md-2">
                    <label for="s_eq_tipo" class="col-form-label requerido">Tipo:</label>
                  </div>
                  <div class="col-md-3">
                    <div class="input-group col-md-13">
                      <select id="s_eq_tipo" name="s_eq_tipo" class="form-control form-control-sm validate[required]" autocomplete="off"></select>
                      <button id="b_eq_tipo" class="btn btn-primary" type="button" style="margin:0px;" onclick="">
                        <i class="fa fa-plus"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label class="col-form-label requerido">No. Serie Cargador</label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" id="i_cargador" name="i_cargador" class="form-control form-control-sm validate[required]" autocomplete="off">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label for="i_eq_caracteristicas" class="col-form-label">Características:</label>
                  </div>
                  <div class="col-md-10">
                    <textarea type="text" id="i_eq_caracteristicas" name="i_eq_caracteristicas" class="form-control form-control-sm" autocomplete="off"></textarea>
                  </div>
                </div>-->
              </form>
            </div>
          </div>
        </div>
        <hr>
<br>
<!-- Boton Responsables -->
<div class="row">
  <div class="col-md-2">
    <button type="button" class="btn btn-dark btn-sm form-control" id="b_responsables"><i class="fa fa-users" aria-hidden="true"></i> Responsable</button>
  </div>
  <div class="col-md-2">
    <button type="button" class="btn btn-dark btn-sm form-control" id="b_comodato"><i class="fa fa-users" aria-hidden="true"></i> Comodato</button>
  </div>
</div>
<br>
<!-- Fin acordeones -->
<!-- Tablas -->
<!-- Tabla Historial de Asignaciones - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
<div class="card">
  <h5 class="card-header">Historial de Asignaciones de Responsables ó Comodatos</h5>
  <div class="card-body" style="height:250px; overflow: scroll">
    <table class="tablon">
    
      <div class="row"><!--div_row-->
        <div class="col-md-4">
          <input type="checkbox" id="ch_responsable_mostrar" name="ch_responsable" alt="" value="">Mostrar Todos
        </div>

        <div class="col-auto">Del: </div>
        <div class="input-group col-md-2">
          <input type="text" id="i_fecha_inicio_h" name="i_fecha_inicio_h" class="form-control form-control-sm fecha" readonly autocomplete="off">
          <div class="input-group-btn">
            <button class="btn btn-primary" type="button" style="margin:0px;" disabled="">
              <i class="fa fa-calendar"></i>
            </button>
          </div> 
        </div>
        
        <div class="col-auto">Al: </div>
        <div class="input-group col-md-2">
          <input type="text" id="i_fecha_fin_h" name="i_fecha_fin_h" class="form-control form-control-sm fecha" readonly autocomplete="off">
          <div class="input-group-btn">
            <button class="btn btn-primary" type="button" style="margin:0px;" disabled="">
              <i class="fa fa-calendar"></i>
            </button>
          </div>
        </div>
      </div><!--/div_row-->
  
      <thead>
        <tr>
          <th>
            <select id="s_id_unidades" name="s_id_unidades" class="form-control form-control-sm" autocomplete="off" style="width:100%;" tabindex="-1" aria-hidden="true" disabled>
            </select>
          </th>
          <th></th>
          <th></th>
          <th></th>
          <th><input type="text" id="i_filtro_1" name="i_filtro_1" alt="i_filtro1" alt2="1" alt3="renglon-bitacora" alt4="5" class="form-control filtrar_campos_renglones" placeholder="No. Empleado" style="font-size:14px;" autocomplete="off" disabled></th>
          <th><input type="text" id="i_filtro_2" name="i_filtro_2" alt="i_filtro2" alt2="2" alt3="renglon-bitacora" alt4="5" class="form-control filtrar_campos_renglones" placeholder="No. Cliente" style="font-size:14px;" autocomplete="off" disabled></th>
          <th><input type="text" id="i_filtro_3" name="i_filtro_3" alt="i_filtro3" alt2="3" alt3="renglon-bitacora" alt4="5" class="form-control filtrar_campos_renglones" placeholder="Responsable" style="font-size:14px;" autocomplete="off" disabled></th>
          <th><input type="text" id="i_filtro_4" name="i_filtro_4" alt="i_filtro4" alt2="4" alt3="renglon-bitacora" alt4="5" class="form-control filtrar_campos_renglones" placeholder="No. Serie" style="font-size:14px;" autocomplete="off" disabled></th>
          <th><input type="text" id="i_filtro_5" name="i_filtro_5" alt="i_filtro5" alt2="5" alt3="renglon-bitacora" alt4="5" class="form-control filtrar_campos_renglones" placeholder="No. Economico" style="font-size:14px;" autocomplete="off" disabled></th>
       
          <th></th>
          <th></th>
          <th></th>
        </tr>
        <tr class="renglon">
          <th scope="col">Razón Social</th>
          <th scope="col">Sucursal</th>
          <th scope="col">Área</th>
          <th scope="col">Departamento</th>
          <th scope="col">No. Empleado</th>
          <th scope="col">No. Cliente</th>
          <th scope="col">Responsable</th>
          <th scope="col">(No. Serie)</th>
          <th scope="col">(No. Economico)</th>
          <th scope="col">Descripción Activo</th>
          <th scope="col">Asignación - Fecha Inicio</th>
          <th scope="col">Asignación - Fecha Fin</th>
        </tr>
      </thead>
      <tbody id="t_responsables_activos">

      </tbody>
    </table>
  </div>
</div>
<br><br>
<hr>
<br><br>

<div class="col-md-2">
  <button type="button" class="btn btn-dark btn-sm form-control" id="b_bitacoras"><i class="fa fa-clipboard" aria-hidden="true"></i> Bitacora</button>
</div>
<br>
<!-- Tabla Bitacoras -->
<div class="card">
  <h5 class="card-header">Historial de Bitácora</h5>
  <div class="card-body" style="height:250px; overflow: scroll">
    <table class="tablon">
        
      <div class="row"><!--div_row-->
        <div class="col-md-4">
          <input type="checkbox" id="ch_bitacora_mostrar" name="ch_bitacora_mostrar" alt="" value="">Mostrar Todos
        </div>

        <div class="col-auto">Del: </div>
        <div class="input-group col-md-2">
          <input type="text" id="i_fecha_inicio_b" name="i_fecha_inicio_b" class="form-control form-control-sm fecha" readonly>
          <div class="input-group-btn">
            <button class="btn btn-primary" type="button" style="margin:0px;" disabled="">
              <i class="fa fa-calendar"></i>
            </button>
          </div> 
        </div>
        
        <div class="col-auto">Al: </div>
        <div class="input-group col-md-2">
          <input type="text" id="i_fecha_fin_b" name="i_fecha_fin_b" class="form-control form-control-sm fecha" readonly>
          <div class="input-group-btn">
            <button class="btn btn-primary" type="button" style="margin:0px;" disabled="">
              <i class="fa fa-calendar"></i>
            </button>
          </div>
        </div>
      </div><!--/div_row-->
      <thead>
        <tr>

          <th>
            <input type="text" id="i_bitacora_no_economico" name="i_bitacora_no_economico" class="form-control filtrar_campos_renglones" style="font-size:14px;" placeholder="No. Económico" autocomplete="off" disabled>
          </th>
          <th>
            <select id="s_bitacora_tipo" name="s_bitacora_tipo" class="form-control form-control-sm" disabled>
              <option selected="true" disabled="disabled">Seleccione el Tipo:</option>
              <option value="Informativo">Informativo</option>
              <option value="Mantenimiento">Mantenimiento</option>
              <option value="Siniestro">Siniestro</option>
              <option value="">Todos</option>
            </select>
          </th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th colspan="4"></th>
        </tr>
        <tr class="renglon">
          <th scope="col">No. Económico</th>
          <th scope="col">Tipo</th>
          <th scope="col">Folio Requisición</th>
          <th scope="col">Descripción</th>
          <th scope="col">Fecha</th>
          <th scope="col">Kilometraje</th>
          <th scope="col">Dictamen de Seguro</th>
          <th scope="col">Evidencia</th>
          <th scope="col">Foto 1</th>
          <th scope="col">Foto 2</th>
        </tr>
      </thead>
      <tbody id="t_bitacora_historial">

      </tbody>
    </table>
  </div>
</div>
<!-- Modales - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  - - - - - - - - - - - - - - - --->
<!-- Modal Bitacora -->
<div id="dialog_bitacora" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Bitácora</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Contenido Modal -->
        <form id="forma_bitacora">
          <div class="row">
            <div class="col-md-1">
              <label class="col-form-label requerido">Tipo:</label>
            </div>
            <div class="col-md-3">
              <select id="s_bitacora_tipo_modal" name="s_bitacora_tipo_modal" class="form-control form-control-sm validate[required]" autocomplete="off">
                <option selected="true" disabled="disabled">Seleccione el Tipo:</option>
                <option value="Informativo">Informativo</option>
                <option value="Mantenimiento">Mantenimiento</option>
                <option value="Siniestro">Siniestro</option>
              </select>
            </div>
            <div class="col-md-4">
              <div class="input-group col-sm-12 col-md-12">
                <input type="file" id="i_dictamen" accept="application/pdf" name="i_veh_poliza" class="form-control form-control-sm validate[required]">
              </div>
            </div>
          </div>
          <div class="row" id="div_kilometraje">
            <div class="col-md-auto">
              <label class="col-form-label requerido">Kilometraje:</label>
            </div>
            <div class="col-md-3">
              <input type="text" id="i_kilometraje" name="i_kilometraje" class="form-control form-control-sm validate[required,custom[integer]]" autocomplete="off" />
            </div>
        </div>
          <div class="row">
            <div class="col-md-2">
              <label class="col-form-label requerido">Descripción:</label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-10">
              <textarea type="text" id="i_bitacora_descripcion" name="i_bitacora_descripcion" class="form-control form-control-sm validate[required]" autocomplete="off"></textarea>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label class="col-form-label">Evidencia:</label>
              <input type="file" id="i_evidencia_bitacora" accept="application/pdf" name="i_evidencia_bitacora" class="form-control form-control-sm">
            </div>
            <div class="col-md-4">
              <label class="col-form-label">Foto 1:</label>
              <input type="file" id="i_foto_1_bitacora" accept="image/*" name="i_foto_1_bitacora" class="form-control form-control-sm">
            </div>
            <div class="col-md-4">
              <label class="col-form-label">Foto 2:</label>
              <input type="file" id="i_foto_2_bitacora" accept="image/*" name="i_foto_2_bitacora" class="form-control form-control-sm">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="b_bitacora_guardar"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal Responsable -->
<div id="dialog_responsable" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Responsable</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Contenido Modal -->
        <form id="forma_responsable" name="forma_responsable" action="" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-5">
                  <label for="s_responsable_unidades" class="col-form-label requerido">Unidad Negocio:</label>
                </div>
                <div class="col-md-7">
                  <select id="s_responsable_unidades" name="s_responsable_unidades" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;" tabindex="-1" aria-hidden="true"></select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5">
                  <label for="s_responsable_sucursales" class="col-form-label requerido">Sucursal:</label>
                </div>
                <div class="col-md-7">
                  <select id="s_responsable_sucursales" name="s_responsable_sucursales" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;" tabindex="-1" aria-hidden="true"></select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5">
                  <label class="col-form-label requerido">Área:</label>
                </div>
                <div class="col-md-7">
                  <select id="s_responsable_area" name="s_responsable_area" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;" tabindex="-1" aria-hidden="true"></select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5">
                  <label class="col-form-label requerido">Departamento:</label>
                </div>
                <div class="col-md-7">
                  <select id="s_responsable_dpto" name="s_responsable_dpto" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;" tabindex="-1" aria-hidden="true"></select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5 div_cuip" style="display:none;">
                  <label class="col-form-label requerido" id="lbl_cuip">CUIP:</label>
                </div>
                <div class="col-md-7 div_cuip" style="display:none;">
                  <input id="i_cuip" name="i_cuip" type="text" class="form-control validate[required]" autocomplete="off"/>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-12 div_cuip" style="display:none;">
                  <input type="checkbox" id="ch_responsable_externo" name="ch_responsable_externo" value=""> Responsable Externo 
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <label  class="col-form-label requerido">Responsable:</label>
                </div>
                <div class="col-md-8">
                  <div class="input-group col-md-13">
                      <input type="text" id="i_empleado" name="i_empleado" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                      <div class="input-group-btn" id="div_boton_busca_resp">
                          <button class="btn btn-primary" type="button" id="b_buscar_empleados" style="margin:0px;">
                              <i class="fa fa-search" aria-hidden="true"></i>
                          </button>
                      </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <label for="i_no_licencia" class="col-form-label l_datos_o requerido">No. Licencia:</label>
                </div>
                <div class="col-md-7">
                  <input type="text" id="i_no_licencia" name="i_no_licencia" class="form-control form-control-sm i_datos_o validate[required]" autocomplete="off">
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <label for="i_vigencia_licencia" class="col-form-label  l_datos_o requerido">Vigencia Lice:</label>
                </div>
                <div class="col-md-5">
                  <div class="input-group col-md-13">
                    <input type="text" id="i_vigencia_licencia" name="i_vigencia_licencia" class="form-control form-control-sm fecha i_datos_o validate[required]">
                    <div class="input-group-btn">
                      <button class="btn btn-primary" type="button" style="margin:0px;" disabled>
                        <i class="fa fa-calendar"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <label id="i_licencia_label" class="col-form-label l_datos_o requerido">Licencia PDF:</label>
                </div>
                <div class="col-md-8">
                  <div class="input-group col-sm-13 col-md-13">
                    <input type="file" id="i_licencia" accept="application/pdf" name="i_licencia" class="form-control form-control-sm i_datos_o validate[required]">
                    <div class="input-group-btn">
                      <button class="btn btn-primary" type="button" id="preview_licencia" style="margin:0px;">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" id="b_responsable_devolver"><i class="fa fa-refresh" aria-hidden="true"></i> Devolver</button>
          <button type="button" class="btn btn-dark" id="b_imprimir_salida"><i class="fa fa-print" aria-hidden="true"></i> Imprimir </button>
          <button type="button" class="btn btn-dark" id="b_responsable_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
        </div>
    </div>
  </div>
</div>

<!-- Modal Comodato -->
<div id="dialog_comodato" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Comodato</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Contenido Modal -->
        <form id="forma_responsable">
          <div class="row">
            <div class="col-md-3">
              <label for="s_responsable_unidades_c" class="col-form-label requerido">Unidad Negocio:</label>
            </div>
            <div class="col-md-3">
              <select id="s_responsable_unidades_c" name="s_responsable_unidades_c" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;" tabindex="-1" aria-hidden="true"></select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
              <label for="s_responsable_sucursales_c" class="col-form-label requerido">Sucursal:</label>
            </div>
            <div class="col-md-4">
              <select id="s_responsable_sucursales_c" name="s_responsable_sucursales_c" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;" tabindex="-1" aria-hidden="true"></select>
            </div>
          </div>
          <div class="row">
          <div class="col-md-2">
              <label  class="col-form-label requerido">Cliente:</label>
            </div>
            <div class="col-md-6">
              <div class="input-group col-md-13">
                  <input type="text" id="i_cliente_c" name="i_cliente_c" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                  <div class="input-group-btn">
                      <button class="btn btn-primary" type="button" id="b_buscar_clientes" style="margin:0px;">
                          <i class="fa fa-search" aria-hidden="true"></i>
                      </button>
                  </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
              <label class="col-form-label requerido">Área:</label>
            </div>
            <div class="col-md-4">
              <select id="s_responsable_area_c" name="s_responsable_area_c" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;" tabindex="-1" aria-hidden="true"></select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
              <label class="col-form-label requerido">Departamento:</label>
            </div>
            <div class="col-md-4">
              <select id="s_responsable_dpto_c" name="s_responsable_dpto_c" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;" tabindex="-1" aria-hidden="true"></select>
            </div>
            
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" id="b_responsable_devolver_comodato"><i class="fa fa-refresh" aria-hidden="true"></i> Devolver</button>
          <button type="button" class="btn btn-dark" id="b_imprimir_salida_comodato"><i class="fa fa-print" aria-hidden="true"></i> Imprimir </button>
          <button type="button" class="btn btn-dark" id="b_comodato_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>




<!-- Modal Agregar Vehiculo Tipo -->
<div id="dialog_veh_tipo" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar Tipo - Vehículo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Contenido Modal -->
        <form id="forma_vehiculo_tipo">
          <div class="row">
            <div class="col-md-1">
              <label class="col-form-label requerido">Tipo:</label>
            </div>
            <div class="col-md-3">
              <input type="text" id="i_add_veh_tipo" name="i_add_veh_tipo" class="form-control form-control-sm validate[required]" autocomplete="off">
            </div>
            <div class="col-md-3">
              <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar_veh_tipo"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
              <label class="col-form-label">Existentes:</label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8" style="height:220px; overflow: scroll">
              <table class="tablon">
                <thead>
                  <tr class="renglon">
                    <th scope="col">Tipo</th>
                  </tr>
                </thead>
                <tbody id="t_veh_tipo">

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

<!-- Modal Agregar Vehiculo Marca -->
<div id="dialog_veh_marca" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar Marca - Vehículo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Contenido Modal -->
        <form id="forma_vehiculo_marca">
          <div class="row">
            <div class="col-md-1">
              <label class="col-form-label requerido">Marca:</label>
            </div>
            <div class="col-md-3">
              <input type="text" id="i_add_veh_marca" name="i_add_veh_marca" class="form-control form-control-sm validate[required]" autocomplete="off">
            </div>
            <div class="col-md-3">
              <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar_veh_marca"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
              <label class="col-form-label">Existentes:</label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8" style="height:220px; overflow: scroll">
              <table class="tablon">
                <thead>
                  <tr class="renglon">
                    <th scope="col">Marca</th>
                  </tr>
                </thead>
                <tbody id="t_veh_marca">

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

<!-- Modal Agregar Celular Marca -->
<div id="dialog_cel_marca" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar Marca - Celular</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Contenido Modal -->
        <form id="forma_celular_marca">
          <div class="row">
            <div class="col-md-1">
              <label class="col-form-label requerido">Marca:</label>
            </div>
            <div class="col-md-3">
              <input type="text" id="i_add_cel_marca" name="i_add_cel_marca" class="form-control form-control-sm validate[required]" autocomplete="off">
            </div>
            <div class="col-md-3">
              <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar_cel_marca"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
              <label class="col-form-label">Existentes:</label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8" style="height:220px; overflow: scroll">
              <table class="tablon">
                <thead>
                  <tr class="renglon">
                    <th scope="col">Marca</th>
                  </tr>
                </thead>
                <tbody id="t_cel_marca">

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

<!-- Modal Agregar Celular Compañia -->
<div id="dialog_cel_compania" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar Compañía - Celular</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Contenido Modal -->
        <form id="forma_celular_compania">
          <div class="row">
            <div class="col-md-2">
              <label class="col-form-label requerido">Compañía:</label>
            </div>
            <div class="col-md-3">
              <input type="text" id="i_add_cel_compania" name="i_add_cel_compania" class="form-control form-control-sm validate[required]" autocomplete="off">
            </div>
            <div class="col-md-3">
              <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar_cel_compania"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
              <label class="col-form-label">Existentes:</label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8" style="height:220px; overflow: scroll">
              <table class="tablon">
                <thead>
                  <tr class="renglon">
                    <th scope="col">Compañía</th>
                  </tr>
                </thead>
                <tbody id="t_cel_compania">

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

<!-- Modal Agregar Equipo de Computo Tipo -->
<div id="dialog_eq_tipo" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar Tipo - Equipo de Computo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Contenido Modal -->
        <form id="forma_eq_tipo">
          <div class="row">
            <div class="col-md-1">
              <label class="col-form-label requerido">Tipo:</label>
            </div>
            <div class="col-md-3">
              <input type="text" id="i_add_eq_tipo" name="i_add_eq_tipo" class="form-control form-control-sm validate[required]" autocomplete="off">
            </div>
            <div class="col-md-3">
              <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar_eq_tipo"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
              <label class="col-form-label">Existentes:</label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8" style="height:220px; overflow: scroll">
              <table class="tablon">
                <thead>
                  <tr class="renglon">
                    <th scope="col">Tipo</th>
                  </tr>
                </thead>
                <tbody id="t_eq_tipo">

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

<!-- Modal Agregar Celular Compañia -->
<div id="dialog_eq_marca" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar Marca - Equipo de Computo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Contenido Modal -->
        <form id="forma_eq_marca">
          <div class="row">
            <div class="col-md-1">
              <label class="col-form-label requerido">Marca:</label>
            </div>
            <div class="col-md-3">
              <input type="text" id="i_add_eq_marca" name="i_add_eq_marca" class="form-control form-control-sm validate[required]" autocomplete="off">
            </div>
            <div class="col-md-3">
              <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar_eq_marca"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
              <label class="col-form-label">Existentes:</label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8" style="height:220px; overflow: scroll">
              <table class="tablon">
                <thead>
                  <tr class="renglon">
                    <th scope="col">Marca</th>
                  </tr>
                </thead>
                <tbody id="t_eq_marca">

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

<!-- Modal Agregar Marca Armas -->
<div id="dialog_armas_marca" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar Marca - Armas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Contenido Modal -->
        <form id="forma_armas_marca">
          <div class="row">
            <div class="col-md-1">
              <label class="col-form-label requerido">Marca:</label>
            </div>
            <div class="col-md-3">
              <input type="text" id="i_add_armas_marca" name="i_add_armas_marca" class="form-control form-control-sm validate[required]" autocomplete="off">
            </div>
            <div class="col-md-3">
              <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar_armas_marca"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
              <label class="col-form-label">Existentes:</label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8" style="height:220px; overflow: scroll">
              <table class="tablon">
                <thead>
                  <tr class="renglon">
                    <th scope="col">Marca</th>
                  </tr>
                </thead>
                <tbody id="t_armas_marca">

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

<!-- Modal Agregar Clase Armas -->
<div id="dialog_armas_clase" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar Clase - Armas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Contenido Modal -->
        <form id="forma_armas_clase">
          <div class="row">
            <div class="col-md-1">
              <label class="col-form-label requerido">Clase:</label>
            </div>
            <div class="col-md-3">
              <input type="text" id="i_add_armas_clase" name="i_add_armas_clase" class="form-control form-control-sm validate[required]" autocomplete="off">
            </div>
            <div class="col-md-3">
              <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar_armas_clase"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
              <label class="col-form-label">Existentes:</label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8" style="height:220px; overflow: scroll">
              <table class="tablon">
                <thead>
                  <tr class="renglon">
                    <th scope="col">Clase</th>
                  </tr>
                </thead>
                <tbody id="t_armas_clase">

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
              <div class="col-md-1">Económico: </div>
              <div class="col-md-2">
                <input type="text" id="i_buscar_no_economico" name="i_buscar_no_economico" class="form-control form-control-sm" placeholder="No Económico" autocomplete="off">
            </div>
            <div class="col-md-1">Serie: </div>
            <div class="col-md-2">
              <input type="text" id="i_buscar_no_serie" name="i_buscar_no_serie" class="form-control form-control-sm" placeholder="No Serie" autocomplete="off">
            </div>

            <div class="col-auto">Del: </div>
            <div class="col-md-2">
              <div class="input-group col-md-13">
                <input type="text" id="i_fecha_buscar_activo" name="i_fecha_buscar_activo" class="form-control form-control-sm fecha">
                <div class="input-group-btn">
                  <button class="btn btn-primary" type="button" style="margin:0px;" disabled="">
                    <i class="fa fa-calendar"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="col-auto">Al: </div>
            <div class="col-md-2">
              <div class="input-group col-md-13">
                <input type="text" id="i_fecha_buscar_activo_fin" name="i_fecha_buscar_activo_fin" class="form-control form-control-sm fecha">
                <div class="input-group-btn">
                  <button class="btn btn-primary" type="button" style="margin:0px;" disabled="">
                    <i class="fa fa-calendar"></i>
                  </button>
                </div>
              </div>
            </div>

          </div>
          <br>
          <div class="row">
            <div class="col-md-1">
              <label for="s_buscar_propietario" class="col-form-label"> Propietario:</label>
            </div>
            <div class="col-md-5">
              <select id="s_buscar_propietario" name="s_buscar_propietario" class="form-control form-control-sm">
              </select>
            </div>
            <div class="col-auto">
              <label for="s_buscar_tipo" class="col-form-label"> Tipo:</label>
            </div>
            <div class="col-md-3">
              <select id="s_buscar_tipo" name="s_buscar_tipo" class="form-control form-control-sm">
                <option selected="true" disabled="disabled">Seleccione el Tipo:</option>
                <option value="1" class="options_global" style="display:none;">Vehículo</option>
                <option value="2" class="options_global" style="display:none;">Celular</option>
                <option value="3" class="options_global" style="display:none;">Equipo de Computo</option>
                <option value="4" class="options_global" style="display:none;">Otro</option>
                <option value="5"  id="option_armas" style="display:none;">Armas</option>
                <option value="">Todos</option>
              </select>
            </div>
            <div class="col-md-2">
              <input type="text" id="i_filtro_busqueda" name="i_filtro_busqueda" class="form-control form-control-sm filtrar_renglones" alt="activo_renglon" placeholder="Filtrar" autocomplete="off">
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
                    <th scope="col">No. Económico</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Fecha Adquisicion</th>
                    <th scope="col">Valor Adquisicion</th>
                    <th scope="col">Propietario</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Estatus</th>
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
<!-- Modal Empleados -->
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


<!-- Fin Modales -->

</div> <!--div_contenedor-->
</div>
</div> <!--div_principal-->
</body>
<div id="fondo_cargando"></div>
<div id="dialog_relacion_facturas" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Relación de Facturas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Folios Recepción (Activos Fijos) -->
<div id="dialog_recepcion" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda Folio Recepción</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="row">
                    
                    <div class="col-sm-5 col-md-5">
                      <input type="text" name="i_filtro_recepcion" id="i_filtro_recepcion" alt="renglon_recepcion" class="filtrar_renglones form-control" placeholder="Filtrar" autocomplete="off"></div>
                </div>
                <br>
                <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-sm-12 col-md-12" style="height:480px; overflow: scroll">
                        <table class="tablon"  id="t_recepcion">
                        <thead>
                            <tr class="renglon">
                                <th scope="col">Sucursal</th>
                                <th scope="col">Folio <br> Recepción</th>
                                <th scope="col">Partida</th>
                                <th scope="col">Catálogo</th>
                                <th scope="col">Familia</th>
                                <th scope="col">Linea</th>
                                <th scope="col">Concepto</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col"></th>
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
            <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal" id="b_guardar_folio_recepcion">Guardar</button>
        </div>
        </div>
    </div>
</div>

<!-- Modal Razones Sociales (Activos Fijos) -->
<div id="dialog_razones_sociales" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda Razones Sociales</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_razon_social" id="i_filtro_razon_social" alt="renglon_razones_sociales" class="filtrar_renglones form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off"></div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_razones_sociales">
                        <thead>
                            <tr class="renglon">
                                <th scope="col">Nombre Corto</th>
                                <th scope="col">Razon Social</th>
                                <th scope="col">RFC</th>
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
<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
$('#b_responsables').prop('disabled',true);
$('#b_comodato').prop('disabled',true);
// Revision formulario Datos Generales
$('#link_generales').mouseleave(function(){
  var noSerie = $('#i_no_serie').val();
  var descripcion = $('#i_descripcion').val();
  var fechaAdq = $('#i_fecha_adq').val();
  var valAdq = quitaComa($('#i_val_adq').val());
  var propietario = $('#s_propietario').val();
  var fechaFinCredito = $('#i_fecha_fin_credito').val();
  arreglo=[noSerie, descripcion, fechaAdq, valAdq, propietario, fechaFinCredito];
  x=true;
  for (var i = 0; i < arreglo.length; i++) {
    if (arreglo[i]=="null" || arreglo[i]=="") {
      x=false;
      $('#flotante').hide()
    }
  }
  if (x==true) {
    // habilitar boton guardar y check de datos obligatorios
    // asdfghj
    $('#flotante').show()
  }

});


// Radio Butons - Contado Credito o Arrendamiento
// activar o desactivar el required de Fin de Credito o Arrendamiento segun el Radio seleccionado
$('#r_contado').click(function(){
  $('#i_amortizacion').prop('disabled',true);
  $('#i_amortizacion').val('');
  $('#i_anticipo').prop('disabled',true);
  $('#i_anticipo').val('');
  $('#i_mensualidades').prop('disabled',true);
  $('#i_mensualidades').val('');
  $('#i_fecha_fin_credito').prop('disabled',true);
  $('#i_fecha_fin_credito').val('');
  $('#l_fecha_fin_credito').removeClass('requerido');
  $('#i_fecha_fin_credito').removeClass('validate[required]');
});
$('#r_credito').click(function(){
  $('#i_amortizacion').prop('disabled',false);
  $('#i_anticipo').prop('disabled',false);
  $('#i_mensualidades').prop('disabled',false);
  $('#i_fecha_fin_credito').prop('disabled',false);
  $('#l_fecha_fin_credito').addClass(' requerido');
  $('#i_fecha_fin_credito').addClass(' validate[required]');
});
$('#r_arrendamiento').click(function(){
  $('#i_amortizacion').prop('disabled',false);
  $('#i_anticipo').prop('disabled',false);
  $('#i_mensualidades').prop('disabled',false);
  $('#i_fecha_fin_credito').prop('disabled',false);
  $('#l_fecha_fin_credito').addClass(' requerido');
  $('#i_fecha_fin_credito').addClass(' validate[required]');
});

function radiosRequired(){
  radio = $('input[name="r_compra"]:checked').val();
  if (radio == 1) {
    $('#l_fecha_fin_credito').removeClass('requerido');
    $('#i_fecha_fin_credito').removeClass('validate[required]');
  }
  else if (radio == 2) {
    $('#l_fecha_fin_credito').addClass(' requerido');
    $('#i_fecha_fin_credito').addClass(' validate[required]');
  }
  else if (radio == 3) {
    $('#l_fecha_fin_credito').addClass(' requerido');
    $('#i_fecha_fin_credito').addClass(' validate[required]');
  }
  else if (radio == 5) {
    $('#l_fecha_fin_credito').addClass(' requerido');
    $('#i_fecha_fin_credito').addClass(' validate[required]');
  }
}
// Funciones de los radio butons ----------------------------------------------------------------------------------------------
// Ocultamiento de los Acordeones al seleccionar el tipo en Datos Generales
$(document).ready(function(){
  $( "#i_dictamen" ).hide();
  $( "#heading_vehiculo" ).hide();
  $( "#heading_celular" ).hide();
  $( "#heading_computo" ).hide();
  $('#heading_armas').hide();
  $('#l_fecha_fin_credito').removeClass('requerido');
  $('#i_fecha_fin_credito').removeClass('validate[required]');
  $('#i_amortizacion').prop('disabled',true);
  $('#i_anticipo').prop('disabled',true);
  $('#i_mensualidades').prop('disabled',true);
  $('#i_fecha_fin_credito').prop('disabled',true);
  //-->NJES Feb/10/2020 se comenta porque ya no existe el elemento en html
  //muestraSucursalesPermiso('s_filtro_sucursal',idUnidadActual,modulo,idUsuario);
  // return selectResponsables('');
});
// Al dar check en otro se ocultan todos los acordeones de tipo - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
$('#r_otro').click(function(){
  $( "#heading_vehiculo" ).hide();
  $( "#collapse_vehiculo" ).hide();
  $( "#heading_celular" ).hide();
  $( "#collapse_celular" ).hide();
  $( "#heading_computo" ).hide();
  $( "#collapse_computo" ).hide();
  $('#collapse_armas').hide();
  $('#heading_armas').hide();
});
//  Al dar check en vehiculo solo se muestra este acordeon y se limpian las entradas - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
$('#r_vehiculo').click(function(){
  // acordeones
  $( "#heading_vehiculo" ).show();
  $("#collapse_vehiculo").css("display", "");
  $( "#heading_celular" ).hide();
  $( "#collapse_celular" ).hide();
  $( "#heading_computo" ).hide();
  $( "#collapse_computo" ).hide();
  $('#collapse_armas').hide();
  $('#heading_armas').hide();
  // entradas
  $("#collapse_vehiculo").addClass("show");
  $("#collapse_celular").removeClass("show");
  $("#collapse_computo").removeClass("show");
  $('#collapse_armas').removeClass("show");
  document.getElementById('s_veh_tipo').selectedIndex = 0;
  $('#i_veh_poliza').val('');
  document.getElementById('s_veh_marca').selectedIndex = 0;
  $('#i_veh_vigencia').val('');
  $('#i_veh_color').val('');
  $('#i_veh_circulacion').val('');
  $('#i_veh_modelo').val('');
  $('#i_veh_vigencia_circulacion').val('');
  $('#i_veh_placas').val('');
  $('#i_veh_anio').val('');
  $('#i_imei_gps').val('');
  $('#i_veh_responsiva_firmada').val('');
});
// Al dar check en celular solo se muestra este acordeon y se limpian sus entradas - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
$('#r_celular').click(function(){
  // acordeones
  $( "#heading_vehiculo" ).hide();
  $( "#collapse_vehiculo" ).hide();
  $( "#heading_celular" ).show();
  $("#collapse_celular").css("display", "");
  $( "#heading_computo" ).hide();
  $( "#collapse_computo" ).hide();
  $('#collapse_armas').hide();
  $('#heading_armas').hide();
  // entradas
  $("#collapse_celular").addClass("show");
  $("#collapse_computo").removeClass("show");
  $("#collapse_vehiculo").removeClass("show");
  $('#collapse_armas').removeClass("show");
  document.getElementById('s_cel_marca').selectedIndex = 0;
  document.getElementById('s_cel_compania').selectedIndex = 0;
  $('#i_cel_modelo').val('');
  $('#i_cel_paquete').val('');
  $('#i_cel_imei').val('');
  $('#i_cel_contrato').val('');
  $('#i_cel_numero').val('');
  $('#i_cel_vigencia_contrato').val('');
  $('#i_cel_responsiva_firmada').val('');
});
// Al dar check en eq. computo solo se muestra este acordeon y se limpian sus entradas - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
$('#r_eq_computo').click(function(){
  // acordeones
  $( "#heading_vehiculo" ).hide();
  $( "#collapse_vehiculo" ).hide();
  $( "#heading_celular" ).hide();
  $( "#collapse_celular" ).hide();
  $('#collapse_armas').hide();
  $('#heading_armas').hide();
  $( "#heading_computo" ).show();
  // entradas
  $("#collapse_computo").css("display", "");
  $("#collapse_computo").addClass("show");
  $("#collapse_celular").removeClass("show");
  $("#collapse_vehiculo").removeClass("show");
  document.getElementById('s_eq_marca').selectedIndex = 0;
  $('#i_eq_modelo').val('');
  $('#i_cargador').val('');
  $('#i_eq_responsiva_firmada').val('');
  document.getElementById('s_eq_tipo').selectedIndex = 0;
  $('#i_eq_caracteristicas').val('');
});
//-->NJES April/29/2020 se agrega opcion armas
$('#r_armas').click(function(){
  // acordeones
  $( "#heading_vehiculo" ).hide();
  $( "#collapse_vehiculo" ).hide();
  $( "#heading_celular" ).hide();
  $( "#collapse_celular" ).hide();
  $( "#heading_computo" ).hide();
  $( "#collapse_computo" ).hide();
  $('#collapse_armas').hide();
  $('#heading_armas').show();

  // entradas
  $("#collapse_armas").css("display", "");
  $("#collapse_armas").addClass("show");
  $("#collapse_celular").removeClass("show");
  $("#collapse_vehiculo").removeClass("show");
  $('#collapse_computo').removeClass("show");
  document.getElementById('s_armas_marca').selectedIndex = 0;
  document.getElementById('s_armas_clase').selectedIndex = 0;
  $('#i_armas_modelo').val('');
  $('#i_armas_calibre').val('');
  $('#i_armas_matricula').val('');
  $('#i_armas_fecha_ingreso').val('');
  $('#i_armas_fecha_baja').val('');
  $('#i_armas_responsiva_firmada').val('');
});
// Termina ------------------------------------------------------------------------------------------------------------

// Mostrar Modal con boton ----------------------------------------------------------------------------------------------
$('#b_bitacoras').click(function(){
  $("#i_bitacora_descripcion").val('');
  $("#i_dictamen").val('');
  $("#i_kilometraje").val('');
  $("#div_kilometraje").hide();
  document.getElementById('s_bitacora_tipo_modal').selectedIndex = 0;
  $("#dialog_bitacora").modal('show');
});

// MOdal Responsable -----------------------------------------------------------------------
$('#b_responsables').click(function(){
  
  $("#dialog_responsable").modal('show');
  
  limpiarResponsable($('#b_guardar_activo').attr('alt'),'R');

});

$(document).on('change','#s_responsable_unidades',function(){
  muestraSucursalesPermiso('s_responsable_sucursales',$('#s_responsable_unidades').val(),modulo,idUsuario);
});

$(document).on('change','#s_responsable_sucursales',function(){
  muestraDepartamentoArea('s_responsable_dpto',$('#s_responsable_sucursales').val(),$('#s_responsable_area').val());
});

$(document).on('change','#s_responsable_area',function(){
  muestraDepartamentoArea('s_responsable_dpto',$('#s_responsable_sucursales').val(),$('#s_responsable_area').val());
});

function limpiarResponsable(idActivo,tipoR){

  if(tipoR=='R'){
    muestraSelectUnidades(matriz,'s_responsable_unidades',idUnidadActual);
    muestraSucursalesPermiso('s_responsable_sucursales',idUnidadActual,modulo,idUsuario);
    muestraAreasAcceso('s_responsable_area');
    muestraDepartamentoArea('s_responsable_dpto', actual.id_sucursal, actual.id_area);
    $('#s_responsable_unidades').prop('disabled',false);
    $('#s_responsable_sucursales').prop('disabled',false);
    $('#s_responsable_area').prop('disabled',false);
    $('#s_responsable_dpto').prop('disabled',false);
  }else{

    muestraSelectUnidades(matriz,'s_responsable_unidades_c',idUnidadActual);
    muestraSucursalesPermiso('s_responsable_sucursales_c',idUnidadActual,modulo,idUsuario);
    muestraAreasAcceso('s_responsable_area_c');
    muestraDepartamentoArea('s_responsable_dpto_c', actual.id_sucursal, actual.id_area);
    $('#s_responsable_unidades_c').prop('disabled',false);
    $('#s_responsable_sucursales_c').prop('disabled',false);
    $('#s_responsable_area_c').prop('disabled',false);
    $('#s_responsable_dpto_c').prop('disabled',false);
  }

  $(document).find('.l_datos_o').removeClass('requerido');
  $(document).find('.i_datos_o').removeClass('validate[required]');
  //--- si es responsable de un vehiculo los datos de licencia y vigencia deben ser obligatorios
  if($('input:radio[name=r_tipo]:checked').val()==1){
    $(document).find('.l_datos_o').addClass('requerido');
    $(document).find('.i_datos_o').addClass('validate[required]');
  }
  
  $('#i_licencia').val('').prop('disabled',false);

  $("#i_cliente_c").attr("alt",0);
  $("#i_cliente_c").val("").prop('disabled',false);

  $("#i_empleado").attr("alt",0);
  $("#i_empleado").val("").prop('disabled',false);
  $("#i_no_licencia").val("").prop('disabled',false);
  $("#i_vigencia_licencia").val("").prop('disabled',false);

  $('#i_cuip').val('').prop('disabled',false);
  $('#ch_responsable_externo').prop({'checked':false,'disabled':false});
  $('#div_boton_busca_resp').css('display','block');
  $('#b_buscar_empleados').prop('disabled',false);

  if(tipoR=='R'){

    $('#b_responsable_guardar').prop('disabled',false);
    $('#b_responsable_devolver').prop('disabled',true);
    $('#b_imprimir_salida').hide();

  }else if(tipoR=='C'){

    $('#b_comodato_guardar').prop('disabled',false);
    $('#b_responsable_devolver_comodato').prop('disabled',true);
    $('#b_imprimir_salida_comodato').hide();

  }else{

    $('#b_responsable_guardar').prop('disabled',false);
    $('#b_responsable_devolver').prop('disabled',true);
    $('#b_comodato_guardar').prop('disabled',false);
    $('#b_responsable_devolver_comodato').prop('disabled',true);
    $('#b_imprimir_salida_comodato').hide();
    $('#b_imprimir_salida').hide();

  }
 
  
 

  $('#b_imprimir_salida').hide();

  if(idActivo>0){
    if(tipoR=='R'){
      buscaResponsableActual(idActivo);
    }else{
      buscaResponsableActualC(idActivo);
    }
    
  }
}

$(document).on('click','#b_responsable_devolver',function(){
   var idActivoR=$(this).attr('alt');
   var idActivo = $('#b_guardar_activo').attr('alt');
   $.ajax({
    type: 'POST',
    url: 'php/activos_devolver_selected_responsable.php',
    dataType:"json",
    data:{
      'idResponsable':idActivoR,
      'idActivo':idActivo
    },
    success: function(data){
  
      if( data == 1 ){

        limpiarResponsable(0,'R');
        imprimirDevolucion('R');
        mandarMensaje('La devolución se realizó correctamente');
        $('#ch_inactivo').prop('disabled',false);
        return guardarLicenciaPDF();
        
      }else{
        mandarMensaje('Ocurrio un error al devolver');
      }
    },
    error: function (data) {
      console.log('php/activos_devolver_selected_responsable.php-->'+JSON.stringify(data));
      mandarMensaje('* Ocurrio un error al devolver ');
    }
    });
});

$(document).on('click','#b_responsable_devolver_comodato',function(){
   var idActivoR=$(this).attr('alt');
   $.ajax({
    type: 'POST',
    url: 'php/activos_devolver_selected_responsable.php',
    dataType:"json",
    data:{'idResponsable':idActivoR},
    success: function(data){
    
      if( data == 1 ){

        limpiarResponsable(0,'C');
        imprimirDevolucion('C');
        mandarMensaje('La devolución se realizó correctamente');
        $('#ch_inactivo').prop('disabled',false);
        
      }else{
        mandarMensaje('Ocurrio un error al devolver');
      }
    },
    error: function (data) {
      console.log('php/activos_devolver_selected_responsable.php-->'+JSON.stringify(data));
      mandarMensaje('* Ocurrio un error al devolver ');
    }
    });
});


// MOdal Responsable -----------------------------------------------------------------------
$('#b_comodato').click(function(){
  
  $("#dialog_comodato").modal('show');
  
  limpiarResponsable($('#b_guardar_activo').attr('alt'),'C');
  $('#b_buscar_clientes').prop('disabled',true);
});

$(document).on('change','#s_responsable_unidades_c',function(){
  muestraSucursalesPermiso('s_responsable_sucursales_c',$('#s_responsable_unidades_c').val(),modulo,idUsuario);
  $('#i_cliente_c').val('');
  $('#b_buscar_clientes').prop('disabled',true);
});

$(document).on('change','#s_responsable_sucursales_c',function()
{

  muestraDepartamentoArea('s_responsable_dpto_c',$('#s_responsable_sucursales_c').val(),$('#s_responsable_area_c').val());
  $('#b_buscar_clientes').prop('disabled',false);

});

$(document).on('change','#s_responsable_dpto',function()
{

  var idD = $("#s_responsable_dpto").val();
  if(idD == 3489)
  {
    $('#i_cuip').removeClass('validate[required]');
    $('#lbl_cuip').removeClass('requerido'); 
  }
  else
  {
    $('#i_cuip').removeClass('validate[required]').addClass('validate[required]');
    $('#lbl_cuip').removeClass('requerido').addClass('requerido');
  }

});

$(document).on('change','#s_responsable_area_c',function()
{

  muestraDepartamentoArea('s_responsable_dpto_c',$('#s_responsable_sucursales_c').val(),$('#s_responsable_area_c').val());

});


function buscaResponsableActual(idActivo){
  $.ajax({
    type: 'POST',
    url: 'php/activos_buscar_selected_responsable.php',
    dataType:"json",
    data:{'idActivo':idActivo},
    success: function(data){
      
      if(parseInt(data.length) > 0 )
      {
        

        //console.log(idActivo+' '+JSON.stringify(data));

        for (var i = 0; i < data.length; i++)
        {
          var actual=data[i];
          //**----INFORMACION DE RESPONSABLE-------------------- */
          
          if(actual.id_unidad_negocio != 0){
              $('#s_responsable_unidades').val(actual.id_unidad_negocio).prop('disabled',true);
              $('#s_responsable_unidades').select2({
                placeholder: $(this).data('elemento'),
                templateResult: setCurrency,
                templateSelection: setCurrency
              });
            
              $('.img-flag').css({'width':'50px','height':'20px'}); //Cambia el tamaño de la imagen que se mostrara en el selectB

          }
          

          if(actual.id_sucursal != 0){
              $('#s_responsable_sucursales').val(actual.id_sucursal).prop('disabled',true);
              $('#s_responsable_sucursales').select2({placeholder: $(this).data('elemento')});
          }

          if(actual.id_area != 0){
              $('#s_responsable_area').val(actual.id_area).prop('disabled',true);
              $('#s_responsable_area').select2({placeholder: $(this).data('elemento')});
          }
          

          // verificando
          muestraDepartamentoArea('s_responsable_dpto', actual.id_sucursal, actual.id_area);
          if(actual.id_departamento != 0){
              $('#s_responsable_dpto').val(actual.id_departamento).prop('disabled',true);
              $('#s_responsable_dpto').select2({placeholder: $(this).data('elemento')});
          }

          $("#i_no_licencia").val(actual.no_licencia).prop('disabled',true);
          $("#i_vigencia_licencia").val(actual.vigencia_licencia).prop('disabled',true);
          $('#i_licencia').prop('disabled',true);

          $('#i_cuip').val(actual.cuip).prop('disabled',true);
          if(actual.responsable_externo == '')
          {
            $('#ch_responsable_externo').prop({'disabled':true,'checked':false});
            $('#div_boton_busca_resp').css('display','block');

            $("#i_empleado").attr('alt',actual.id_trabajador).prop('disabled',true);
            $("#i_empleado").val(actual.empleado).prop('disabled',true);
          }else{
            $('#ch_responsable_externo').prop({'disabled':true,'checked':true});
            $('#div_boton_busca_resp').css('display','none');

            $("#i_empleado").attr('alt',actual.id_trabajador).prop('disabled',true);
            $("#i_empleado").val(actual.responsable_externo).prop('disabled',true);
          }

          $('#b_buscar_empleados').prop('disabled',true);

          $('#b_responsable_devolver').attr('alt',actual.id_activo_responsable).prop('disabled',false);
          $('#b_responsable_guardar').prop('disabled',true).attr('alt',idActivo);
          $('#b_imprimir_salida').show();
        
        }
      }else{
        limpiarResponsable(0,'R');
      }
    },
    error: function (data) {
      mandarMensaje(' Error 500 BUSCAR ACTIVO REPONSABLE');
    }
    });
}

function buscaResponsableActualC(idActivo){
  $.ajax({
    type: 'POST',
    url: 'php/activos_buscar_selected_responsable.php',
    dataType:"json",
    data:{'idActivo':idActivo},
    success: function(data){
      
      if(parseInt(data.length) > 0 ){
        
        for (var i = 0; i < data.length; i++) {
          actual=data[i];
          //**----INFORMACION DE RESPONSABLE-------------------- */
          
          if(actual.id_unidad_negocio != 0){
              $('#s_responsable_unidades_c').val(actual.id_unidad_negocio).prop('disabled',true);
              $('#s_responsable_unidades_c').select2({
                placeholder: $(this).data('elemento'),
                templateResult: setCurrency,
                templateSelection: setCurrency
              });
            
              $('.img-flag').css({'width':'50px','height':'20px'}); //Cambia el tamaño de la imagen que se mostrara en el selectB

          }
          

          if(actual.id_sucursal != 0){
              $('#s_responsable_sucursales_c').val(actual.id_sucursal).prop('disabled',true);
              $('#s_responsable_sucursales_c').select2({placeholder: $(this).data('elemento')});
          }

          if(actual.id_area != 0){
              $('#s_responsable_area_c').val(actual.id_area).prop('disabled',true);
              $('#s_responsable_area_c').select2({placeholder: $(this).data('elemento')});
          }
          muestraDepartamentoArea('s_responsable_dpto_c', actual.id_sucursal, actual.id_area);
          if(actual.id_departamento != 0){
              $('#s_responsable_dpto_c').val(actual.id_departamento).prop('disabled',true);
              $('#s_responsable_dpto_c').select2({placeholder: $(this).data('elemento')});
          }

          $("#i_cliente_c").attr('alt',actual.id_cliente).prop('disabled',true);
          $("#i_cliente_c").val(actual.cliente).prop('disabled',true);
         

          $('#b_responsable_devolver_comodato').attr('alt',actual.id_activo_responsable).prop('disabled',false);
          $('#b_comodato_guardar').prop('disabled',true).attr('alt',idActivo);
          $('#b_imprimir_salida_comodato').show();
        
        }
      }else{
        limpiarResponsable(0,'C');
      }
    },
    error: function (data) {
      mandarMensaje('Buscar Responsable Error 500 ');
    }
    });
}

$('#b_buscar_activo').click(function(){
  $("#dialog_buscar_activos").modal('show');
  $("#i_buscar_no_economico").val('');
  $("#i_buscar_no_serie").val('');
  $("#i_fecha_buscar_activo").val('');
  $("#i_fecha_buscar_activo_fin").val('');
  $("#i_licencia").val('');
  $("#i_veh_poliza").val('');
  $("#i_veh_circulacion").val('');
  muestraSelectEF('s_buscar_propietario');
  document.getElementById('s_buscar_tipo').selectedIndex = 0;

});

// Modales Agregar de Vehiculo (TIPO-MARCA) ------------------------------------
$('#b_veh_tipo').click(function(){
  $("#dialog_veh_tipo").modal('show');
});
$('#b_veh_marca').click(function(){
  $("#dialog_veh_marca").modal('show');
});
// Modales Agregar Celular   ---------------------------------------------------
$('#b_cel_marca').click(function(){
  $("#dialog_cel_marca").modal('show');
});
$('#b_cel_compania').click(function(){
  $("#dialog_cel_compania").modal('show');
});
// Modales Agregar Equipo de Computo   ---------------------------------------------------
$('#b_eq_marca').click(function(){
  $("#dialog_eq_marca").modal('show');
});
$('#b_eq_tipo').click(function(){
  $("#dialog_eq_tipo").modal('show');
});
// Modales Agregar Equipo de Computo   ---------------------------------------------------
$('#b_armas_marca').click(function(){
  $("#dialog_armas_marca").modal('show');
});
$('#b_armas_clase').click(function(){
  $("#dialog_armas_clase").modal('show');
});

//  Termina ----------------------------------------------------------------------------------------------------------

/**
// Acordeon Celulares ----------------------------------------------------------------------------------------------
// Select Marca Celular
**/
function selectMarcasCelular(){
  $.ajax({
    type: 'POST',
    url: 'php/combos_buscar.php',
    dataType:"json",
    data:{
      'tipoSelect' : 'SELECT_MARCAS_CELULARES'
    },
    success: function(data){
      options = "<option selected='true' disabled='disabled'>Seleccione:</option>";
      renglonMarca = "";
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        options += "<option value="+actual.id+">"+actual.marca+"</option>";
        renglonMarca += "<tr>";
        renglonMarca += "<td>"+actual.marca+"</td>";
        renglonMarca += "</tr>";
      }
      $("#s_cel_marca").html(options);
      $("#t_cel_marca").html(renglonMarca);
      return select_companias_celulares();
    },
    error: function (data){
      mandarMensaje('Marcas de celular Error 500 ');
    }
  });
}


// Select compañias celulares  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
function select_companias_celulares(){
  $.ajax({
    type: 'POST',
    url: 'php/combos_buscar.php',
    dataType:"json",
    data:{
      'tipoSelect' : 'SELECT_COMPANIAS_CELULARES'
    },
    success: function(data){
      options = "<option selected='true' disabled='disabled'>Seleccione:</option>";
      renglonCom = "";
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        options += "<option value="+actual.id+">"+actual.compania+"</option>";
        renglonCom += "<tr>";
        renglonCom += "<td>"+actual.compania+"</td>";
        renglonCom += "</tr>";
      }
      $("#s_cel_compania").html(options);
      $("#t_cel_compania").html(renglonCom);
    },
    error: function (data){
      mandarMensaje('Compañias celulares Error 500 ');
    }
  });
}

// Tabla Historial de Bitacora
function selectBitacora(busca){
  
  $("#t_bitacora_historial > tbody").empty();
   //--MGFS SE AGREGA CONDICION PARA QUE MUESTRE TODO
   if(busca=='TODO'){
    $('#ch_bitacora_mostrar').attr('alt','');
    $('#i_bitacora_no_economico').prop('disabled',false);
    $('#s_bitacora_tipo').prop('disabled',false);
    id = 0;
  }else{
    // Habilitar los botones preview_dictamen al deseleccionar el check Mostrar Todos
    $('#i_bitacora_no_economico').prop('disabled',true);
    $('#s_bitacora_tipo').prop('disabled',true);
    $('#i_bitacora_no_economico').val('');
    document.getElementById('s_bitacora_tipo').selectedIndex = 0;
    id = $('#ch_bitacora_mostrar').attr('alt');
  }

  console.log(id+' '+$('#i_fecha_inicio_b').val()+' '+$('#i_fecha_fin_b').val());

  $.ajax({
    type: "POST",
    url: "php/activos_bitacora.php",
    data: {
      'id':id,
      'fechaInicio':$('#i_fecha_inicio_b').val(),
      'fechaFin':$('#i_fecha_fin_b').val()
    },
    dataType: 'json',
    success: function(data){
      salida = "";
      tipo = "";
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        salida += "<tr no='"+i+"'>";
        salida += "<td>" + actual.num_economico + "</td>";
        salida += "<td>" + actual.tipo + "</td>";
        salida += "<td>" + actual.folio_requisicion + "</td>";
        salida += "<td>" + actual.descripcion + "</td>";
        salida += "<td>" + actual.fecha + "</td>";
        salida += "<td>" + actual.kilometraje + "</td>";
        salida += "<td>" + ((actual.tipo=='Siniestro') ? "<button class='btn btn-primary' type='button' id='preview_dictamen' onclick='return dictamenPDF();' style='margin:0px;'><i class='fa fa-eye' aria-hidden='true'></i></button>":''); + "</td>";
        //-->NJES February/16/2021  el primero
        salida += "<td>" + ((existeArchvioBitacora(actual.id_activo,actual.id_bitacora,'evidencia') == 1) ? "<button class='btn btn-primary b_evidencia' alt1='"+actual.id_activo+"' alt2='"+actual.id_bitacora+"' type='button' style='margin:0px;'><i class='fa fa-eye' aria-hidden='true'></i></button>":''); + "</td>";
        salida += "<td>" + ((existeArchvioBitacora(actual.id_activo,actual.id_bitacora,'foto1') == 1) ? "<button class='btn btn-primary b_foto1' alt1='"+actual.id_activo+"' alt2='"+actual.id_bitacora+"' type='button' onclick='' style='margin:0px;'><i class='fa fa-eye' aria-hidden='true'></i></button>":''); + "</td>";
        salida += "<td>" + ((existeArchvioBitacora(actual.id_activo,actual.id_bitacora,'foto2') == 1) ? "<button class='btn btn-primary b_foto2' alt1='"+actual.id_activo+"' alt2='"+actual.id_bitacora+"' type='button' onclick='' style='margin:0px;'><i class='fa fa-eye' aria-hidden='true'></i></button>":''); + "</td>";
        
        salida += "</tr>";
      }
      $("#t_bitacora_historial").html(salida);
      if( $('#ch_bitacora_mostrar').is(':checked') ){
          // Deshabilitar los botones preview_dictamen al seleccionar el check Mostrar Todos
          $('#t_bitacora_historial td.dict').hide();
      }else {
          // Habilitar los botones preview_dictamen al deseleccionar el check Mostrar Todos
          $('#t_bitacora_historial td.dict').show();
      }
    },
    error: function (data){
      console.log("php/activos_bitacora.php-->"+JSON.stringify(data));
      mandarMensaje("* Error al buscar información de Bitácora");
    }
  });
}

/**
// Acordeon Equipo de Computo ----------------------------------------------------------------------------------------------
// Select Marca Equipo de Computo
**/
function selectMarcaEq(){
  $.ajax({
    type: 'POST',
    url: 'php/combos_buscar.php',
    dataType:"json",
    data:{
      'tipoSelect' : 'SELECT_MARCAS_ECOMPUTO'
    },
    success: function(data){
      options = "<option selected='true' disabled='disabled'>Seleccione:</option>";
      renglonMarcaEq= "";
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        options += "<option value="+actual.id+">"+actual.marca+"</option>";
        renglonMarcaEq += "<tr>";
        renglonMarcaEq += "<td>"+actual.marca+"</td>";
        renglonMarcaEq += "</tr>";
      }
      $("#s_eq_marca").html(options);
      $("#t_eq_marca").html(renglonMarcaEq);
      return select_tipo_ecomputo();
    },
    error: function (data){
      mandarMensaje('Marcas de Equipos Error 500 ');
    }
  });
}

//-->NJES April/29/2020 se agrega función para mostrar opciones marca y clase de combo armas
function selectClaseArmas(){
  $.ajax({
    type: 'POST',
    url: 'php/combos_buscar.php',
    dataType:"json",
    data:{
      'tipoSelect' : 'SELECT_CLASE_ARMAS'
    },
    success: function(data){
      options = "<option selected='true' disabled='disabled'>Seleccione:</option>";
      renglonClaseArmas= "";
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        options += "<option value="+actual.id+">"+actual.clase+"</option>";
        renglonClaseArmas += "<tr>";
        renglonClaseArmas += "<td>"+actual.clase+"</td>";
        renglonClaseArmas += "</tr>";
      }
      $("#s_armas_clase").html(options);
      $("#t_armas_clase").html(renglonClaseArmas);
    },
    error: function (data){
      mandarMensaje('Clases de Armas Error 500 ');
    }
  });
}

function selectMarcaArmas(){
  $.ajax({
    type: 'POST',
    url: 'php/combos_buscar.php',
    dataType:"json",
    data:{
      'tipoSelect' : 'SELECT_MARCA_ARMAS'
    },
    success: function(data){
      options = "<option selected='true' disabled='disabled'>Seleccione:</option>";
      renglonMarcaArmas= "";
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        options += "<option value="+actual.id+">"+actual.marca+"</option>";
        renglonMarcaArmas += "<tr>";
        renglonMarcaArmas += "<td>"+actual.marca+"</td>";
        renglonMarcaArmas += "</tr>";
      }
      $("#s_armas_marca").html(options);
      $("#t_armas_marca").html(renglonMarcaArmas);
    },
    error: function (data){
      mandarMensaje('Clases de Armas Error 500 ');
    }
  });
}

// Select tipo Equipo de Computo - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
function select_tipo_ecomputo(){
  $.ajax({
    type: 'POST',
    url: 'php/combos_buscar.php',
    dataType:"json",
    data:{
      'tipoSelect' : 'SELECT_TIPO_ECOMPUTO'
    },
    success: function(data){
      options = "<option selected='true' disabled='disabled'>Seleccione:</option>";
      renglonTipoEq= "";
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        options += "<option value="+actual.id+">"+actual.tipo+"</option>";
        renglonTipoEq += "<tr>";
        renglonTipoEq += "<td>"+actual.tipo+"</td>";
        renglonTipoEq += "</tr>";
      }
      $("#s_eq_tipo").html(options);
      $("#t_eq_tipo").html(renglonTipoEq);
    },
    error: function (data){
      mandarMensaje('Equipo de computo Error 500 ');
    }
  });
}

// Inicia SELECT_TIPOS_VEHICULO
$( document ).ready(function() {
  //-->NJES April/30/2020 solo si tiene permisos podra ver la opcion armas
  var id_sucursal = buscaIdSucursal(idUnidadActual); 

  if(obtienePermisoArmas(id_sucursal,idUnidadActual) == 1)
  {
    $('#div_r_armas').css('display','block');
    $('#option_armas').css('display','block');
  }else{
    $('#div_r_armas').css('display','none');
    $('#option_armas').css('display','none');
  }

  //-->NJES May/13/2020 solo si tiene permisos podra ver las opciones vehiculo, celular, equipo de computo, otro
  if(obtienePermisoOpcionesGlobal(id_sucursal,idUnidadActual) == 1)
  {
    $('.div_r_global').css('display','block');
    $('.options_global').css('display','block');
  }else{
    $('.div_r_global').css('display','none');
    $('.options_global').css('display','none');
  }

  return selectMarcasVehiculo(), selectMarcasCelular(), selectMarcaEq(), tablaActivosBuscar(), selectMarcaArmas(), selectClaseArmas();
});

function buscaIdSucursal(idUnidadNegocio){
  var idSucursal = 0;
  $.ajax({
    type: 'POST',
    url: 'php/combos_buscar.php',
    dataType:"json", 
    data:{

        'tipoSelect' : 'PERMISOS_SUCURSALES',
        'idUnidadNegocio' : idUnidadNegocio,
        'modulo' : modulo,
        'idUsuario' : idUsuario

    },
    async:false,
    success: function(data) {
        idSucursal = data[0].id_sucursal;
    },
    error: function (xhr) {
        console.log("muestraSucursalCorporativo: "+JSON.stringify(xhr));
        mandarMensaje('* No se encontró información Sucursal Corporativo');
    }
  });

  return idSucursal;
}

function obtienePermisoArmas(idSucursal,idUnidadNegocio){
  var permisoArmas = 0;

  $.ajax({
    type: 'POST',
    url: 'php/activos_permiso_armas.php', 
    data:{
        'idUsuario' : idUsuario,
        'boton':'ARMAS_ACTIVOS_FIJOS',
        'idSucursal':idSucursal,
        'idUnidadNegocio':idUnidadNegocio
    },
    async : false,
    success: function(data) {
        
      //-->si data es 1 si tiene permiso
      permisoArmas = data;

    },
    error: function (xhr) {
        console.log("php/activos_permiso_armas.php --> "+JSON.stringify(xhr));
        mandarMensaje('* No se encontró información al verificar permisos armas');
    }
  });

  return permisoArmas;
}

//-->NJES May/13/2020 para verificar si tine permiso de ver las opciones de radio tipo 
//Vehiculo, Celular, Equipo de Computo
function obtienePermisoOpcionesGlobal(idSucursal,idUnidadNegocio){
  var permisoGlobal = 0;

  $.ajax({
    type: 'POST',
    url: 'php/activos_permiso_armas.php', 
    data:{
        'idUsuario' : idUsuario,
        'boton':'OPCIONES_GLOBAL_ACTIVOS_FIJOS',
        'idSucursal':idSucursal,
        'idUnidadNegocio':idUnidadNegocio
    },
    async : false,
    success: function(data) {
        
      //-->si data es 1 si tiene permiso
      permisoGlobal = data;

    },
    error: function (xhr) {
        console.log("php/activos_permiso_armas.php --> "+JSON.stringify(xhr));
        mandarMensaje('* No se encontró información al verificar permisos armas');
    }
  });
  console.log('permiso global: '+permisoGlobal);
  return permisoGlobal;
}

/**
// Acordeon Vehiculo ----------------------------------------------------------------------------------------------
// Select Marca Vehiculo
**/
function selectMarcasVehiculo(){
  $.ajax({
    type: 'POST',
    url: 'php/combos_buscar.php',
    dataType:"json",
    data:{
      'tipoSelect' : 'SELECT_MARCAS_VEHICULO'
    },
    success: function(data){
      options = "<option selected='true' disabled='disabled'>Seleccione:</option>";
      renglones2 = "";
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        options += "<option value="+actual.id+">"+actual.marcas+"</option>";
        renglones2 += "<tr>";
        renglones2 += "<td>"+actual.marcas+"</td>";
        renglones2 += "</tr>";
      }
      $("#s_veh_marca").html(options);
      // Llenamos tambien la tabla con los datos de los tipos existentes
      $("#t_veh_marca").html(renglones2);
      return select_tipo_vehiculo();
    },
    error: function (data){
      mandarMensaje('Marcas vehiculo Error 500 ');
    }
  });
}


// Select tipo Vehiculo - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
function select_tipo_vehiculo(){
  $.ajax({
    type: 'POST',
    url: 'php/combos_buscar.php',
    dataType:"json",
    data:{
      'tipoSelect' : 'SELECT_TIPOS_VEHICULO'
    },
    success: function(data){
      options = "<option selected='true' disabled='disabled'>Seleccione:</option>";
      renglones = "";
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        options += "<option value="+actual.id+">"+actual.tipos+"</option>";
        renglones += "<tr>";
        renglones += "<td>"+actual.tipos+"</td>";
        renglones += "</tr>";
      }
      $("#s_veh_tipo").html(options);
      // Llenamos tambien la tabla con los datos de los tipos existentes
      $("#t_veh_tipo").html(renglones);
    },
    error: function (data){
      mandarMensaje('Tipo Vehiculo Error 500 ');
    }
  });
}
// Acordeon Datos Generales - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


// Modal Responsables
// Select Unidades de Negocio, Sucursales y areas
var modulo='ACTIVOS_FIJOS';
var idUsuario=<?php echo $_SESSION['id_usuario']?>;
var usuario='<?php echo $_SESSION['usuario']?>';
var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
var matriz = <?php echo $_SESSION['sucursales']?>;
$(function(){
  muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
  muestraSelectUnidades(matriz,'s_responsable_unidades',idUnidadActual);
  muestraSucursalesPermiso('s_responsable_sucursales',idUnidadActual,modulo,idUsuario);
  muestraAreasAcceso('s_responsable_area');

  $('#ch_responsable_mostrar').prop('checked',true).prop('disabled',true);
  $('#i_fecha_inicio_h').val(primerDiaMes);
  $('#i_fecha_fin_h').val(ultimoDiaMes);

  $('#ch_bitacora_mostrar').prop('checked',true).prop('disabled',true);
  $('#i_fecha_inicio_b').val(primerDiaMes);
  $('#i_fecha_fin_b').val(ultimoDiaMes);

  return selectResponsables('TODO'),selectBitacora('TODO');
});

$(document).on('change','#i_fecha_inicio_b',function(){
  return selectBitacora('TODO');
});

$(document).on('change','#i_fecha_fin_b',function(){
  return selectBitacora('TODO');
});

$('#s_responsable_area').change(function()
{

  $('#s_responsable_dpto').prop('disabled',false);
  muestraDepartamentoArea('s_responsable_dpto', $('#s_responsable_sucursales').val(), $('#s_responsable_area').val());

  $('#i_cuip').removeClass('validate[required]').addClass('validate[required]');
  $('#lbl_cuip').removeClass('requerido').addClass('requerido');

});

$('#s_responsable_dpto').change(function(){
  $('#s_responsable_trabajador').prop('disabled',false);

});
//Boton Nuevo Limpieza de los imputs de toda la vista
$("#b_nuevo").click(function(){
  location.reload();
});
//                                               V A L I D A C I O N E S
// Boton Guardar
// Validar campo Tipo en modal Agregar Tipo - vehiculo  --------------------------------------------------------------------------------------------------------------------
$("#b_guardar_veh_tipo").click(function(){
  $('#b_guardar_veh_tipo').prop('disabled',true);
  if ($('#forma_vehiculo_tipo').validationEngine('validate')) {
    agregarTipoVeh = $("#i_add_veh_tipo").val();
    $('#b_guardar_veh_tipo').prop('disabled',false);
    return validarTipoVehiculo();
  }else{
    $('#b_guardar_veh_tipo').prop('disabled',false);
  }
});
// Validar Marca de Vehiculo
$("#b_guardar_veh_marca").click(function(){
  $('#b_guardar_veh_marca').prop('disabled',true);
  if ($('#forma_vehiculo_marca').validationEngine('validate')){
    agregarMarcaVeh = $("#i_add_veh_marca").val();
    $('#b_guardar_veh_marca').prop('disabled',false);
    return validarMarcaVehiculo();
  }else{
    $('#b_guardar_veh_marca').prop('disabled',false);
  }
});
// Validar Marca de Celular
$("#b_guardar_cel_marca").click(function(){
  $('#b_guardar_cel_marca').prop('disabled',true);
  if ($('#forma_celular_marca').validationEngine('validate')){
    agregarMarcaVeh = $("#i_add_cel_marca").val();
    $('#b_guardar_cel_marca').prop('disabled',false);
    return validarMarcaCel();
  }else{
    $('#b_guardar_cel_marca').prop('disabled',false);
  }
});
// Validar Compañia de Celular
$("#b_guardar_cel_compania").click(function(){
  $('#b_guardar_cel_compania').prop('disabled',true);
  if ($('#forma_celular_compania').validationEngine('validate')){
    agregarMarcaVeh = $("#i_add_cel_compania").val();
    $('#b_guardar_cel_compania').prop('disabled',false);
    return validarCompaniaCel();
  }else{
    $('#b_guardar_cel_compania').prop('disabled',false);
  }
});
// Validar Marca de Equipo de Computo
$("#b_guardar_eq_marca").click(function(){
  $('#b_guardar_eq_marca').prop('disabled',true);
  if ($('#forma_eq_marca').validationEngine('validate')){
    eqMarca = $("#i_add_eq_marca").val();
    $('#b_guardar_eq_marca').prop('disabled',false);
    return validarMarcaEq();
  }else{
    $('#b_guardar_eq_marca').prop('disabled',false);
  }
});
// Validar Marca de Equipo de Computo
$("#b_guardar_eq_tipo").click(function(){
  $('#b_guardar_eq_tipo').prop('disabled',true);
  if ($('#forma_eq_tipo').validationEngine('validate')){
    eqTipo = $("#i_add_eq_tipo").val();
    $('#b_guardar_eq_tipo').prop('disabled',false);
    return validarTipoEq();
  }else{
    $('#b_guardar_eq_tipo').prop('disabled',false);
  }
});

//-->NJES April/29/2020 agregar marca y clase de armas
$("#b_guardar_armas_marca").click(function(){
  $('#b_guardar_armas_marca').prop('disabled',true);
  if ($('#forma_armas_marca').validationEngine('validate')){
    armasMarca = $("#i_add_armas_marca").val();
    $('#b_guardar_armas_marca').prop('disabled',false);
    return validarMarcaArmas();
  }else{
    $('#b_guardar_armas_marca').prop('disabled',false);
  }
});

$("#b_guardar_armas_clase").click(function(){
  $('#b_guardar_armas_clase').prop('disabled',true);
  if ($('#forma_armas_marca').validationEngine('validate')){
    armasClase = $("#i_add_armas_clase").val();
    $('#b_guardar_armas_clase').prop('disabled',false);
    return validarClaseArmas();
  }else{
    $('#b_guardar_armas_clase').prop('disabled',false);
  }
});

// Validar el formulario Datos Generales y el tipo seleccionado - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
$('#b_guardar_activo').click(function(){
  $('#b_guardar_activo').prop('disabled',true);
  alt = $('#b_guardar_activo').attr('alt');
  // mandarMensaje(alt);
  if (alt == null || alt == '') {
    $('#b_guardar_activo').prop('disabled',true);
    if ($('#forma_generales').validationEngine('validate')){
      var noSerie = $('#i_no_serie').val();
      var descripcion = $('#i_descripcion').val();
      var fechaAdq = $('#i_fecha_adq').val();
      var valAdq = quitaComa($('#i_val_adq').val());
      var propietario = $('#s_propietario').val();
      var fechaFinCredito = $('#i_fecha_fin_credito').val();
      $('#b_guardar_activo').prop('disabled',false);
      radioTipo = $('input[name="r_tipo"]:checked').val();
      // Opcion 1 del Radio - Vehiculo  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
      if (radioTipo==1) {
        $('#b_guardar_activo').prop('disabled',true);
        if ($('#forma_vehiculo').validationEngine('validate'))
        {
          vehTipo=$('#s_veh_tipo').val();
          vehMarca=$('#s_veh_marca').val();
          vehColor=$('#i_veh_color').val();
          vehModelo=$('#i_veh_modelo').val();
          vehPlacas=$('#i_veh_placas').val();
          vehAnio=$('#i_veh_anio').val();
          $('#b_guardar_activo').prop('disabled',false);
          return guardarVehiculoDG();
        }else{
          $('#b_guardar_activo').prop('disabled',false);
        }
      }
      // Opcion 2 del Radio - Celular  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
      if (radioTipo==2) {
        $('#b_guardar_activo').prop('disabled',true);
        if ($('#forma_celular').validationEngine('validate'))
        {
          celMarca=$('#s_cel_marca').val();
          celCompania=$('#s_cel_compania').val();
          celImei=$('#i_cel_imei').val();
          celModelo=$('#i_cel_modelo').val();
          celNumero=$('#i_cel_numero').val();
          $('#b_guardar_activo').prop('disabled',false);
          return guardarCelularDG();
        }else{
          $('#b_guardar_activo').prop('disabled',false);
        }
      }
      // Opcion 3 del Radio - Eq. Computo  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
      if (radioTipo==3) {
        $('#b_guardar_activo').prop('disabled',true);
        if ($('#forma_computo').validationEngine('validate')){
          eqMarca=$('#s_eq_marca').val();
          eqModelo=$('#i_eq_modelo').val();
          eqTipo=$('#s_eq_tipo').val();
          eqCargador=$('#i_cargador').val();
          $('#b_guardar_activo').prop('disabled',false);
          return guardarEqDG();
        }else{
          $('#b_guardar_activo').prop('disabled',false);
        }
      }
      //-->NJES April/29/2020 gaurdar datos tipo armas Opcion 5 del Radio - Armas  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
      if (radioTipo==5) {
        $('#b_guardar_activo').prop('disabled',true);
        if ($('#forma_armas').validationEngine('validate')){
          armasMarca=$('#s_armas_marca').val();
          armasClase=$('#s_armas_clase').val();
          armasCalibre=$('#i_armas_calibre').val();
          armasModelo=$('#i_armas_modelo').val();
          armasMatricula=$('#i_armas_matricula').val();
          armasFechaIngreso=$('#i_armas_fecha_ingreso').val();
          armasFechaBaja=$('#i_armas_fecha_baja').val();
          return guardarArmasDG();
        }else{
          $('#b_guardar_activo').prop('disabled',false);
        }
      }
      // Opcion 4 del Radio - Otro  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
      if (radioTipo==4) {
        // Guardar
        return guardarDatosGenerales();
      }
    }else{
      $('#b_guardar_activo').prop('disabled',false);
    }
  }
  //
  //   Else si alt trae un id se pasa a actualizar datos
  //
  else {
 
    $('#b_guardar_activo').prop('disabled',true);
    if ($('#forma_generales').validationEngine('validate')){
      var noSerie = $('#i_no_serie').val();
      var descripcion = $('#i_descripcion').val();
      var fechaAdq = $('#i_fecha_adq').val();
      var valAdq = quitaComa($('#i_val_adq').val());
      var propietario = $('#s_propietario').val();
      var fechaFinCredito = $('#i_fecha_fin_credito').val();
      $('#b_guardar_activo').prop('disabled',false);
      radioTipo = $('input[name="r_tipo"]:checked').val();
      // Opcion 1 del Radio - Vehiculo  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
      if (radioTipo==1) {
        $('#b_guardar_activo').prop('disabled',true);
        if ($('#forma_vehiculo').validationEngine('validate'))
        {
          vehTipo=$('#s_veh_tipo').val();
          vehMarca=$('#s_veh_marca').val();
          vehColor=$('#i_veh_color').val();
          vehModelo=$('#i_veh_modelo').val();
          vehPlacas=$('#i_veh_placas').val();
          veAnio=$('#i_veh_anio').val();
          $('#b_guardar_activo').prop('disabled',false);
          return actualizarVehiculoDG(alt);
        }else{
          $('#b_guardar_activo').prop('disabled',false);
        }
      }
      // Opcion 2 del Radio - Celular  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
      if (radioTipo==2) {
        $('#b_guardar_activo').prop('disabled',true);
        if ($('#forma_celular').validationEngine('validate'))
        {
          celMarca=$('#s_cel_marca').val();
          celCompania=$('#s_cel_compania').val();
          celImei=$('#i_cel_imei').val();
          celModelo=$('#i_cel_modelo').val();
          celNumero=$('#i_cel_numero').val();
          $('#b_guardar_activo').prop('disabled',false);
          return actualizarCelularDG(alt);
        }else{
          $('#b_guardar_activo').prop('disabled',false);
        }
      }
      // Opcion 3 del Radio - Eq. Computo  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
      if (radioTipo==3) {
        $('#b_guardar_activo').prop('disabled',true);
        if ($('#forma_computo').validationEngine('validate')){
          eqMarca=$('#s_eq_marca').val();
          eqModelo=$('#i_eq_modelo').val();
          eqTipo=$('#s_eq_tipo').val();
          eqCargador=$('#i_cargador').val();
          $('#b_guardar_activo').prop('disabled',false);
          return actualizarEqDG(alt);
        }else{
          $('#b_guardar_activo').prop('disabled',false);
        }
      }
      //-->NJES April/29/2020 gaurdar datos tipo armas Opcion 5 del Radio - Armas  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
      if (radioTipo==5) {
        $('#b_guardar_activo').prop('disabled',true);
        if ($('#forma_armas').validationEngine('validate')){
          armasMarca=$('#s_armas_marca').val();
          armasClase=$('#s_armas_clase').val();
          armasCalibre=$('#i_armas_calibre').val();
          armasModelo=$('#i_armas_modelo').val();
          armasMatricula=$('#i_armas_matricula').val();
          armasFechaIngreso=$('#i_armas_fecha_ingreso').val();
          armasFechaBaja=$('#i_armas_fecha_baja').val();
          return actualizarArmasDG();
        }else{
          $('#b_guardar_activo').prop('disabled',false);
        }
      }
      // Opcion 4 del Radio - Otro  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
      if (radioTipo==4) {
        // Guardar
        return actualizarDatosGenerales(alt);
      }
    }else{
      $('#b_guardar_activo').prop('disabled',false);
    }
  }
});

$("#b_bitacora_guardar").click(function(){
  $('#b_bitacora_guardar').prop('disabled',true);
  if ($('#forma_bitacora').validationEngine('validate'))
  {
    bitacoraTipo=$('#s_bitacora_tipo_modal').val();
    bitacoraNoSerie=$('#s_bitacora_no_serie').val();
    bitacoraDescripcion=$('#i_bitacora_descripcion').val();
    bitacoraKilometraje=$('#i_kilometraje').val();
    $('#b_bitacora_guardar').prop('disabled',false);
    return guardarBitacora();
  }else{
    $('#b_bitacora_guardar').prop('disabled',false);
  }
});

$("#b_responsable_guardar").click(function(){
  $('#b_responsable_guardar').prop('disabled',true);
  if ($('#forma_responsable').validationEngine('validate'))
  {
    $('#b_responsable_guardar').prop('disabled',false);
    return verificarResponsable('R');
  }else{
    $('#b_responsable_guardar').prop('disabled',false);
  }
});

$("#b_comodato_guardar").click(function(){
  $('#b_comodato_guardar').prop('disabled',true);
  if ($('#forma_responsable').validationEngine('validate'))
  {
    $('#b_comodato_guardar').prop('disabled',false);
    return verificarResponsable('C');
  }else{
    $('#b_comodato_guardar').prop('disabled',false);
  }
});

// ****************************** Funciones de Guardado *************************************
function verificarResponsable(tipoR)
{

    activo = $("#b_guardar_activo").attr('alt');
    alt2 = $("#i_descripcion").val();
    if (activo == '' || activo == null) {
      mandarMensaje("<p>No se ah seleccionado algun<a style='color:#0062cc;'> Activo</a></p> <br> Seleccione alguno e intente guardar nuevamente.");
      $("#dialog_responsable").modal('hide');
    }
    else {
      $.ajax({
        type: 'POST',
        url: 'php/activos_verificar_responsable.php',
        dataType:"json",
        data:{'activo':activo,
              'tipo':tipoR
            },
        success: function(data){
          for (var i = 0; i < data.length; i++) {
            actual=data[i];
            if (actual.total==0) {

              if(tipoR=='R'){

                return guardarResponsable();

              }else{

                return guardarResponsableComodato();
              }
              
            }
            else {
              
              if(tipoR=='R'){
                mandarMensaje('<center> Este Activo:<br> <p style="color:#0062cc;">'+alt2+"</p> ya a sido Asignado </center> <br> <button type='button' onclick='return responsableReasignar()' class='btn btn-dark btn-sm form-control' id='b_responsable_reasignar'><i class='fa fa-user-plus' aria-hidden='true'></i> Reasignar</button> ");
              }else{
                mandarMensaje('<center> Este Activo:<br> <p style="color:#0062cc;">'+alt2+"</p> ya a sido Asignado </center> <br> <button type='button' onclick='return comodatoReasignar()' class='btn btn-dark btn-sm form-control' id='b_comodato_reasignar'><i class='fa fa-user-plus' aria-hidden='true'></i> Reasignar A Comodato</button> ");
              }
            }
          }

        },
        error: function (data) {
          console.log('php/activos_verificar_responsable.php-->'+JSON.stringify(data));
          mandarMensaje(' Error 500  AL VERIFICAR RESPONSABLE');
        }
      });
    }
}
function guardarResponsable()
{

    var unidad = $("#s_responsable_unidades").val();
    var sucursal = $("#s_responsable_sucursales").val();
    var area = $("#s_responsable_area").val();
    var dpto = $("#s_responsable_dpto").val();
    var no_empleado = $("#i_empleado").attr('alt');
    var activo = $("#b_guardar_activo").attr('alt');
    var vehNoLicencia = $("#i_no_licencia").val();
    var vehVigenciaLicencia = $("#i_vigencia_licencia").val();
    //-->NJES Feb/11/2020 se toma la familia gasto del producto activo,el folio del S10, el id del almacen_d y precio
    var idFamiliaGasto = $('#i_folio_recepcion').attr('familia_gasto');
    var folioS10 = $('#i_folio_recepcion').attr('folio_S10');
    var idAlmacenD = $('#i_folio_recepcion').attr('id_almacen_d');
    var precio = $('#i_folio_recepcion').attr('precio');
    var idRegistro = $('#i_folio_recepcion').attr('idS10');

    //-->NJES Feb/11/2020 segun el tipo de activo se asigna el id clasificación gasto
    //-->NJES Feb/12/2020 si la familia gasto es diferente de 14 no se clasifica al afectar el presupuesto
    if(idFamiliaGasto == 14)
    {
      
      //-->NJES May/28/2020 el vehiculo (1) se clasifica como 58 y celulcar (2) como 57
      if($('input[name=r_tipo]:checked').val() == 1)
        var idClasificacionGasto = 58;
      else if($('input[name=r_tipo]:checked').val() == 2)
        var idClasificacionGasto = 57;
      else if($('input[name=r_tipo]:checked').val() == 3)
        var idClasificacionGasto = 186;
      else
        var idClasificacionGasto = 0;
    }else
      var idClasificacionGasto = 0;

    if($('#ch_responsable_externo').is(':checked'))
      var responsable_externo = $('#i_empleado').val();
    else
      var responsable_externo = '';

    var info = {
      'no_empleado':no_empleado, 
      'unidad':unidad, 
      'sucursal':sucursal, 
      'area':area, 
      'dpto':dpto, 
      'activo':activo, 
      'vehNoLicencia':vehNoLicencia,
      'vehVigenciaLicencia':vehVigenciaLicencia,
      //-->NJES Feb/11/2020 se envian datos para afectar el presupuesto
      'idFamiliaGasto':idFamiliaGasto,
      'idClasificacionGasto':idClasificacionGasto,
      'idAlmacenD':idAlmacenD,
      'precio':precio,
      'folio':folioS10,
      'idS10':idRegistro,
      'cuip' : ($('#i_cuip').val() == null ? '' : $('#i_cuip').val()),
      'responsable_externo' : responsable_externo
    };

    //console.log(JSON.stringify(info));

    $.ajax({
      type: 'POST',
      url: 'php/activos_guardar_responsable.php',
      data:{
        'datos':info
      },
      success: function(data){
    
        if (data==true) {
          mandarMensaje(' Guardado Correctamente ');
          $("#dialog_responsable").modal('hide');
          $('#b_comodato').prop('disabled',true);
          $('#ch_inactivo').prop('disabled',true);
          imprimirSalidaActivoFijo('R');
          return guardarLicenciaPDF(),selectResponsables('');
        }
        else {
          mandarMensaje(' Ocurrio un error, vuelva a intentarlo ');
        }
      },
      error: function (data) {
        console.log('php/activos_guardar_responsable.php-->'+JSON.stringify(data));
        mandarMensaje(' Error 500 AL GURDAR AL RESPONSABLE');
      }
    });
}

function guardarResponsableComodato(){

  var unidad = $("#s_responsable_unidades_c").val();
  var sucursal = $("#s_responsable_sucursales_c").val();
  var area = $("#s_responsable_area_c").val();
  var dpto = $("#s_responsable_dpto_c").val();
  var no_cliente = $("#i_cliente_c").attr('alt');
  var activo = $("#b_guardar_activo").attr('alt');

  //-->NJES Feb/11/2020 se toma la familia gasto del producto activo,el folio del S10, el id del almacen_d y precio
  var idFamiliaGasto = $('#i_folio_recepcion').attr('familia_gasto');
  var folioS10 = $('#i_folio_recepcion').attr('folio_S10');
  var idAlmacenD = $('#i_folio_recepcion').attr('id_almacen_d');
  var precio = $('#i_folio_recepcion').attr('precio');
  var idRegistro = $('#i_folio_recepcion').attr('idS10');

  //-->NJES Feb/11/2020 segun el tipo de activo se asigna el id clasificación gasto
  //-->NJES Feb/12/2020 si la familia gasto es diferente de 14 no se clasifica al afectar el presupuesto
  if(idFamiliaGasto == 14)
  {
    if($('input[name=r_tipo]:checked').val() == 1)
      var idClasificacionGasto = 57;
    else if($('input[name=r_tipo]:checked').val() == 2)
      var idClasificacionGasto = 58;
    else if($('input[name=r_tipo]:checked').val() == 3)
      var idClasificacionGasto = 186;
    else
      var idClasificacionGasto = 0;
  }else
    var idClasificacionGasto = 0;

  var info = {
    'no_cliente':no_cliente,
    'unidad':unidad, 
    'sucursal':sucursal, 
    'area':area, 
    'dpto':dpto, 
    'activo':activo,
    //-->NJES Feb/11/2020 se envian datos para afectar el presupuesto
    'idFamiliaGasto':idFamiliaGasto,
    'idClasificacionGasto':idClasificacionGasto,
    'idAlmacenD':idAlmacenD,
    'precio':precio,
    'folio':folioS10,
    'idS10':idRegistro
  };

  $.ajax({
    type: 'POST',
    url: 'php/activos_guardar_responsable.php',
    data:{
      'datos':info
    },
    success: function(data){
      if (data==true) {
        mandarMensaje(' Guardado Correctamente ');
        $("#dialog_comodato").modal('hide');
        $('#b_responsables').prop('disabled',true);
        $('#ch_inactivo').prop('disabled',true);
        imprimirSalidaActivoFijo('C');
        return selectResponsables('');
      }
      else {
        mandarMensaje(' Ocurrio un error, vuelva a intentarlo ');
      }
    },
    error: function (data) {
      console.log('php/activos_guardar_responsable.php-->'+JSON.stringify(data));
      mandarMensaje(' Error 500 AL GURDAR AL RESPONSABLE');
    }
  });
}

function guardarBitacora(){
  tipo = $("#s_bitacora_tipo_modal").val();
  descripcion = $("#i_bitacora_descripcion").val();
  kilometraje = $("#i_kilometraje").val();
  id = $("#b_guardar_activo").attr('alt');
  no_serie = $("#s_bitacora_no_serie option:selected").attr('alt');
  var f = new Date();
  f=(f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate());
  if (id == '' || id == null) {
    mandarMensaje("<p>No se ah seleccionado algun<a style='color:#0062cc;'> Activo</a></p> <br> Seleccione alguno e intente guardar nuevamente.");
    $("#dialog_responsable").modal('hide');
  }
  else {
    $.ajax({
      type: 'POST',
      url: 'php/activos_guardar_bitacora.php',
      // dataType:"json",
      data:{'tipo':tipo, 'descripcion':descripcion, 'kilometraje':kilometraje, 'id':id},
      success: function(data){
        console.log(' guarda bitacora: '+data);
        //if (data==true) {
        //-->NJES February/16/2021 regresar el id insertado
        if (data > 0) {
          mandarMensaje(' Guardado Correctamente ');
          $('#dialog_bitacora').modal('hide');
          return guardarArchivosBitacora(data),selectBitacora(''), guardarDictamenPDF();
        }
        else {
          mandarMensaje(' Ocurrio un error, vuelva a intentarlo ');
        }
      },
      error: function (data) {
        mandarMensaje(' Error 500 AL GUARDAR BITACORA');
      }
    });
  }
}

function guardarDatosGenerales(){
  arregloDG= {
    'noSerie' : $('#i_no_serie').val(),
    'noEco' : document.getElementById('i_num_eco').value,
    'descripcion' : $('#i_descripcion').val(),
    'codBarras' : $('#i_cod_barras').val(),
    'fechaAdq' : $('#i_fecha_adq').val(),
    'valAdq' : quitaComa($('#i_val_adq').val()),
    'fechaBaja' : $('#i_fecha_baja').val(),
    'propietario' : $('#s_propietario').val(),
    'radioCompra' : $('input[name="r_compra"]:checked').val(),
    'anticipo' : $('#i_anticipo').val(),
    'mensualidades' : $('#i_mensualidades').val(),
    'fechaFinCredito' : $('#i_fecha_fin_credito').val(),
    'observaciones' : $('#i_observaciones').val(),
    'radioTipo' : $('input[name="r_tipo"]:checked').val(),
    'folioRecepcion' : $('#i_folio_recepcion').val(),
    'idAlmacenE' : $('#i_folio_recepcion').attr('alt'),
    'idAlmacenD' : $('#i_folio_recepcion').attr('alt2'),
    'idUnidadNegocio' : $('#i_folio_recepcion').attr('alt3'),
    'idUsuario' : idUsuario,
    'usuario' : usuario,
    //-->NJES Feb/10/2020 se comenta porque ya no existe el elemento en html
    //'idSucursal' : $('#s_filtro_sucursal').val()
    //-->NJES Feb/10/2020 se toma el id familia gasto de la familia del producto para guardarlo al hacer el movimiento presupuesto
    'idFamiliaGasto':$('#i_folio_recepcion').attr('familia_gasto'),
    'idSucursal':$('#i_folio_recepcion').attr('sucursal'),
    //-->NJES December/17/2020 inactivar activo y solicitar fecha bala obligatoria cuando se inactiva
    'inactivo' : $('#ch_inactivo').is(':checked') ? 1 : 0
  };
  
  if(verificaNumEconomico() == 0)
  {
    $.ajax({
      type: 'POST',
      url: 'php/activos_guardar.php',
      data:{'datos_generales':arregloDG},
      success: function(data){
      
        if (data!=false) {
          mandarMensaje(' Guardado Correctamente ');
          $('#b_guardar_activo').attr('alt',data);
          $('input[name="r_tipo"]').attr('disabled',true);
          $('#b_responsables').prop('disabled',false);
          $('#ch_inactivo').prop('disabled',false);
          return guardarAmortisazionPDF();
          activoSelected(data);
        }
        else {
          mandarMensaje(' Ocurrio un error, vuelva a intentarlo ');
        }
      },
      error: function (data) {
        console.log('php/activos_guardar.php--->'+JSON.stringify(data));
        mandarMensaje(' Error 500 AL GUARDAR LOS DATOS GENERALES');
      }
    });
  }else{
    mandarMensaje('El numero economico '+$('#i_num_eco').val()+' ya existe, intenta con otro.');
  }
}
// Actuaizar datos generales
function actualizarDatosGenerales(alt){

  arregloDG= {
    'noSerie' : $('#i_no_serie').val(),
    'noEco' : document.getElementById('i_num_eco').value,
    'descripcion' : $('#i_descripcion').val(),
    'codBarras' : $('#i_cod_barras').val(),
    'fechaAdq' : $('#i_fecha_adq').val(),
    'valAdq' : quitaComa($('#i_val_adq').val()),
    'fechaBaja' : $('#i_fecha_baja').val(),
    'propietario' : $('#s_propietario').val(),
    'radioCompra' : $('input[name="r_compra"]:checked').val(),
    'anticipo' : $('#i_anticipo').val(),
    'mensualidades' : $('#i_mensualidades').val(),
    'fechaFinCredito' : $('#i_fecha_fin_credito').val(),
    'observaciones' : $('#i_observaciones').val(),
    'radioTipo' : $('input[name="r_tipo"]:checked').val(),
    'folioRecepcion' : $('#i_folio_recepcion').val(),
    'idAlmacenE' : $('#i_folio_recepcion').attr('alt'),
    'idAlmacenD' : $('#i_folio_recepcion').attr('alt2'),
    'idUnidadNegocio' : $('#i_folio_recepcion').attr('alt3'),
    'idUsuario' : idUsuario,
    'usuario' : usuario,
    //-->NJES Feb/10/2020 se comenta porque ya no existe el elemento en html
    //'idSucursal' : $('#s_filtro_sucursal').val()
    //-->NJES Feb/10/2020 se toma el id familia gasto de la familia del producto para guardarlo al hacer el movimiento presupuesto
    'idFamiliaGasto':$('#i_folio_recepcion').attr('familia_gasto'),
    //-->NJES December/17/2020 inactivar activo y solicitar fecha bala obligatoria cuando se inactiva
    'inactivo' : $('#ch_inactivo').is(':checked') ? 1 : 0
  };

  
    $.ajax({
      type: 'POST',
      url: 'php/activos_actualizar.php',
      // dataType:"json",
      data:{'datos_generales':arregloDG, 'id':alt},
      success: function(data){
        if (data==true) {
          mandarMensaje(' Actualizado Correctamente ');
          guardarAmortisazionPDF();
          activoSelected(alt);
        }
        else {
          mandarMensaje(' Ocurrio un error, vuelva a intentarlo ');
        }
      },
      error: function (data) {
        mandarMensaje(' Error 500 ACTUALIZAR DATOS GENERALES');
      }
    });
  
}

function verificaNumEconomico(){
  var verifica = 1;

  $.ajax({
      type: 'POST',
      url: 'php/activos_verificar_num_economico.php',
      //dataType:"json", 
      data:  {'numeroEconomico':$('#i_num_eco').val()},
      async: false, //-->quita asincrono para que pueda returnar el valor cuando ya se haya terminado el proceso ajax
      success: function(data) 
      {
        verifica = data;
      },
      error: function (xhr) {
        console.log('error --> php/activos_verificar_num_economico.php --> '+JSON.stringify(xhr));
        mandarMensaje('* No se encontro información al verificar el numero economico');
      }
  });
  
  return verifica;
}

function validarTipoVehiculo(){
  tipoVeh = $("#i_add_veh_tipo").val();
  $.ajax({
    type: 'POST',
    url: 'php/activos_validar_tipo_vehiculo.php',
    // dataType:"json",
    data:{'tipoVeh':tipoVeh},
    success: function(data){
      actual=data.length-1;
      if (data[actual]==0) {
        return guardarTipoVehiculo();
      }
      else {
        mandarMensaje(' Este registro ya existe: <p style="color:red;">'+tipoVeh+"</p>");
      }
    },
    error: function (data) {
      mandarMensaje(' Error 500 VALIDAR VEHICULO');
    }
  });
}


//
function guardarTipoVehiculo(){
  tipoVeh = $("#i_add_veh_tipo").val();
  $.ajax({
    type: 'POST',
    url: 'php/activos_guardar_tipo_vehiculo.php',
    // dataType:"json",
    data:{'tipoVeh':tipoVeh},
    success: function(data){
      if (data==true) {
        renglones += "<tr>";
        renglones += "<td>"+tipoVeh+"</td>";
        renglones += "</tr>";
        $("#t_veh_tipo").html(renglones);
        mandarMensaje(' Guardado Correctamente ');
        return select_tipo_vehiculo();
      }
      else {
        mandarMensaje(' Ocurrio un Error, vuelva a intentarlo. ');
      }
    },
    error: function (data) {
      mandarMensaje(' Error 500 GUARDAR VEHICULO');
    }
  });
}

// Modales Vehiculo
//Funciones para agregar una nueva Marca en Vehiculos
function validarMarcaVehiculo(){
  marcaVeh = $("#i_add_veh_marca").val();
  $.ajax({
    type: 'POST',
    url: 'php/activos_validar_marca_vehiculo.php',
    // dataType:"json",
    data:{'marcaVeh':marcaVeh},
    success: function(data){
      if (data==0) {
        return guardarMarcaVehiculo();
      }
      else {
        mandarMensaje(' Este registro ya existe: <p style="color:red;">'+marcaVeh+"</p>");
      }
    },
    error: function (data) {
      mandarMensaje(' Error 500 VALIDAR MARCA VEHICULO ');
    }
  });
}
//
function guardarMarcaVehiculo(){
  marcaVeh = $("#i_add_veh_marca").val();
  $.ajax({
    type: 'POST',
    url: 'php/activos_guardar_marca_vehiculo.php',
    // dataType:"json",
    data:{'marcaVeh':marcaVeh},
    success: function(data){
      if (data==true) {
        renglones2 += "<tr>";
        renglones2 += "<td>"+marcaVeh+"</td>";
        renglones2 += "</tr>";
        $("#t_veh_marca").html(renglones2);
        mandarMensaje(' Guardado Correctamente. ');
        return selectMarcasVehiculo();
      }
      else {
        mandarMensaje(' Ocurrio un error, vuelva a intentarlo ');
      }
    },
    error: function (data) {
      mandarMensaje(' Error 500 GUARDAR MARCA VEHICULO');
    }
  });
}
// Modales Celular
//Funciones para agregar una nueva Marca en Celulares
function validarMarcaCel(){
  marcaCel = $("#i_add_cel_marca").val();
  $.ajax({
    type: 'POST',
    url: 'php/activos_validar_marca_cel.php',
    // dataType:"json",
    data:{'marcaCel':marcaCel},
    success: function(data){
      if (data==0) {
        return guardarMarcaCel();
      }
      else {
        mandarMensaje(' Este registro ya existe: <p style="color:red;">'+marcaCel+"</p>");
      }
    },
    error: function (data) {
      mandarMensaje(' Error 500 VALIDAR MARCA CELULAR');
    }
  });
}
//
function guardarMarcaCel(){
  marcaCel = $("#i_add_cel_marca").val();
  $.ajax({
    type: 'POST',
    url: 'php/activos_guardar_marca_cel.php',
    // dataType:"json",
    data:{'marcaCel':marcaCel},
    success: function(data){
      if (data==true) {
        renglonMarca += "<tr>";
        renglonMarca += "<td>"+marcaCel+"</td>";
        renglonMarca += "</tr>";
        $("#t_cel_marca").html(renglonMarca);
        mandarMensaje(' Guardado Correctamente. ');
        return selectMarcasCelular();
      }
      else {
        mandarMensaje(' Ocurrio un error, vuelva a intentarlo. ');
      }
    },
    error: function (data) {
      mandarMensaje(' Error 500 GUARDAR MARCA CELULAR');
    }
  });
}
//Funciones para agregar una nueva Marca en Celulares
function validarCompaniaCel(){
  companiaCel = $("#i_add_cel_compania").val();
  $.ajax({
    type: 'POST',
    url: 'php/activos_validar_compania_cel.php',
    // dataType:"json",
    data:{'companiaCel':companiaCel},
    success: function(data){
      if (data==0) {
        return guardarCompaniaCel();
      }
      else {
        mandarMensaje(' Este registro ya existe: <p style="color:red;">'+companiaCel+"</p>");
      }
    },
    error: function (data) {
      mandarMensaje(' Error 500 VALIDAR COMPAÑIA');
    }
  });
}
//
function guardarCompaniaCel(){
  companiaCel = $("#i_add_cel_compania").val();
  $.ajax({
    type: 'POST',
    url: 'php/activos_guardar_compania_cel.php',
    // dataType:"json",
    data:{'companiaCel':companiaCel},
    success: function(data){
      if (data==true) {
        renglonCom += "<tr>";
        renglonCom += "<td>"+companiaCel+"</td>";
        renglonCom += "</tr>";
        $("#t_cel_compania").html(renglonCom);
        mandarMensaje(' Guardado Correctamente. ');
        return select_companias_celulares();
      }
      else {
        mandarMensaje(' Ocurrio un error, vuelva a intentarlo. ');
      }
    },
    error: function (data) {
      mandarMensaje(' Error 500 GUARDAR COMPAÑIA CELULAR');
    }
  });
}
//Modales Equipo de Computo
//Funciones para agregar una nueva Marca en Equipo de Computo
function validarMarcaEq(){
  marcaEq = $("#i_add_eq_marca").val();
  $.ajax({
    type: 'POST',
    url: 'php/activos_validar_marca_eq.php',
    // dataType:"json",
    data:{'marcaEq':marcaEq},
    success: function(data){
      if (data==0) {
        return guardarMarcaEq();
      }
      else {
        mandarMensaje(' Este registro ya existe: <p style="color:red;">'+marcaEq+"</p>");
      }
    },
    error: function (data) {
      mandarMensaje(' Error 500 VALIDAR MARCAS DE EQUIPO');
    }
  });
}
//
function guardarMarcaEq(){
  marcaEq = $("#i_add_eq_marca").val();
  $.ajax({
    type: 'POST',
    url: 'php/activos_guardar_marca_eq.php',
    // dataType:"json",
    data:{'marcaEq':marcaEq},
    success: function(data){
      if (data==true) {
        renglonMarcaEq += "<tr>";
        renglonMarcaEq += "<td>"+marcaEq+"</td>";
        renglonMarcaEq += "</tr>";
        $("#t_eq_marca").html(renglonMarcaEq);
        mandarMensaje(' Guardado Correctamente. ');
        return selectMarcaEq();
      }
      else {
        mandarMensaje(' Ocurrio un error, vuelva a intentarlo. ');
      }
    },
    error: function (data) {
      mandarMensaje(' Error 500 GUARDAR MARCA EQUIPO');
    }
  });
}
//
//Funciones para agregar un nuevo Tipo en Equipo de Computo
function validarTipoEq(){
  tipoEq = $("#i_add_eq_tipo").val();
  $.ajax({
    type: 'POST',
    url: 'php/activos_validar_tipo_eq.php',
    // dataType:"json",
    data:{'tipoEq':tipoEq},
    success: function(data){
      if (data==0) {
        return guardarTipoEq();
      }
      else {
        mandarMensaje(' Este registro ya existe: <p style="color:red;">'+tipoEq+"</p>");
      }
    },
    error: function (data) {
      mandarMensaje(' Ocurrio un Error al validar. ');
    }
  });
}
//
function guardarTipoEq(){
  tipoEq = $("#i_add_eq_tipo").val();
  $.ajax({
    type: 'POST',
    url: 'php/activos_guardar_tipo_eq.php',
    // dataType:"json",
    data:{'tipoEq':tipoEq},
    success: function(data){
      if (data==true) {
        renglonTipoEq += "<tr>";
        renglonTipoEq += "<td>"+tipoEq+"</td>";
        renglonTipoEq += "</tr>";
        $("#t_eq_tipo").html(renglonTipoEq);
        mandarMensaje(' Guardado Correctamente. ');
        return select_tipo_ecomputo();
      }
      else {
        mandarMensaje(' Ocurrio un error, vuelva a intentarlo ');
      }
    },
    error: function (data) {
      mandarMensaje(' Error 500 GUARDAR TIPO EQUIPO');
    }
  });
}

//-->NJES April/29/2020 funciones para validar que no existe una marca o clase de armas
function validarMarcaArmas(){
  marcaArmas = $("#i_add_armas_marca").val();
  $.ajax({
    type: 'POST',
    url: 'php/activos_validar_marca_armas.php',
    // dataType:"json",
    data:{'marcaArmas':marcaArmas},
    success: function(data){
      if (data==0) {
        return guardarMarcaArmas();
      }
      else {
        mandarMensaje(' Este registro ya existe: <p style="color:red;">'+marcaArmas+"</p>");
      }
    },
    error: function (data) {
      mandarMensaje(' Error 500 VALIDAR MARCAS DE ARMAS');
    }
  });
}

function validarClaseArmas(){
  claseArmas = $("#i_add_armas_clase").val();
  $.ajax({
    type: 'POST',
    url: 'php/activos_validar_clase_armas.php',
    // dataType:"json",
    data:{'claseArmas':claseArmas},
    success: function(data){
      if (data==0) {
        return guardarClaseArmas();
      }
      else {
        mandarMensaje(' Este registro ya existe: <p style="color:red;">'+claseArmas+"</p>");
      }
    },
    error: function (data) {
      mandarMensaje(' Error 500 VALIDAR CLASE DE ARMAS');
    }
  });
}

//-->NJES April/29/2020 funciones para guardar marca y clase de armas
function guardarMarcaArmas(){
  marcaArmas = $("#i_add_armas_marca").val();
  $.ajax({
    type: 'POST',
    url: 'php/activos_guardar_marca_armas.php',
    // dataType:"json",
    data:{'marcaArmas':marcaArmas},
    success: function(data){
      renglonMarcaArmas= "";
      if (data==true) {
        renglonMarcaArmas += "<tr>";
        renglonMarcaArmas += "<td>"+marcaArmas+"</td>";
        renglonMarcaArmas += "</tr>";
        $("#t_armas_marca").html(renglonMarcaArmas);
        mandarMensaje(' Guardado Correctamente. ');
        return selectMarcaArmas();
      }
      else {
        mandarMensaje(' Ocurrio un error, vuelva a intentarlo. ');
      }
    },
    error: function (data) {
      mandarMensaje(' Error 500 GUARDAR MARCA ARMAS');
    }
  });
}

function guardarClaseArmas(){
  claseArmas = $("#i_add_armas_clase").val();
  $.ajax({
    type: 'POST',
    url: 'php/activos_guardar_clase_armas.php',
    // dataType:"json",
    data:{'claseArmas':claseArmas},
    success: function(data){
      renglonClaseArmas= "";
      if (data==true) {
        renglonClaseArmas += "<tr>";
        renglonClaseArmas += "<td>"+claseArmas+"</td>";
        renglonClaseArmas += "</tr>";
        $("#t_armas_clase").html(renglonClaseArmas);
        mandarMensaje(' Guardado Correctamente. ');
        return selectClaseArmas();
      }
      else {
        mandarMensaje(' Ocurrio un error, vuelva a intentarlo. ');
      }
    },
    error: function (data) {
      mandarMensaje(' Error 500 GUARDAR MARCA EQUIPO');
    }
  });
}


// Funciones con transaccion para proceder a guardar el activo dependiendo el tipo seleccionado
function guardarVehiculoDG(){
  arregloDG= {
    'noSerie' : $('#i_no_serie').val(),
    'noEco' : document.getElementById('i_num_eco').value,
    'descripcion' : $('#i_descripcion').val(),
    'codBarras' : $('#i_cod_barras').val(),
    'fechaAdq' : $('#i_fecha_adq').val(),
    'valAdq' : quitaComa($('#i_val_adq').val()),
    'fechaBaja' : $('#i_fecha_baja').val(),
    'propietario' : $('#s_propietario').val(),
    'radioCompra' : $('input[name="r_compra"]:checked').val(),
    'anticipo' : $('#i_anticipo').val(),
    'mensualidades' : $('#i_mensualidades').val(),
    'fechaFinCredito' : $('#i_fecha_fin_credito').val(),
    'observaciones' : $('#i_observaciones').val(),
    'radioTipo' : $('input[name="r_tipo"]:checked').val(),
    'folioRecepcion' : $('#i_folio_recepcion').val(),
    'idAlmacenE' : $('#i_folio_recepcion').attr('alt'),
    'idAlmacenD' : $('#i_folio_recepcion').attr('alt2'),
    'idUnidadNegocio' : $('#i_folio_recepcion').attr('alt3'),
    'idUsuario' : idUsuario,
    'usuario' : usuario,
    //-->NJES Feb/10/2020 se comenta porque ya no existe el elemento en html
    //'idSucursal' : $('#s_filtro_sucursal').val()
    //-->NJES Feb/10/2020 se toma el id familia gasto de la familia del producto para guardarlo al hacer el movimiento presupuesto
    'idFamiliaGasto':$('#i_folio_recepcion').attr('familia_gasto'),
    'idSucursal':$('#i_folio_recepcion').attr('sucursal'),
    //-->NJES December/17/2020 inactivar activo y solicitar fecha bala obligatoria cuando se inactiva
    'inactivo' : $('#ch_inactivo').is(':checked') ? 1 : 0
  };
  arregloVeh = {
    'vehTipo' : $('#s_veh_tipo').val(),
    'vehMarca' : $('#s_veh_marca').val(),
    'vehColor' : $('#i_veh_color').val(),
    'vehModelo' : $('#i_veh_modelo').val(),
    'vehPlacas' : $('#i_veh_placas').val(),
    'vehAnio' : $('#i_veh_anio').val(),
    'vehVigencia' : $('#i_veh_vigencia').val(),
    'vehVigenciaCirculacion' : $('#i_veh_vigencia_circulacion').val(),
    'imeiGPS' : $('#i_imei_gps').val(),
    'responsivaFirmada' : $('#i_veh_responsiva_firmada').val()
  }
  
  if(verificaNumEconomico() == 0)
  {
    $.ajax({
      type: 'POST',
      url: 'php/activos_guardar_dg_veh.php',
      dataType:"json",
      data:{'datos_generales':arregloDG,'datos_vehiculo':arregloVeh},
      success: function(data){

        for (var i = 0; i < data.length; i++) {
          actual = data[i];
          if (data!=false) {
            mandarMensaje(' Guardado Correctamente ');
            $('#b_guardar_activo').attr('alt',actual.id);
            $('#b_guardar_activo').attr('alt2',actual.idVeh);
            $('input[name="r_tipo"]').attr('disabled',true);
            $('#ch_inactivo').prop('disabled',false);
            return guardarAmortisazionPDF(), guardarPolizaPDF(),guardarTargetaCirculacionPDF(),guardarResponsivaFirmadaPDF('i_veh_responsiva_firmada','preview_i_veh_responsiva_firmada');
          }
          else {
            mandarMensaje(' Ocurrio un error, vuelva a intentarlo ');
          }
        }
      },
      error: function (data) {
        console.log('php/activos_guardar_dg_veh.php--->'+JSON.stringify(data));
        mandarMensaje(' Error 500 GUARDAR VEHICULO');
      }
    });
  }else{
    mandarMensaje('El numero economico '+$('#i_num_eco').val()+' ya existe, intenta con otro.');
  }
}
// actualizar
// Funciones con transaccion para proceder a actualizar el activo dependiendo el tipo seleccionado
function actualizarVehiculoDG(id){

  id_veh = $('#b_guardar_activo').attr('alt2');
  arregloDG = {
    'noSerie' : $('#i_no_serie').val(),
    'noEco' : document.getElementById('i_num_eco').value,
    'descripcion' : $('#i_descripcion').val(),
    'codBarras' : $('#i_cod_barras').val(),
    'fechaAdq' : $('#i_fecha_adq').val(),
    'valAdq' : quitaComa($('#i_val_adq').val()),
    'fechaBaja' : $('#i_fecha_baja').val(),
    'propietario' : $('#s_propietario').val(),
    'radioCompra' : $('input[name="r_compra"]:checked').val(),
    'anticipo' : $('#i_anticipo').val(),
    'mensualidades' : $('#i_mensualidades').val(),
    'fechaFinCredito' : $('#i_fecha_fin_credito').val(),
    'observaciones' : $('#i_observaciones').val(),
    'radioTipo' : $('input[name="r_tipo"]:checked').val(),
    'folioRecepcion' : $('#i_folio_recepcion').val(),
    'idAlmacenE' : $('#i_folio_recepcion').attr('alt'),
    'idAlmacenD' : $('#i_folio_recepcion').attr('alt2'),
    'idUnidadNegocio' : $('#i_folio_recepcion').attr('alt3'),
    'idUsuario' : idUsuario,
    'usuario' : usuario,
    //-->NJES Feb/10/2020 se comenta porque ya no existe el elemento en html
    //'idSucursal' : $('#s_filtro_sucursal').val()
    //-->NJES Feb/10/2020 se toma el id familia gasto de la familia del producto para guardarlo al hacer el movimiento presupuesto
    'idFamiliaGasto':$('#i_folio_recepcion').attr('familia_gasto'),
    'idSucursal':$('#i_folio_recepcion').attr('sucursal'),
    //-->NJES December/17/2020 inactivar activo y solicitar fecha bala obligatoria cuando se inactiva
    'inactivo' : $('#ch_inactivo').is(':checked') ? 1 : 0
  };
  arregloVeh = {
    'vehTipo' : $('#s_veh_tipo').val(),
    'vehMarca' : $('#s_veh_marca').val(),
    'vehColor' : $('#i_veh_color').val(),
    'vehModelo' : $('#i_veh_modelo').val(),
    'vehPlacas' : $('#i_veh_placas').val(),
    'vehAnio' : $('#i_veh_anio').val(),
    'vehVigencia' : $('#i_veh_vigencia').val(),
    'vehVigenciaCirculacion' : $('#i_veh_vigencia_circulacion').val(),
    'imeiGPS' : $('#i_imei_gps').val(),
    'responsivaFirmada' : $('#i_veh_responsiva_firmada').val()  
  }
  
  
    $.ajax({
      type: 'POST',
      url: 'php/activos_actualizar_dg_veh.php',
      // dataType:"json",
      data:{'datos_generales':arregloDG,'datos_vehiculo':arregloVeh, 'id':id, 'id_veh':id_veh},
      success: function(data){
    
        if (data==1) {
          mandarMensaje(' Actualizado Correctamente. ');
          return guardarAmortisazionPDF(), guardarPolizaPDF(),guardarTargetaCirculacionPDF(),guardarResponsivaFirmadaPDF('i_veh_responsiva_firmada','preview_i_veh_responsiva_firmada');
        }
        else {
          mandarMensaje(' Ocurrio un error, vuelva a intentarlo... ');
        }
      },
      error: function (data) {
        console.log('php/activos_actualizar_dg_veh.php--->' +JSON.stringify(data));
        mandarMensaje(' Error 500 ACTUALIZAR VEHICULO');
      }
    });
  
}

function guardarCelularDG(){
  arregloDG= {
    'noSerie' : $('#i_no_serie').val(),
    'noEco' : document.getElementById('i_num_eco').value,
    'descripcion' : $('#i_descripcion').val(),
    'codBarras' : $('#i_cod_barras').val(),
    'fechaAdq' : $('#i_fecha_adq').val(),
    'valAdq' : quitaComa($('#i_val_adq').val()),
    'fechaBaja' : $('#i_fecha_baja').val(),
    'propietario' : $('#s_propietario').val(),
    'radioCompra' : $('input[name="r_compra"]:checked').val(),
    'anticipo' : $('#i_anticipo').val(),
    'mensualidades' : $('#i_mensualidades').val(),
    'fechaFinCredito' : $('#i_fecha_fin_credito').val(),
    'observaciones' : $('#i_observaciones').val(),
    'radioTipo' : $('input[name="r_tipo"]:checked').val(),
    'folioRecepcion' : $('#i_folio_recepcion').val(),
    'idAlmacenE' : $('#i_folio_recepcion').attr('alt'),
    'idAlmacenD' : $('#i_folio_recepcion').attr('alt2'),
    'idUnidadNegocio' : $('#i_folio_recepcion').attr('alt3'),
    'idUsuario' : idUsuario,
    'usuario' : usuario,
    //-->NJES Feb/10/2020 se comenta porque ya no existe el elemento en html
    //'idSucursal' : $('#s_filtro_sucursal').val()
    //-->NJES Feb/10/2020 se toma el id familia gasto de la familia del producto para guardarlo al hacer el movimiento presupuesto
    'idFamiliaGasto':$('#i_folio_recepcion').attr('familia_gasto'),
    'idSucursal':$('#i_folio_recepcion').attr('sucursal'),
    //-->NJES December/17/2020 inactivar activo y solicitar fecha bala obligatoria cuando se inactiva
    'inactivo' : $('#ch_inactivo').is(':checked') ? 1 : 0
  };
  arregloCel = {
    'celMarca' : $('#s_cel_marca').val(),
    'celCompania' : $('#s_cel_compania').val(),
    'celModelo' : $('#i_cel_modelo').val(),
    'celPaquete' : $('#i_cel_paquete').val(),
    'celImei' : $('#i_cel_imei').val(),
    'celContrato' : $('#i_cel_contrato').val(),
    'celNumero' : $('#i_cel_numero').val(),
    'celVigenciaContrato' : $('#i_cel_vigencia_contrato').val(),
    'responsivaFirmada' : $('#i_cel_responsiva_firmada').val()
  }
  
  if(verificaNumEconomico() == 0)
  {
    $.ajax({
      type: 'POST',
      url: 'php/activos_guardar_dg_cel.php',
      dataType:"json",
      data:{'datos_generales':arregloDG,'datos_celular':arregloCel},
      success: function(data){
    
        for (var i = 0; i < data.length; i++) {
          actual = data[i];
          if (data!=false) {
            mandarMensaje(' Guardado Correctamente ');
            $('#b_guardar_activo').attr('alt',actual.id);
            $('#b_guardar_activo').attr('alt2',actual.idCel);
            $('input[name="r_tipo"]').attr('disabled',true);
            $('#ch_inactivo').prop('disabled',false);
            return guardarAmortisazionPDF(),guardarResponsivaFirmadaPDF('i_cel_responsiva_firmada','preview_i_cel_responsiva_firmada');
          }
          else {
            mandarMensaje(' Ocurrio un error, vuelva a intentarlo ');
          }
        }
      },
      error: function (data) {
        console.log('php/activos_guardar_dg_cel.php-->'+JSON.stringify(data));
        mandarMensaje(' Error 500 GUARDAR CELULAR');
      }
    });
  }else{
    mandarMensaje('El numero economico '+$('#i_num_eco').val()+' ya existe, intenta con otro.');
  }
}

// Actualizar
function actualizarCelularDG(id){
  id_cel = $('#b_guardar_activo').attr('alt2');
  arregloDG = {
    'noSerie' : $('#i_no_serie').val(),
    'noEco' : document.getElementById('i_num_eco').value,
    'descripcion' : $('#i_descripcion').val(),
    'codBarras' : $('#i_cod_barras').val(),
    'fechaAdq' : $('#i_fecha_adq').val(),
    'valAdq' : quitaComa($('#i_val_adq').val()),
    'fechaBaja' : $('#i_fecha_baja').val(),
    'propietario' : $('#s_propietario').val(),
    'radioCompra' : $('input[name="r_compra"]:checked').val(),
    'anticipo' : $('#i_anticipo').val(),
    'mensualidades' : $('#i_mensualidades').val(),
    'fechaFinCredito' : $('#i_fecha_fin_credito').val(),
    'observaciones' : $('#i_observaciones').val(),
    'radioTipo' : $('input[name="r_tipo"]:checked').val(),
    'folioRecepcion' : $('#i_folio_recepcion').val(),
    'idAlmacenE' : $('#i_folio_recepcion').attr('alt'),
    'idAlmacenD' : $('#i_folio_recepcion').attr('alt2'),
    'idUnidadNegocio' : $('#i_folio_recepcion').attr('alt3'),
    'idUsuario' : idUsuario,
    'usuario' : usuario,
    //-->NJES Feb/10/2020 se comenta porque ya no existe el elemento en html
    //'idSucursal' : $('#s_filtro_sucursal').val()
    //-->NJES Feb/10/2020 se toma el id familia gasto de la familia del producto para guardarlo al hacer el movimiento presupuesto
    'idFamiliaGasto':$('#i_folio_recepcion').attr('familia_gasto'),
    'idSucursal':$('#i_folio_recepcion').attr('sucursal'),
    //-->NJES December/17/2020 inactivar activo y solicitar fecha bala obligatoria cuando se inactiva
    'inactivo' : $('#ch_inactivo').is(':checked') ? 1 : 0
  };
  arregloCel = {
    'celMarca' : $('#s_cel_marca').val(),
    'celCompania' : $('#s_cel_compania').val(),
    'celModelo' : $('#i_cel_modelo').val(),
    'celPaquete' : $('#i_cel_paquete').val(),
    'celImei' : $('#i_cel_imei').val(),
    'celContrato' : $('#i_cel_contrato').val(),
    'celNumero' : $('#i_cel_numero').val(),
    'celVigenciaContrato' : $('#i_cel_vigencia_contrato').val(),
    'responsivaFirmada' : $('#i_cel_responsiva_firmada').val()
  }
  
  
    $.ajax({
      type: 'POST',
      url: 'php/activos_actualizar_dg_cel.php',
      // dataType:"json",
      data:{'datos_generales':arregloDG,'datos_celular':arregloCel, 'id':id, 'id_cel':id_cel},
      success: function(data){
        if (data==1) {
          mandarMensaje(' Actualizado Correctamente. ');
          return guardarAmortisazionPDF(),guardarResponsivaFirmadaPDF('i_cel_responsiva_firmada','preview_i_cel_responsiva_firmada');
        }
        else {
          mandarMensaje(' Ocurrio un error, vuelva a intentarlo ');
        }
      },
      error: function (data) {
        mandarMensaje(' Error 500 ACTUALIZAR CELULAR');
      }
    });
  
}

//-->NJES April/29/2020 actualiza un registro de activos de tipo armas
function actualizarArmasDG(){
  var id_armas = $('#b_guardar_activo').attr('alt2');
  var arregloDG = {
    'noSerie' : $('#i_no_serie').val(),
    'noEco' : document.getElementById('i_num_eco').value,
    'descripcion' : $('#i_descripcion').val(),
    'codBarras' : $('#i_cod_barras').val(),
    'fechaAdq' : $('#i_fecha_adq').val(),
    'valAdq' : quitaComa($('#i_val_adq').val()),
    'fechaBaja' : $('#i_fecha_baja').val(),
    'propietario' : $('#s_propietario').val(),
    'radioCompra' : $('input[name="r_compra"]:checked').val(),
    'anticipo' : $('#i_anticipo').val(),
    'mensualidades' : $('#i_mensualidades').val(),
    'fechaFinCredito' : $('#i_fecha_fin_credito').val(),
    'observaciones' : $('#i_observaciones').val(),
    'radioTipo' : $('input[name="r_tipo"]:checked').val(),
    'folioRecepcion' : $('#i_folio_recepcion').val(),
    'idAlmacenE' : $('#i_folio_recepcion').attr('alt'),
    'idAlmacenD' : $('#i_folio_recepcion').attr('alt2'),
    'idUnidadNegocio' : $('#i_folio_recepcion').attr('alt3'),
    'idUsuario' : idUsuario,
    'usuario' : usuario,
    'idFamiliaGasto':$('#i_folio_recepcion').attr('familia_gasto'),
    'idSucursal':$('#i_folio_recepcion').attr('sucursal'),
    //-->NJES December/17/2020 inactivar activo y solicitar fecha bala obligatoria cuando se inactiva
    'inactivo' : $('#ch_inactivo').is(':checked') ? 1 : 0
  };

  var arregloArmas = {
    'armasMarca' : $('#s_armas_marca').val(),
    'armasClase' : $('#s_armas_clase').val(),
    'armasCalibre' : $('#i_armas_calibre').val(),
    'armasModelo' : $('#i_armas_modelo').val(),
    'armasMatricula' : $('#i_armas_matricula').val(),
    'armasFechaIngreso' : $('#i_armas_fecha_ingreso').val(),
    'armasFechaBaja' : $('#i_armas_fecha_baja').val(),
    'responsivaFirmada' : $('#i_armas_responsiva_firmada').val()
  };

  //console.log(JSON.stringify(arregloDG)+' - '+JSON.stringify(arregloArmas)+' - '+id+' - '+id_armas);
  
  $.ajax({
    type: 'POST',
    url: 'php/activos_actualizar_dg_armas.php',
    // dataType:"json",
    data:{'datos_generales':arregloDG,'datos_armas':arregloArmas, 'id':id, 'id_armas':id_armas},
    success: function(data){
      if (data==1) {
        mandarMensaje(' Actualizado Correctamente. ');
        return guardarAmortisazionPDF(),guardarResponsivaFirmadaPDF('i_armas_responsiva_firmada','preview_i_armas_responsiva_firmada');
      }
      else {
        mandarMensaje(' Ocurrio un error, vuelva a intentarlo ');
      }
    },
    error: function (data) {
      console.log('php/activos_actualizar_dg_armas.php-->'+JSON.stringify(data));
      mandarMensaje(' Error 500 ACTUALIZAR CELULAR');
    }
  });
}

function guardarEqDG(){
  arregloDG = {
    'noSerie' : $('#i_no_serie').val(),
    'noEco' : document.getElementById('i_num_eco').value,
    'descripcion' : $('#i_descripcion').val(),
    'codBarras' : $('#i_cod_barras').val(),
    'fechaAdq' : $('#i_fecha_adq').val(),
    'valAdq' : quitaComa($('#i_val_adq').val()),
    'fechaBaja' : $('#i_fecha_baja').val(),
    'propietario' : $('#s_propietario').val(),
    'radioCompra' : $('input[name="r_compra"]:checked').val(),
    'anticipo' : $('#i_anticipo').val(),
    'mensualidades' : $('#i_mensualidades').val(),
    'fechaFinCredito' : $('#i_fecha_fin_credito').val(),
    'observaciones' : $('#i_observaciones').val(),
    'radioTipo' : $('input[name="r_tipo"]:checked').val(),
    'folioRecepcion' : $('#i_folio_recepcion').val(),
    'idAlmacenE' : $('#i_folio_recepcion').attr('alt'),
    'idAlmacenD' : $('#i_folio_recepcion').attr('alt2'),
    'idUnidadNegocio' : $('#i_folio_recepcion').attr('alt3'),
    'idUsuario' : idUsuario,
    'usuario' : usuario,
    //-->NJES Feb/10/2020 se comenta porque ya no existe el elemento en html
    //'idSucursal' : $('#s_filtro_sucursal').val()
    //-->NJES Feb/10/2020 se toma el id familia gasto de la familia del producto para guardarlo al hacer el movimiento presupuesto
    'idFamiliaGasto':$('#i_folio_recepcion').attr('familia_gasto'),
    'idSucursal':$('#i_folio_recepcion').attr('sucursal'),
    //-->NJES December/17/2020 inactivar activo y solicitar fecha bala obligatoria cuando se inactiva
    'inactivo' : $('#ch_inactivo').is(':checked') ? 1 : 0
  };
  arregloEq = {
    'eqMarca' : $('#s_eq_marca').val(),
    'eqModelo' : $('#i_eq_modelo').val(),
    'eqTipo' : $('#s_eq_tipo').val(),
    'eqCargador' : $('#i_cargador').val(),
    'eqCaracteristicas' : $('#i_eq_caracteristicas').val(),
    'responsivaFirmada' : $('#i_eq_responsiva_firmada').val()
  }

  if(verificaNumEconomico() == 0)
  {
    $.ajax({
      type: 'POST',
      url: 'php/activos_guardar_dg_eq.php',
      dataType:"json",
      data:{'datos_generales':arregloDG,'datos_eq':arregloEq},
      success: function(data){
    
        for (var i = 0; i < data.length; i++) {
          actual = data[i];
          if (data!=false) {
            mandarMensaje(' Guardado Correctamente ');
            $('#b_guardar_activo').attr('alt',actual.id);
            $('#b_guardar_activo').attr('alt2',actual.idEq);
            $('input[name="r_tipo"]').attr('disabled',true);
            $('#ch_inactivo').prop('disabled',false);
            return guardarAmortisazionPDF(),guardarResponsivaFirmadaPDF('i_eq_responsiva_firmada','preview_i_eq_responsiva_firmada');
          }
          else {
            mandarMensaje(' Ocurrio un error, vuelva a intentarlo ');
          }

        }
      },
      error: function (data) {
        console.log('php/activos_guardar_dg_eq.php-->'+JSON.stringify(data));
        mandarMensaje(' Error 500 GUARDAR EQUIPO');
      }
    });
  }else{
    mandarMensaje('El numero economico '+$('#i_num_eco').val()+' ya existe, intenta con otro.');
  }
}

//-->NJES April/29/2020 guarda un nuevo registro de activos de tipo armas
function guardarArmasDG(){
  var arregloDG = {
    'noSerie' : $('#i_no_serie').val(),
    'noEco' : document.getElementById('i_num_eco').value,
    'descripcion' : $('#i_descripcion').val(),
    'codBarras' : $('#i_cod_barras').val(),
    'fechaAdq' : $('#i_fecha_adq').val(),
    'valAdq' : quitaComa($('#i_val_adq').val()),
    'fechaBaja' : $('#i_fecha_baja').val(),
    'propietario' : $('#s_propietario').val(),
    'radioCompra' : $('input[name="r_compra"]:checked').val(),
    'anticipo' : $('#i_anticipo').val(),
    'mensualidades' : $('#i_mensualidades').val(),
    'fechaFinCredito' : $('#i_fecha_fin_credito').val(),
    'observaciones' : $('#i_observaciones').val(),
    'radioTipo' : $('input[name="r_tipo"]:checked').val(),
    'folioRecepcion' : $('#i_folio_recepcion').val(),
    'idAlmacenE' : $('#i_folio_recepcion').attr('alt'),
    'idAlmacenD' : $('#i_folio_recepcion').attr('alt2'),
    'idUnidadNegocio' : $('#i_folio_recepcion').attr('alt3'),
    'idUsuario' : idUsuario,
    'usuario' : usuario,
    'idFamiliaGasto':$('#i_folio_recepcion').attr('familia_gasto'),
    'idSucursal':$('#i_folio_recepcion').attr('sucursal'),
    //-->NJES December/17/2020 inactivar activo y solicitar fecha bala obligatoria cuando se inactiva
    'inactivo' : $('#ch_inactivo').is(':checked') ? 1 : 0
  };
  var arregloArmas = {
    'armasMarca' : $('#s_armas_marca').val(),
    'armasClase' : $('#s_armas_clase').val(),
    'armasCalibre' : $('#i_armas_calibre').val(),
    'armasModelo' : $('#i_armas_modelo').val(),
    'armasMatricula' : $('#i_armas_matricula').val(),
    'armasFechaIngreso' : $('#i_armas_fecha_ingreso').val(),
    'armasFechaBaja' : $('#i_armas_fecha_baja').val(),
    'responsivaFirmada' : $('#i_armas_responsiva_firmada').val()
  }

  if(verificaNumEconomico() == 0)
  {
    $.ajax({
      type: 'POST',
      url: 'php/activos_guardar_dg_armas.php',
      dataType:"json",
      data:{'datos_generales':arregloDG,'datos_armas':arregloArmas},
      success: function(data){
    
        for (var i = 0; i < data.length; i++) {
          actual = data[i];
          if (data!=false) {
            mandarMensaje(' Guardado Correctamente ');
            $('#b_guardar_activo').attr('alt',actual.id);
            $('#b_guardar_activo').attr('alt2',actual.idArmas);
            $('input[name="r_tipo"]').attr('disabled',true);
            $('#ch_inactivo').prop('disabled',false);
            return guardarAmortisazionPDF(),guardarResponsivaFirmadaPDF('i_armas_responsiva_firmada','preview_i_armas_responsiva_firmada');
          }
          else {
            mandarMensaje(' Ocurrio un error, vuelva a intentarlo ');
          }

        }
      },
      error: function (data) {
        console.log('php/activos_guardar_dg_armas.php-->'+JSON.stringify(data));
        mandarMensaje(' Error 500 GUARDAR ARMAS');
      }
    });
  }else{
    mandarMensaje('El numero economico '+$('#i_num_eco').val()+' ya existe, intenta con otro.');
  }
}

function actualizarEqDG(id){
  id_eq = $('#b_guardar_activo').attr('alt2');
  arregloDG = {
    'noSerie' : $('#i_no_serie').val(),
    'noEco' : document.getElementById('i_num_eco').value,
    'descripcion' : $('#i_descripcion').val(),
    'codBarras' : $('#i_cod_barras').val(),
    'fechaAdq' : $('#i_fecha_adq').val(),
    'valAdq' : quitaComa($('#i_val_adq').val()),
    'fechaBaja' : $('#i_fecha_baja').val(),
    'propietario' : $('#s_propietario').val(),
    'radioCompra' : $('input[name="r_compra"]:checked').val(),
    'anticipo' : $('#i_anticipo').val(),
    'mensualidades' : $('#i_mensualidades').val(),
    'fechaFinCredito' : $('#i_fecha_fin_credito').val(),
    'observaciones' : $('#i_observaciones').val(),
    'radioTipo' : $('input[name="r_tipo"]:checked').val(),
    'folioRecepcion' : $('#i_folio_recepcion').val(),
    'idAlmacenE' : $('#i_folio_recepcion').attr('alt'),
    'idAlmacenD' : $('#i_folio_recepcion').attr('alt2'),
    'idUnidadNegocio' : $('#i_folio_recepcion').attr('alt3'),
    'idUsuario' : idUsuario,
    'usuario' : usuario,
    //-->NJES Feb/10/2020 se comenta porque ya no existe el elemento en html
    //'idSucursal' : $('#s_filtro_sucursal').val()
    //-->NJES Feb/10/2020 se toma el id familia gasto de la familia del producto para guardarlo al hacer el movimiento presupuesto
    'idFamiliaGasto':$('#i_folio_recepcion').attr('familia_gasto'),
    'idSucursal':$('#i_folio_recepcion').attr('sucursal'),
    //-->NJES December/17/2020 inactivar activo y solicitar fecha bala obligatoria cuando se inactiva
    'inactivo' : $('#ch_inactivo').is(':checked') ? 1 : 0
  };
  arregloEq = {
    'eqMarca' : $('#s_eq_marca').val(),
    'eqModelo' : $('#i_eq_modelo').val(),
    'eqTipo' : $('#s_eq_tipo').val(),
    'eqCargador' : $('#i_cargador').val(),
    'eqCaracteristicas' : $('#i_eq_caracteristicas').val(),
    'responsivaFirmada' : $('#i_eq_responsiva_firmada').val()
  }
  
  
    $.ajax({
      type: 'POST',
      url: 'php/activos_actualizar_dg_eq.php',
      // dataType:"json",
      data:{'datos_generales':arregloDG,'datos_eq':arregloEq, 'id':id, 'id_eq':id_eq},
      success: function(data){
        if (data==1) {
          mandarMensaje(' Actualizado Correctamente. ');
          return guardarAmortisazionPDF(),guardarResponsivaFirmadaPDF('i_eq_responsiva_firmada','preview_i_eq_responsiva_firmada');
        }
        else {
          mandarMensaje(' Ocurrio un error, vuelva a intentarlo ');
        }
      },
      error: function (data) {
        mandarMensaje(' Error 500 ACTUALIZAR EQUIPO');
      }
    });
  
}
// Tabla Activos en Modal Buscar activos
function tablaActivosBuscar(){
  // $('#s_buscar_propietario').val('1');
  
  var id_sucursal = buscaIdSucursal(idUnidadActual);

  var info = {
      'idUsuario' : idUsuario,
      'idSucursal':id_sucursal,
      'idUnidadNegocio':idUnidadActual
  };

  $("#t_buscar_activo").empty();
  $.ajax({
    type: 'POST',
    url: 'php/activos_buscar_activos.php',
    dataType:"json",
    data:{'datos':info},
    success: function(data){
      
      
      bitacora_tipo="<option selected='true' disabled='disabled'>Seleccione el activo:</option>";
      if(data.length > 0)
      {
        for (var i = 0; i < data.length; i++) {
            actual=data[i];
            salida = "";
            tipo = "";
            //-->NJES April/30/2020   en el query busca solo los tipo de los que tiene permiso.
              if (actual.tipo==1) {tipo="Vehiculo";}
              else if (actual.tipo=="2") {tipo="Celular";}
              else if (actual.tipo==3) {tipo="Equipo de Computo";}
              else if (actual.tipo==5) {tipo="Armas";}
              else {tipo="Otro";}
              salida += "<tr class='activo_renglon' alt="+actual.id+">";
              salida += "<td>" + actual.no_serie + "</td>";
              salida += "<td>" + actual.num_economico + "</td>";
              salida += "<td>" + actual.descripcion + "</td>";
              salida += "<td>" + actual.fecha_adquisicion + "</td>";
              salida += "<td>" + actual.valor_adquisicion + "</td>";
              salida += "<td>" + actual.propietario + "</td>";
              salida += "<td>" + tipo + "</td>";
              salida += "<td>" + actual.estatus + "</td>";
              salida += "</tr>";
              bitacora_tipo += "<option value="+actual.id+" alt="+actual.no_serie+" alt2='"+actual.descripcion+"'><b>No. Serie:</b> "+actual.no_serie+"&nbsp;&nbsp;&nbsp;&nbsp; <b>Descripcion:</b> "+actual.descripcion+"</option>";
          
          $("#t_buscar_activo").append(salida);
          $("#s_bitacora_no_serie").html(bitacora_tipo);
          $("#s_responable_activo").html(bitacora_tipo);
        }
      }else{
        var html='<tr>\
                        <td colspan="8">No se encontró información</td>\
                    </tr>';

        $('#t_buscar_activo').append(html);
      }

    },
    error: function (data) {
      mandarMensaje(' Error 50 ');
      console.log(data);
    }
  });
}

// Seleccion de un registro en la tabla Buscar Activos
// Llenado de los campos del formulario con los datos del registro seleccionado - - - - - - - -- - - - - - - - - -
$('#t_buscar_activo').on('click', '.activo_renglon', function(){

  idActivo = $(this).attr('alt');
  $('#b_guardar_activo').attr('alt',idActivo);
  $('#ch_bitacora_mostrar').attr('alt',idActivo);
  $('#ch_responsable_mostrar').click().prop('disabled',false);
  $('#ch_bitacora_mostrar').click().prop('disabled',false);

  
  $('#dialog_buscar_activos').modal('hide');

  return activoSelected(idActivo),selectBitacora(''),selectResponsables('');
});

function activoSelected(idActivo){

  $.ajax({
    type: 'POST',
    url: 'php/activos_buscar_selected.php',
    dataType:"json",
    data:{'idActivo':idActivo},
    success: function(data){
      
      for (var i = 0; i < data.length; i++) {
        actual=data[i];

        //-->NJES Feb/10/2020 se asigna atributo familia gasto del producto,folio del S10, id del almacen_d y precio
        $('#i_folio_recepcion').val(actual.folio_recepcion).attr({'idS10':actual.idS10,'familia_gasto':actual.id_familia_gasto,'folio_S10':actual.folio,'id_almacen_d':actual.id_almacen_d,'precio':actual.precio});

        //-->NJES Feb/10/2020 se comenta porque ya no existe el elemento en html
        /*if(parseInt(actual.id_sucursal)>0){
          $('#s_filtro_sucursal').val(actual.id_sucursal).prop('disabled',true);
          $('#s_filtro_sucursal').select2({placeholder: $(this).data('elemento')});
        }else{
          $('#s_filtro_sucursal').val('').prop('disabled',true);
          $('#s_filtro_sucursal').select2({placeholder: 'Selecciona'});
        }*/
        
        $('#b_buscar_recepcion').prop('disabled',true);
        $('#i_no_serie').val(actual.no_serie).prop('disabled',true);
        $('#i_num_eco').val(actual.num_economico).prop('disabled',true);
        $('#i_descripcion').val(actual.descripcion);
        $('#i_cod_barras').val(actual.codigo_barras);
        $('#i_fecha_adq').val(actual.fecha_adquisicion);
        $('#i_val_adq').val(actual.valor_adquisicion);
        $('#i_fecha_baja').val(actual.fecha_baja);
        $('#s_propietario').val(actual.id_empresa_fiscal).prop('disabled',true);
        $('#i_anticipo').val(actual.anticipo);
        $('#i_mensualidades').val(actual.mensualidades);
        $('#i_fecha_fin_credito').val(actual.fin_credito);
        $('#i_observaciones').val(actual.observaciones);
        $('#r_eq_computo').prop('checked',true);
        if(actual.financiamiento == 1)
        $('#r_contado').prop('checked',true);
        else if (actual.financiamiento == 2)
        $('#r_credito').prop('checked',true);
        else if (actual.financiamiento == 3)

        $('#r_arrendamiento').prop('checked',true);

        $('#b_responsables').prop('disabled',true);
        $('#b_comodato').prop('disabled',true);

        //-->NJES December/17/2020 inactivar activo y solicitar fecha baja obligatoria cuando se inactiva
        if(actual.inactivo == 0)
          $('#ch_inactivo').prop('checked',false);
        else
          $('#ch_inactivo').prop('checked',true);

        if(actual.responsable_asignado != 0 || actual.b_reactivar == 1)
          $('#ch_inactivo').prop('disabled',true);
        else
          $('#ch_inactivo').prop('disabled',false);

        if(actual.b_reactivar == 1)
          $('#label_reactivar').text('Solicitud en proceso para reactivar activo').removeClass('badge badge-warning').addClass('badge badge-warning');
        else
          $('#label_reactivar').text('').removeClass('badge badge-warning');

        //--MGFS 13-01-2020 SE COMENTA LA CONDICION DE FOLIO DE RECEPCION YA QUE LOS DATOS INGRESADOS COMO HISTORICO NO TIEIN FOLIO DE RECEPCIO=0
        //if(parseInt(actual.folio_recepcion) > 0 ){

        //-->NJES December/20/2020 si el responsable es 0 o null quiere decir que no se ha asignado o se genero una devolucion,
        //por lo tanto ya no importa si tiene trabajador, cliente o responsable externo, y se podra reasignar como comodato o responsable
        //si un activo esta inactivo no se podra asignar responsable o comodato
        if(actual.inactivo == 0)
        {
          if(actual.responsable_asignado != 0)
          {
            if(actual.tipo_responsable=='R'){

              $('#b_responsables').prop('disabled',false);

            }else if(actual.tipo_responsable=='C'){

              if(actual.tipo != 5)
                $('#b_comodato').prop('disabled',false);
              else
                $('#b_comodato').prop('disabled',true);

            }else{

              $('#b_responsables').prop('disabled',false);
              
              if(actual.tipo != 5)
                $('#b_comodato').prop('disabled',false);
              else
                $('#b_comodato').prop('disabled',true);
            }
          }else{
            $('#b_responsables').prop('disabled',false);
              
            if(actual.tipo != 5)
              $('#b_comodato').prop('disabled',false);
            else
              $('#b_comodato').prop('disabled',true);
          }
        }else{
          $('#b_responsables').prop('disabled',true);
          $('#b_comodato').prop('disabled',true);
        }
        //}

        radio = $('input[name="r_compra"]:checked').val();
        if (radio == 1) {
          $('#i_amortizacion').attr('disabled',true);
          $('#i_fecha_fin_credito').attr('disabled',true);
          $('#i_anticipo').attr('disabled',true);
          $('#i_mensualidades').attr('disabled',true);
        }
        else if (radio == 2) {
          $('#i_amortizacion').attr('disabled',false);
          $('#i_fecha_fin_credito').attr('disabled',false);
          $('#i_anticipo').attr('disabled',false);
          $('#i_mensualidades').attr('disabled',false);
        }
        else if (radio == 3) {
          $('#i_amortizacion').attr('disabled',false);
          $('#i_fecha_fin_credito').attr('disabled',false);
          $('#i_anticipo').attr('disabled',false);
          $('#i_mensualidades').attr('disabled',false);

        }
        else if (radio == 5) { //-->NJES April/30/2020 se agrega opcion activo tipo armas
          $('#i_amortizacion').attr('disabled',false);
          $('#i_fecha_fin_credito').attr('disabled',false);
          $('#i_anticipo').attr('disabled',false);
          $('#i_mensualidades').attr('disabled',false);

        }
       
        $('input[name="r_tipo"]').prop('checked',false).attr('disabled',true);
    
        if (actual.tipo==4) {
          $('#r_otro').prop('checked',true);
          $('.div_cuip').css('display','none');
          return formularioOtro(data);
        }
        else if (actual.tipo==3) {
          $('#r_eq_computo').prop('checked',true);
          $('.div_cuip').css('display','none');
          return formularioEqComp(data);
        }
        else if (actual.tipo==2) {
          $('#r_celular').prop('checked',true);
          $('.div_cuip').css('display','none');
          return formularioCelular(data);
        }
        else if (actual.tipo==1) {
          $('#r_vehiculo').prop('checked',true);
          $('.div_cuip').css('display','none');
          return formularioVehiculo(data);
        }else{
          $('#r_armas').prop('checked',true);
          $('.div_cuip').css('display','block');
          if(actual.externo == 1)
          {
            $('#ch_responsable_externo').prop('ckecked',true);
            $('#div_boton_busca_resp').css('display','none');
          }else{
            $('#ch_responsable_externo').prop('ckecked',false);
            $('#div_boton_busca_resp').css('display','block');
          }
          return formularioArmas(data);
        }
      
      }
    },
    error: function (data) {
      mandarMensaje(' Error 500 BUSCAR ACTIVO ');
    }
  });
}


function formularioOtro(data){
 
  for (var i = 0; i < data.length; i++) {
    actual=data[i];
    id = actual.id;
    
    $( "#heading_computo" ).hide();
    $('#collapse_computo').removeClass('show');
    $( "#heading_celular" ).hide();
    $('#collapse_celular').removeClass('show');
    $( "#heading_vehiculo" ).hide();
    $('#collapse_vehiculo').removeClass('show');
    $("#heading_armas" ).hide();
    $('#collapse_armas').removeClass('show');
    $('#b_guardar_activo').attr('alt',id);
  }
 
  return radiosRequired();
}
// Busqueda de un Registro y Llenado de Datos Generales y Vehiculo
function formularioVehiculo(data){
  for (var i = 0; i < data.length; i++) {
    actual=data[i];
    $("#collapse_vehiculo").css("display", "");
    $( "#heading_vehiculo" ).show();
    $('#collapse_vehiculo').addClass('show');
    $( "#heading_computo" ).hide();
    $('#collapse_computo').removeClass('show');
    $( "#heading_celular" ).hide();
    $('#collapse_celular').removeClass('show');
    $("#heading_armas" ).hide();
    $('#collapse_armas').removeClass('show');
    $('#i_licencia').removeClass('validate[required]');
    $('#i_licencia_label').removeClass('requerido');
    id=actual.id;
  }
  
  $.ajax({
    type: "POST",
    url: "php/activos_tipo_veh_query.php",
    data: {'id':id},
    dataType: 'json',
    success: function(data){
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        $('#s_veh_tipo').val(actual.tipo_vehiculo);
        $('#s_veh_marca').val(actual.marca);
        $('#i_veh_color').val(actual.color);
        $('#i_veh_modelo').val(actual.modelo);
        $('#i_veh_placas').val(actual.placas);
        $('#i_veh_anio').val(actual.anio);
        $('#i_veh_vigencia').val(actual.poliza);
        $('#i_veh_vigencia_circulacion').val(actual.circulacion);
        $('#i_imei_gps').val(actual.imei_gps);
        veh = actual.id_veh;
      }
      $('#b_guardar_activo').attr('alt',id);
      $('#b_guardar_activo').attr('alt2',veh);

      if(existeArchvioResponsivaFirmada(id) == 1)
      {
        $('#preview_i_veh_responsiva_firmada').prop('disabled',false);
      }else{
        $('#preview_i_veh_responsiva_firmada').prop('disabled',true);
      }

      return radiosRequired();
    },
    error: function (data){
      mandarMensaje("Error con la Busqueda #12.");
    }
  });
}
// Busqueda de un Registro y Llenado de Datos Generales y Celular
function formularioCelular(data){
  for (var i = 0; i < data.length; i++) {
    actual=data[i];
   
    $("#collapse_celular").css("display", "");
    $( "#heading_celular" ).show();
    $('#collapse_celular').addClass('show');
    $( "#heading_computo" ).hide();
    $('#collapse_computo').removeClass('show');
    $( "#heading_vehiculo" ).hide();
    $('#collapse_vehiculo').removeClass('show');
    $("#heading_armas" ).hide();
    $('#collapse_armas').removeClass('show');
    id=actual.id;
  }
  
  $.ajax({
    type: "POST",
    url: "php/activos_tipo_cel_query.php",
    data: {'id':id},
    dataType: 'json',
    success: function(data){
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        $('#s_cel_marca').val(actual.marca);
        $('#s_cel_compania').val(actual.compania);
        $('#i_cel_modelo').val(actual.modelo);
        $('#i_cel_paquete').val(actual.paquete);
        $('#i_cel_imei').val(actual.imei);
        $('#i_cel_contrato').val(actual.contrato);
        $('#i_cel_numero').val(actual.telefono);
        $('#i_cel_vigencia_contrato').val(actual.vigencia);
        cel=actual.id_cel;
      }
      $('#b_guardar_activo').attr('alt',id);
      $('#b_guardar_activo').attr('alt2',cel);

      if(existeArchvioResponsivaFirmada(id) == 1)
      {
        $('#preview_i_cel_responsiva_firmada').prop('disabled',false);
      }else{
        $('#preview_i_cel_responsiva_firmada').prop('disabled',true);
      }

      return radiosRequired();
    },
    error: function (data){
      mandarMensaje("Error con la Busqueda #13.");
    }
  });
}
// Busqueda de un Registro y Llenado de Datos Generales y Equipo de Computo
function formularioEqComp(data){
  for (var i = 0; i < data.length; i++) {
    actual=data[i];
 
    $("#collapse_computo").css("display", "");
    $( "#heading_computo" ).show();
    $('#collapse_computo').addClass('show');
    $( "#heading_celular" ).hide();
    $('#collapse_celular').removeClass('show');
    $( "#heading_vehiculo" ).hide();
    $('#collapse_vehiculo').removeClass('show');
    $("#heading_armas" ).hide();
    $('#collapse_armas').removeClass('show');
    id=actual.id;
  }

  $.ajax({
    type: "POST",
    url: "php/activos_tipo_eq_query.php",
    data: {'id':id},
    dataType: 'json',
    success: function(data){
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        $('#s_eq_marca').val(actual.marca);
        $('#i_eq_modelo').val(actual.modelo);
        $('#s_eq_tipo').val(actual.tipo_equipo);
        $('#i_cargador').val(actual.serie_cargador);
        $('#i_eq_caracteristicas').val(actual.caracteristicas);
        eq = actual.id_eq
      }
      $('#b_guardar_activo').attr('alt',id);
      $('#b_guardar_activo').attr('alt2',eq);

      if(existeArchvioResponsivaFirmada(id) == 1)
      {
        $('#preview_i_eq_responsiva_firmada').prop('disabled',false);
      }else{
        $('#preview_i_eq_responsiva_firmada').prop('disabled',true);
      }

      return radiosRequired();
    },
    error: function (data){
      mandarMensaje("Error con la Busqueda #14.");
    }
  });
}

//-->NJES April/30/2020 
function formularioArmas(data){
  console.log(JSON.stringify(data));
  for (var i = 0; i < data.length; i++) {
    actual=data[i];
 
    $("#collapse_armas").css("display", "");
    $("#heading_armas" ).show();
    $('#collapse_armas').addClass('show');
    $("#heading_celular" ).hide();
    $('#collapse_celular').removeClass('show');
    $("#heading_vehiculo" ).hide();
    $('#collapse_vehiculo').removeClass('show');
    $("#collapse_computo" ).hide();
    $('#heading_computo').removeClass('show');
    id=actual.id;
  }

  $.ajax({
    type: "POST",
    url: "php/activos_tipo_armas_query.php",
    data: {'id':id},
    dataType: 'json',
    success: function(data){
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        $('#s_armas_marca').val(actual.id_marca),
        $('#s_armas_clase').val(actual.id_clase),
        $('#i_armas_calibre').val(actual.calibre),
        $('#i_armas_modelo').val(actual.modelo),
        $('#i_armas_matricula').val(actual.matricula),
        $('#i_armas_fecha_ingreso').val(actual.fecha_ingreso),
        $('#i_armas_fecha_baja').val(actual.fecha_baja)
        var idArmas = actual.id_armas;

        $('#b_guardar_activo').attr('alt2',idArmas);
      }

      $('#b_guardar_activo').attr('alt',id);

      if(existeArchvioResponsivaFirmada(id) == 1)
      {
        $('#preview_i_armas_responsiva_firmada').prop('disabled',false);
      }else{
        $('#preview_i_armas_responsiva_firmada').prop('disabled',true);
      }
      
      return radiosRequired();
    },
    error: function (data){
      mandarMensaje("Error con la Busqueda #14.");
    }
  });
}

// Filtros del Modal Buscar Activos
$("#i_buscar_no_serie").keyup(function(e){
  $("#i_buscar_no_serie").focus();
  buscarActivosFiltros();
});

function buscarActivosFiltros(){

  no_economico = $("#i_buscar_no_economico").val();
  no_serie = $("#i_buscar_no_serie").val();
  fecha = $("#i_fecha_buscar_activo").val();
  empresa = $("#s_buscar_propietario").val();
  tipo = $("#s_buscar_tipo").val();
  f = $("#i_fecha_buscar_activo_fin").val();
  if (f==null || f=='') {
    var f = new Date();
    f=(f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate());
  }

  var id_sucursal = buscaIdSucursal(idUnidadActual);

  var info = {
      'idUsuario' : idUsuario,
      'idSucursal':id_sucursal,
      'idUnidadNegocio':idUnidadActual
  };

  $.ajax({
    type: "POST",
    url: "php/activos_buscar_filtro.php",
    data: {'datos':info,'no_serie':no_serie,'fecha':fecha, 'empresa':empresa,'tipo':tipo, 'f':f,'no_economico':no_economico},
    dataType: 'json',
    success: function(data){
      $("#t_buscar_activo").empty();
      
      if(data.length > 0)
      {
        for (var i = 0; i < data.length; i++) {
          actual=data[i];
          salida = "";
          tipo = "";

              if (actual.tipo==1) {tipo="Vehiculo";}
              else if (actual.tipo=="2") {tipo="Celular";}
              else if (actual.tipo==3) {tipo="Equipo de Computo";}
              else if (actual.tipo==5) {tipo="Armas";}
              else {tipo="Otro";}
              salida += "<tr class='activo_renglon' alt="+actual.id+">";
              salida += "<td>" + actual.no_serie + "</td>";
              salida += "<td>" + actual.num_economico + "</td>";
              salida += "<td>" + actual.descripcion + "</td>";
              salida += "<td>" + actual.fecha_adquisicion + "</td>";
              salida += "<td>" + actual.valor_adquisicion + "</td>";
              salida += "<td>" + actual.propietario + "</td>";
              salida += "<td>" + tipo + "</td>";
              salida += "<td>" + actual.estatus + "</td>";
              salida += "</tr>";
        
          $("#t_buscar_activo").append(salida);
        }
      }else{
        var html='<tr>\
                    <td colspan="7">No se encontró información</td>\
                </tr>';

        $('#t_buscar_activo').append(html);
      }
    },
    error: function (data){
      console.log("resultE"+JSON.stringify(data));
      mandarMensaje("Error con la Busqueda !.");
    }
  });
}


// Filtros del Modal Buscar Activos
$("#i_buscar_no_economico").keyup(function(e){
  buscarActivosFiltros();
});

$("#i_fecha_buscar_activo").change(function(){

  if($("#i_fecha_buscar_activo_fin")!=''){
     buscarActivosFiltros();
  }
  
});

$("#i_fecha_buscar_activo_fin").change(function(){
  buscarActivosFiltros();
});

$("#s_buscar_propietario").change(function(){
  buscarActivosFiltros();
});

$("#s_buscar_tipo").change(function(){
  buscarActivosFiltros();
});


// Filtros de Historial de Bitacora
$("#i_bitacora_no_economico").keyup(function(e){

  no_economico = $("#i_bitacora_no_economico").val();
  tipo = $("#s_bitacora_tipo").val();
  $.ajax({
    type: "POST",
    url: "php/activos_bitacora_filtro.php",
    data: {
      'no_economico':no_economico, 
      'tipo':tipo,
      //-->NJES June/11/2020 se agregan parametros filtros fechas
      'fechaInicio':$('#i_fecha_inicio_b').val(),
      'fechaFin':$('#i_fecha_fin_b').val()
    },
    dataType: 'json',
    success: function(data){
    
      bit = "";
      tipo = "";
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        bit += "<tr>";
        bit += "<td>" + actual.num_economico + "</td>";
        bit += "<td>" + actual.tipo + "</td>";
        bit += "<td>" + actual.folio_requisicion + "</td>";
        bit += "<td>" + actual.descripcion + "</td>";
        bit += "<td>" + actual.fecha + "</td>";
        bit += "<td>" + actual.kilometraje + "</td>";
        bit += "<td>" + ((actual.tipo=='Siniestro') ? "<button class='btn btn-primary' type='button' id='preview_dictamen' onclick='return dictamenPDF();' style='margin:0px;'><i class='fa fa-eye' aria-hidden='true'></i></button>":''); + "</td>";
        //-->NJES February/16/2021
        bit += "<td>" + ((existeArchvioBitacora(actual.id_activo,actual.id_bitacora,'evidencia') == 1) ? "<button class='btn btn-primary b_evidencia' alt1='"+actual.id_activo+"' alt2='"+actual.id_bitacora+"' type='button' style='margin:0px;'><i class='fa fa-eye' aria-hidden='true'></i></button>":''); + "</td>";
        bit += "<td>" + ((existeArchvioBitacora(actual.id_activo,actual.id_bitacora,'foto1') == 1) ? "<button class='btn btn-primary b_foto1' alt1='"+actual.id_activo+"' alt2='"+actual.id_bitacora+"' type='button' onclick='' style='margin:0px;'><i class='fa fa-eye' aria-hidden='true'></i></button>":''); + "</td>";
        bit += "<td>" + ((existeArchvioBitacora(actual.id_activo,actual.id_bitacora,'foto2') == 1) ? "<button class='btn btn-primary b_foto2' alt1='"+actual.id_activo+"' alt2='"+actual.id_bitacora+"' type='button' onclick='' style='margin:0px;'><i class='fa fa-eye' aria-hidden='true'></i></button>":''); + "</td>";
        bit += "</tr>";
      }
      $("#t_bitacora_historial").empty();
      $("#t_bitacora_historial").html(bit);
    },
    error: function (data){
      console.log("php/activos_bitacora_filtro.php-->"+JSON.stringify(data));
      mandarMensaje("Error con la Busqueda #05.");
    }
  });
});


$("#s_bitacora_tipo").change(function(e){
  
  no_economico = $("#i_bitacora_no_economico").val();
  tipo = $("#s_bitacora_tipo").val();
  $.ajax({
    type: "POST",
    url: "php/activos_bitacora_filtro.php",
    data: {
      'no_economico':no_economico,
      'tipo':tipo,
      //-->NJES June/11/2020 se agregan parametros filtros fechas
      'fechaInicio':$('#i_fecha_inicio_b').val(),
      'fechaFin':$('#i_fecha_fin_b').val()
    },
    dataType: 'json',
    success: function(data){
     
      salida = "";
      tipo = "";
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        salida += "<tr>";
        salida += "<td>" + actual.num_economico + "</td>";
        salida += "<td>" + actual.tipo + "</td>";
        salida += "<td>" + actual.folio_requisicion + "</td>";
        salida += "<td>" + actual.descripcion + "</td>";
        salida += "<td>" + actual.fecha + "</td>";
        salida += "<td>" + actual.kilometraje + "</td>";
        salida += "<td>" + ((actual.tipo=='Siniestro') ? "<button class='btn btn-primary' type='button' id='preview_dictamen' onclick='return dictamenPDF();' style='margin:0px;'><i class='fa fa-eye' aria-hidden='true'></i></button>":''); + "</td>";
        //-->NJES February/16/2021
        salida += "<td>" + ((existeArchvioBitacora(actual.id_activo,actual.id_bitacora,'evidencia') == 1) ? "<button class='btn btn-primary b_evidencia' alt1='"+actual.id_activo+"' alt2='"+actual.id_bitacora+"' type='button' style='margin:0px;'><i class='fa fa-eye' aria-hidden='true'></i></button>":''); + "</td>";
        salida += "<td>" + ((existeArchvioBitacora(actual.id_activo,actual.id_bitacora,'foto1') == 1) ? "<button class='btn btn-primary b_foto1' alt1='"+actual.id_activo+"' alt2='"+actual.id_bitacora+"' type='button' onclick='' style='margin:0px;'><i class='fa fa-eye' aria-hidden='true'></i></button>":''); + "</td>";
        salida += "<td>" + ((existeArchvioBitacora(actual.id_activo,actual.id_bitacora,'foto2') == 1) ? "<button class='btn btn-primary b_foto2' alt1='"+actual.id_activo+"' alt2='"+actual.id_bitacora+"' type='button' onclick='' style='margin:0px;'><i class='fa fa-eye' aria-hidden='true'></i></button>":''); + "</td>";
        salida += "</tr>";
      }
      $("#t_bitacora_historial").empty();
      $("#t_bitacora_historial").html(salida);
    },
    error: function (data){
      console.log("php/activos_bitacora_filtro.php-->"+JSON.stringify(data));
      mandarMensaje("Error con la Busqueda #06.");
    }
  });
});

$('#b_buscar_empleados').click(function(){
    $('#i_filtro_empleado').val('');
    
    if(($('#s_responsable_unidades').val() != null))
    {
        //muestraModalEmpleadosUnidad('renglon_empleado','t_empleados tbody','dialog_empleados',$('#s_responsable_unidades').val());
        //-->NJES March/30/2020 se envia lista de las sucursales a las que tiene permiso el usuario en el modulo sin importar la unidad seleccionada
        //-->NJES July/23/2020 se agrega parametro modulo si viene del modulo salida de uniformes, sin importar si es administrativo 1 o 2 
        //mostrar todos los empleados sin importar la unidad y sucursal
        buscarEmpleadosIdsSucursales('renglon_empleado','t_empleados tbody','dialog_empleados',muestraSucursalesPermisoUsuarioLista(modulo,idUsuario),modulo);
    }else{
        mandarMensaje('Seleccionar Unidad de Negocio para buscar información');
    }
});

$('#t_empleados').on('click', '.renglon_empleado', function() {
    var id = $(this).attr('alt');
    var nombre = $(this).attr('alt2');
    var numeroEmpleado = $(this).attr('alt3');
    $('#i_empleado').attr('alt',id).val(numeroEmpleado+' - '+nombre);
    $('#i_no_licencia').val(actual.no_licencia);
    $('#i_vigencia_licencia').val(actual.vigencia_licencia);
    $('#dialog_empleados').modal('hide');
});

$(document).on('change','#i_fecha_inicio_h',function(){
  return selectResponsables('TODO');
});

$(document).on('change','#i_fecha_fin_h',function(){
  return selectResponsables('TODO');
});
// Tabla Responsables Select
function selectResponsables(busca){

  $("#t_responsables_activos").empty();
  //--MGFS SE AGREGA CONDICION PARA QUE MUESTRE TODO
  if(busca=='TODO'){
    $('#ch_responsable_mostrar').attr('alt','');
    $('#s_id_unidades').prop('disabled',false);
    $('#i_filtro_1').prop('disabled',false).val('');
    $('#i_filtro_2').prop('disabled',false).val('');
    $('#i_filtro_3').prop('disabled',false).val('');
    $('#i_filtro_4').prop('disabled',false).val('');
    $('#i_filtro_5').prop('disabled',false).val('');
    $('#i_fecha_inicio_h').prop('disabled',false);
    $('#i_fecha_fin_h').prop('disabled',false);
    id = 0;
  }else{
    $('#ch_responsable_mostrar').attr('alt','');
    $('#s_id_unidades').prop('disabled',true);
    $('#i_filtro_1').prop('disabled',true).val('');
    $('#i_filtro_2').prop('disabled',true).val('');
    $('#i_filtro_3').prop('disabled',true).val('');
    $('#i_filtro_4').prop('disabled',true).val('');
    $('#i_filtro_5').prop('disabled',true).val('');
    $('#i_fecha_inicio_h').val('').prop('disabled',true);
    $('#i_fecha_fin_h').val('').prop('disabled',true);
    id = $('#b_guardar_activo').attr('alt');
  }

  $.ajax({
    type: "POST",
    url: "php/activos_responsables.php",
    data: {
      'id':id,
      'fechaInicio': $('#i_fecha_inicio_h').val(),
      'fechaFin': $('#i_fecha_fin_h').val()
    },
    dataType: 'json',
    success: function(data){
    
      respon = "";
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        respon += "<tr class='renglon-bitacora' alt="+actual.id+">";
        respon += "<td>" + actual.razon_social + "</td>";
        respon += "<td>" + actual.sucursal + "</td>";
        respon += "<td>" + actual.areas + "</td>";
        respon += "<td>" + actual.dpto + "</td>";
        respon += "<td class='i_filtro1'>" + actual.id_trabajador + "</td>";
        respon += "<td class='i_filtro2'>" + actual.id_cliente + "</td>";
        respon += "<td class='i_filtro3'>" + actual.responsable + "</td>";
        respon += "<td class='i_filtro4'>" + actual.no_serie + "</td>";
        respon += "<td class='i_filtro5'>" + actual.num_economico + "</td>";
        respon += "<td>" + actual.descripcion + "</td>";
        respon += "<td>" + actual.fecha_inicio + "</td>";
        respon += "<td>" + (actual.fecha_fin=='0000-00-00'? "" : actual.fecha_fin) + "</td>";
        respon += "</tr>";
      }
      $("#t_responsables_activos").empty();
      $("#t_responsables_activos").html(respon);
    },
    error: function (data){
      console.log("php/activos_responsables.php-->"+JSON.stringify(data));
      mandarMensaje("* Error al buscar los activos responsables");
    }
  });
}

// Funcion para reasignar Activo
function responsableReasignar(){
  $("#dialog_bitacora").modal('hide');
  activo = $("#b_guardar_activo").attr('alt');
  if($('#ch_responsable_externo').is(':checked'))
    var responsable_externo = $('#i_empleado').val();
  else
    var responsable_externo = '';

  arregloRes = {
    'unidad' : $("#s_responsable_unidades").val(),
    'sucursal' : $("#s_responsable_sucursales").val(),
    'area' : $("#s_responsable_area").val(),
    'dpto' : $("#s_responsable_dpto").val(),
    'no_empleado' : $("#i_empleado").attr('alt'),
    'vehNoLicencia' : $('#i_no_licencia').val(),
    'vehVigenciaLicencia' : $('#i_vigencia_licencia').val(),
    //'cuip' : $('#i_cuip').val(),
    'cuip' : ($('#i_cuip').val() == null ? '' : $('#i_cuip').val()),
    'responsable_externo' : responsable_externo
  }
  $.ajax({
    type: "POST",
    url: "php/activos_responsable_reasignar.php",
    data: {'activo':activo, 'arregloRes':arregloRes},
    // dataType: 'json',
    success: function(data){
      if (data==1) {
        $('#dialog_responsable').modal('hide');
        imprimirSalidaActivoFijo('R');
        mandarMensaje("Reasignado Correctamente.");
        $('#b_responsable_guardar').prop('disabled',true);
        $('#b_comodato').prop('disabled',true);
        return guardarLicenciaPDF();
      }
      else {
        mandarMensaje("Error al Reasignar.");
      }
      return selectResponsables('');
    },
    error: function (data){
      mandarMensaje("Error al Reasignar, Vuelva a intentarlo.");
    }
  });
};

// Funcion para reasignar Activo
function comodatoReasignar(){
  $("#dialog_bitacora").modal('hide');
  activo = $("#b_guardar_activo").attr('alt');
  arregloRes = {
    'unidad' : $("#s_responsable_unidades_c").val(),
    'sucursal' : $("#s_responsable_sucursales_c").val(),
    'area' : $("#s_responsable_area_c").val(),
    'dpto' : $("#s_responsable_dpto_c").val(),
    'no_cliente' : $("#i_cliente_c").attr('alt')
  }
  $.ajax({
    type: "POST",
    url: "php/activos_responsable_reasignar.php",
    data: {'activo':activo, 'arregloRes':arregloRes},
    // dataType: 'json',
    success: function(data){
      if (data==1) {
        $('#dialog_responsable').modal('hide');
        imprimirSalidaActivoFijo('C');
        mandarMensaje("Reasignado Correctamente.");
        $('#b_comodato_guardar').prop('disabled',true);
        $('#b_responsables').prop('disabled',true);
      }
      else {
        mandarMensaje("Error al Reasignar.");
      }
      return selectResponsables('');
    },
    error: function (data){
      mandarMensaje("Error al Reasignar, Vuelva a intentarlo.");
    }
  });
};

$("#s_id_unidades").change(function(e){
  $("#i_filtro_1").focus();
  $("#i_filtro_1").val("");
  $("#i_filtro_2").val("");
  $("#i_filtro_3").val("");
  $("#i_filtro_4").val("");
  buscarActivosResponsablesFiltros();
});


function buscarActivosResponsablesFiltros(){
  $("#t_responsables_activos > tbody").empty();
  no_empleado = $("#i_filtro_1").val();
  no_cliente = $("#i_filtro_2").val();
  no_serie = $("#i_filtro_3").val();
  unidad = $("#s_id_unidades").val();
  noEconomico = $("#i_filtro_4").val();
  idActivo = $('#b_guardar_activo').attr('alt');

  //-->NJES June/11/2020 se quitan los parametros (no_empleado, no_cliente, no_serie) porque no se estan usando para el query
    //se agregan los filtros de fechas

  $.ajax({
    type: "POST",
    url: "php/activos_responsables_filtro.php",
    data: {'unidad':unidad, 
          'idActivo':idActivo,
          'fechaInicio': $('#i_fecha_inicio_h').val(),
          'fechaFin': $('#i_fecha_fin_h').val()
          },
    dataType: 'json',
    success: function(data){
    
      var respon = "";
      for (var i = 0; i < data.length; i++) {
        actual=data[i];
        respon += "<tr class='renglon-bitacora' alt="+actual.id+">";
        respon += "<td>" + actual.razon_social + "</td>";
        respon += "<td>" + actual.sucursal + "</td>";
        respon += "<td>" + actual.areas + "</td>";
        respon += "<td>" + actual.dpto + "</td>";
        respon += "<td class='i_filtro1'>" + actual.id_trabajador + "</td>";
        respon += "<td class='i_filtro2'>" + actual.id_cliente + "</td>";
        respon += "<td class='i_filtro3'>" + actual.responsable + "</td>";
        respon += "<td class='i_filtro4'>" + actual.no_serie + "</td>";
        respon += "<td class='i_filtro5'>" + actual.num_economico + "</td>";
        respon += "<td>" + actual.descripcion + "</td>";
        respon += "<td>" + actual.fecha_inicio + "</td>";
        respon += "<td>" + (actual.fecha_fin=='0000-00-00'? "" : actual.fecha_fin) + "</td>";
        respon += "</tr>";
      }
      
      $("#t_responsables_activos").html(respon);
    },
    error: function (data){
      console.log(JSON.stringify(data));
      mandarMensaje("Error con la Busqueda #08.");
    }
  });
}

// Chech box Mostrar Todo en Historal de Asignaciones
$( '#ch_responsable_mostrar' ).on( 'click', function() {
  if( $(this).is(':checked')==false){
    $('#i_fecha_inicio_h').val(primerDiaMes);
    $('#i_fecha_fin_h').val(ultimoDiaMes);
    return selectResponsables('');
  } else {

    $('#i_fecha_inicio_h').val(primerDiaMes);
    $('#i_fecha_fin_h').val(ultimoDiaMes);
    
    return selectResponsables('TODO');
  }
});

// Chech box Mostrar Todo en Historal de Bitacora
$( '#ch_bitacora_mostrar' ).on( 'click', function() {
  if( $(this).is(':checked') ){
    
    $('#i_fecha_inicio_b').val(primerDiaMes);
    $('#i_fecha_fin_b').val(ultimoDiaMes);
    return selectBitacora('');

  } else {

    $('#i_fecha_inicio_b').val(primerDiaMes);
    $('#i_fecha_fin_b').val(ultimoDiaMes);
    return selectBitacora('TODO');
    
  }
});

//--MGFS SE QUITA LA FUNCION selectBitacora('') 
//-- return selectBitacora(''), selectResponsables(''), tablaActivosBuscar();
//-- Ya que estaba mostrando los datos en biatcora si haber dado un click en cualqueir requistro
$('#b_buscar_activo').click(function(){
  $("input[type=checkbox]").prop('checked', false);
  //-->NJES April/30/2020 solo si tiene permisos podra ver la opcion armas
  var id_sucursal = buscaIdSucursal(idUnidadActual); 
  if(obtienePermisoArmas(id_sucursal,idUnidadActual) == 1)
    $('#option_armas').css('display','block');
  else
    $('#option_armas').css('display','none');

  //-->NJES May/13/2020 solo si tiene permisos podra ver las opciones vehiculo, celular, equipo de computo, otro
  if(obtienePermisoOpcionesGlobal(id_sucursal,idUnidadActual) == 1)
    $('.options_global').css('display','block');
  else
    $('.options_global').css('display','none');

  $('#i_filtro_busqueda').val(''); 
  
  return tablaActivosBuscar();
});

// Mostrar PDF en Modal
$('#preview_amortizacion').click(function(){
  return amortisazionPDF();
});
function amortisazionPDF(){
    // Concatnar id al nombre con clave ejemplo poliza_20, circulacion_20, amortizacion_20
    $("#div_archivo").empty();
    $("#div_archivo").val('');
    id = $('#b_guardar_activo').attr('alt');

    if (id=='' || id==null) {
      mandarMensaje("No se ah Guardado o Seleccionado un Activo");
    }
    else {
      $("#div_archivo").empty();
      $("#div_archivo").val('');
      var ruta='activosPdf/formato_amortizacion_'+id+'.pdf';
      var fil="<iframe width='100%' height='500px' src='"+ruta+"'>";
      $('#label_pdf').html('Tabla de Amortizacion PDF')

      $.ajax({
        url:ruta,
        type:'HEAD',
        error: function()
        {
          mandarMensaje('Este activo no contiene archivo PDF guardado');
        },
        success: function()
        {
          $("#div_archivo").empty();
          $("#div_archivo").val('');
          $("#div_archivo").append(fil);
          $('#dialog_archivo').modal('show');
        }
      });
    }
}

// Mostrar PDF Poliza en Modal
$('#preview_poliza').click(function(){
  return polizaPDF();
});
function polizaPDF(){
    $("#div_archivo").empty();
    $("#div_archivo").val('');
    id = $('#b_guardar_activo').attr('alt');
    if (id=='' || id==null) {
      mandarMensaje("No se ah Guardado o Seleccionado un Activo");
    }
    else {
      $("#div_archivo").empty();
      $("#div_archivo").val('');
      var ruta='activosPdf/formato_poliza_'+id+'.pdf';
      var fil="<iframe width='100%' height='500px' src='"+ruta+"'>";
      $('#label_pdf').html('Poliza de Seguro PDF')
      $.ajax({
        url:ruta,
        type:'HEAD',
        error: function()
        {
          mandarMensaje('Este activo no contiene archivo PDF guardado');
        },
        success: function()
        {
          $("#div_archivo").empty();
          $("#div_archivo").val('');
          $("#div_archivo").append(fil);
          $('#dialog_archivo').modal('show');
        }
      });
    }
}
// Mostrar PDF Targeta de Circulacion en Modal
$('#preview_circulacion').click(function(){
  return circulacionPDF();
});
function circulacionPDF(){
    // Concatnar id al nombre con clave ejemplo poliza_20, circulacion_20, amortizacion_20
    $("#div_archivo").empty();
    $("#div_archivo").val('');
    id = $('#b_guardar_activo').attr('alt');
    if (id=='' || id==null) {
      mandarMensaje("No se ah Guardado o Seleccionado un Activo");
    }
    else {
      $("#div_archivo").empty();
      $("#div_archivo").val('');
      var ruta='activosPdf/formato_targeta_circulacion_'+id+'.pdf';
      var fil="<iframe width='100%' height='500px' src='"+ruta+"'>";
      $('#label_pdf').html('Targeta de Circulacion PDF')
      $.ajax({
        url:ruta,
        type:'HEAD',
        error: function()
        {
          mandarMensaje('Este activo no contiene archivo PDF guardado');
        },
        success: function()
        {
          $("#div_archivo").empty();
          $("#div_archivo").val('');
          $("#div_archivo").append(fil);
          $('#dialog_archivo').modal('show');
        }
      });
    }
}
// Mostrar PDF Poliza en Modal
$('#preview_licencia').click(function(){
  return licenciaPDF();
});
function licenciaPDF(){
    $("#div_archivo").empty();
    $("#div_archivo").val('');
    id = $('#b_guardar_activo').attr('alt');
    if (id=='' || id==null) {
      mandarMensaje("No se ah Guardado o Seleccionado un Activo");
    }
    else {
      $("#div_archivo").empty();
      $("#div_archivo").val('');
      var ruta='activosPdf/formato_licencia_'+id+'.pdf';
      var fil="<iframe width='100%' height='500px' src='"+ruta+"'>";
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
          $("#div_archivo").empty();
          $("#div_archivo").val('');
          $("#div_archivo").append(fil);
          $('#dialog_archivo').modal('show');
        }
      });
    }
}


// Guardar PDF
function guardarAmortisazionPDF(){
  var form = $('#forma_generales');
  var file2 = $('#i_amortizacion');

  var archivo = file2[0].files;
  var formData = new FormData(form[0]);
  formData.append('archivo',archivo);
  jQuery.ajax({
    url: 'php/activos_guardar_pdf_amortizacion.php',
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    type: 'POST',
    success: function(data){
      if (data == 0) {
        console.log("Format Add");
      }
      else {
        console.log("E:"+data);
      }
    },
    error: function(data){
      mandarMensaje("Error al Subir el archivo");
    }
  });
}
// Guardar PDF Poliza Vehiculos
function guardarPolizaPDF(){
  var form = $('#forma_vehiculo');
  var file2 = $('#i_veh_poliza');

  var archivo = file2[0].files;
  var formData = new FormData(form[0]);
  formData.append('archivo',archivo);
  jQuery.ajax({
    url: 'php/activos_guardar_pdf_poliza.php',
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    type: 'POST',
    success: function(data){
      if (data == 0) {
        console.log("Format Add");
      }
      else {
        console.log("E:"+data);
      }

    },
    error: function(data){
      mandarMensaje("Error al Subir el archivo");
    }
  });
}
// Guardar PDF T. Circulacion Vehiculos
function guardarTargetaCirculacionPDF(){
  var form = $('#forma_vehiculo');
  var file2 = $('#i_veh_circulacion');

  var archivo = file2[0].files;
  var formData = new FormData(form[0]);
  formData.append('archivo',archivo);
  // mandarMensaje(formData);
  jQuery.ajax({
    url: 'php/activos_guardar_pdf_targetacirculacion.php',
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    type: 'POST',
    success: function(data){
      if (data == 0) {
        console.log("Format Add");
      }
      else {
        console.log("E:"+data);
      }
    },
    error: function(data){
      mandarMensaje("Error al Subir el archivo");
    }
  });
}

$('#b__archivo_info').click(function(){
  mandarMensaje("<h5>Deshabilitar Cache:</h5> <br> <h8> 1. Click Derecho sobre cualquier parte del Sistema y Abrir 'Inspeccionar' <br> 2. Ir a la pestaña Network en la ventana que se abrio <br> 3. Marcar la casilla 'Disable Cache' y cerrar la ventana <br> 4. Recargar la pagina y seleccionar el activo.</h8>");
});


function dictamenPDF(){
    // Concatenar id al nombre con clave ejemplo poliza_20, circulacion_20, amortizacion_20
    $("#div_archivo").empty();
    $("#div_archivo").val('');

    var ruta='activosPdf/formato_dictamen_seguro_'+id+'.pdf';
    var fil="<iframe width='100%' height='500px' src='"+ruta+"'>";
    $('#label_pdf').html('Dictamen de Seguro PDF')
    $.ajax({
      url:ruta,
      type:'HEAD',
      error: function()
      {
        mandarMensaje('Este activo no contiene archivo PDF guardado');
      },
      success: function()
      {
        $("#div_archivo").empty();
        $("#div_archivo").val('');
        $("#div_archivo").append(fil);
        $('#dialog_archivo').modal('show');
      }
    });
}

$('#s_bitacora_tipo_modal').change(function(){
  $( "#i_kilometraje" ).val('');
  $( "#div_kilometraje" ).hide();
  tipo = $("#s_bitacora_tipo_modal").val();
  if (tipo=='Siniestro') {
    $( "#i_dictamen" ).show();
  }else if(tipo=='Mantenimiento'){
    $( "#i_dictamen" ).hide();
    $( "#div_kilometraje" ).show();
  }else{
    $( "#i_dictamen" ).hide();
  }
});

function guardarDictamenPDF(){
  var form = $('#forma_bitacora');
  var file2 = $('#i_dictamen');

  var archivo = file2[0].files;
  var formData = new FormData(form[0]);
  formData.append('archivo',archivo);
  // mandarMensaje(formData);
  jQuery.ajax({
    url: 'php/activos_guardar_pdf_dictamen.php',
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    type: 'POST',
    success: function(data){
      console.log(data);
    },
    error: function(data){
      mandarMensaje("Error al Subir el archivo");
    }
  });
}

//-->NJES February/16/2021 agregar archivos evidencia, foto 1 y foto 2 (campos obligatorios)
function guardarArchivosBitacora(id_bitacora_activo){
  
  var file1 = document.getElementById("i_evidencia_bitacora");
  var file2 = document.getElementById("i_foto_1_bitacora");
  var file3 = document.getElementById("i_foto_2_bitacora");

  var evidencia = file1.files;
  var foto1 = file2.files;
  var foto2 = file3.files;

  var formData = new FormData();
  formData.append('evidencia',evidencia[0]);
  formData.append('foto1',foto1[0]);
  formData.append('foto2',foto2[0]);
  formData.append('id_bitacora_activo',id_bitacora_activo);
  
  jQuery.ajax({
    url: 'php/activos_guardar_archivos_bitacora.php',
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    type: 'POST',
    success: function(data){
      console.log(' activos_guardar_archivos_bitacora: '+data);
      $('#i_evidencia_bitacora').val('');
      $('#i_foto_1_bitacora').val('');
      $('#i_foto_2_bitacora').val('');
    },
    error: function(data){
      mandarMensaje("Error al subir archivos bitácora");
    }
  });
}

function guardarLicenciaPDF(){

  var form = $('#forma_responsable');
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


$('#b_buscar_recepcion').on('click',function(){
  
   buscaRecepcion();

});


/*$(document).on('change','#s_propietario',function(){
  var idUnidad = $(this).val();
  muestraSucursalesPermiso('s_filtro_sucursal',idUnidad,modulo,idUsuario);
});*/
//$('#b_buscar_recepcion').prop('disabled',true);
//-->NJES Feb/10/2020 se comenta porque ya no existe el elemento en html
/*$(document).on('change','#s_filtro_sucursal',function(){
  $('#b_buscar_recepcion').prop('disabled',false);
  $('#i_folio_recepcion').val('').attr('idS10',0).attr('alt',0).attr('alt2',0).attr('alt3',0);
});*/

muestraSelectEF('s_propietario');
function muestraSelectEF(select)
{

    $("#"+select).html('');
    
    $.ajax({

        type: 'POST',
        url: 'php/combos_buscar.php',
        dataType:"json", 
        data:{

            'tipoSelect' : 'EMPRESAS_FISCALES'

        },
        success: function(data) {
          var datos = data;
            if(datos.length > 0)
            {
                var html='';
                html='<option value="" selected disabled >Selecciona</option>';
                
                for (i = 0; i < datos.length; i++) {
                    html+='<option value="'+datos[i].id_empresa+'" >'+datos[i].razon_social+'</option>';     
                }
                $("#"+select).html(html);
            }
            
        },
        error: function (xhr) {
            console.log("muestraSelectTodasUnidades: "+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información en cat_unidades negocio');
        }
 });
}


  function buscaRecepcion(){

    $('#i_filtro_recepcion').val('');
    $('.renglon_recepcion').remove();

      /*if($('#s_filtro_sucursal').val()>0)
      {*/
   
      $.ajax({
        type: "POST",
        url: "php/almacen_buscar_folios_activos_fijos.php",
        data:{
          'idSucursal': 0//$('#s_filtro_sucursal').val()
        },
        dataType: 'json',
        success: function(data){


          if(parseInt(data.length)>0){
            var html ='';
            for (var i = 0; i < data.length; i++) {
              var actual=data[i];
              //-->NJES Feb/10/2020 se agregan atributos para poder tomar la sucursal y familia gasto
              var radio="<input type='radio' id='r_"+actual.id_d+"' name='r_recepcion'  alt='"+actual.folio+"' alt2='"+actual.id_e+"' alt3='"+actual.id_d+"' alt4='"+actual.id_unidad_negocio+"' sucursal='"+actual.id_sucursal+"' familia_gasto='"+actual.id_familia_gasto+"'>";

              html += "<tr class='renglon_recepcion' alt='"+actual.id_d+"' alt2='"+actual.folio+"'>";
              html += "<td>" + actual.sucursal + "</td>";
              html += "<td>" + actual.folio + "</td>";
              html += "<td>" + actual.partida + "</td>";
              html += "<td>" + actual.id_producto + "</td>";
              html += "<td>" + actual.familia + "</td>";
              html += "<td>" + actual.linea + "</td>";
              html += "<td>" + actual.concepto + "</td>";
              html += "<td>" + actual.descripcion + "</td>";
              html += "<td>" + actual.cantidad + "</td>";
              html += "<td>" + radio + "</td>";
              html += "</tr>";
            }

            $("#t_recepcion > tbody").empty();
            $("#t_recepcion > tbody").html(html);

            $('#dialog_recepcion').modal('show');

          }
          else{
            mandarMensaje('No se Encontraron Folios de Recepción Disponibles');
          }
        },
        error: function (data){
          console.log("php/almacen_buscar_folios_activos_fijos.php-->"+ JSON.stringify(data));
          mandarMensaje("* Error con la Busqueda de Folios de Recepción.");
        }
      });
    /*}
    else{
      mandarMensaje('Debes ingresar una sucursal, para realizar la búsqueda');
    }*/
  }

  $(document).on('click','input[name=r_recepcion]',function(){
    var folio = $(this).attr('alt');
    var idAlmacenE = $(this).attr('alt2');
    var idAlmacenD = $(this).attr('alt3');
    var idUnidadNegocio = $(this).attr('alt4');
    //-->NJES Feb/10/2020 se toma el id familia gasto de la familia del producto para guardarlo al hacer el movimiento presupuesto
    var idFamiliaGasto = $(this).attr('familia_gasto');
    var idSucursal = $(this).attr('sucursal');
   
    $('#i_folio_recepcion').val(folio).attr('alt',idAlmacenE).attr('alt2',idAlmacenD).attr('alt3',idUnidadNegocio).attr('familia_gasto',idFamiliaGasto).attr('sucursal',idSucursal);
  });



$('#b_imprimir_salida').click(function(){
  imprimirSalidaActivoFijo('R');
});

$('#b_imprimir_salida_comodato').click(function(){
  imprimirSalidaActivoFijo('C');
});

function imprimirSalidaActivoFijo(tipo){
  var idRegistro = $('#i_folio_recepcion').attr('idS10');
      //-->NJES May/13/2020 si es activo de tipo armas generar un pdf diferente
      if($('input[name="r_tipo"]:checked').val() == 5)
      {
        var datos = {
            'path':'formato_activo_fijo_armas_salida',
            'idRegistro':$("#b_guardar_activo").attr('alt'),
            'nombreArchivo':'salidaporresponsiva',
            'tipo':1,
            'formatoAr':tipo
        };

        console.log(JSON.stringify(datos));

        let objJsonStr = JSON.stringify(datos);
        let datosJ = datosUrl(objJsonStr);

        window.open("php/convierte_pdf.php?D="+datosJ,'_new');
      }else{
        if(idRegistro>0){
            var datos = {
                'path':'formato_activo_fijo_salida',
                'idRegistro':idRegistro,
                'nombreArchivo':'salidaporresponsiva',
                'tipo':1,
                'formatoAr':tipo
                //'tipoActivo':$('input[name="r_tipo"]:checked').val()
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_new');
        }else
        {

            console.log(' imprimirSalidaActivoFijo* ' + $("#b_guardar_activo").attr('alt') );
            //mandarMensaje('El Activo no cuenta con Entrada de Almacen');
            // editando

            var datos = {
                'path':'formato_activo_fijo_s',
                'id': $("#b_guardar_activo").attr('alt') ,
                'nombreArchivo':'responsiva_activos',
                'tipo':1,
                'formatoAr':tipo
                //'tipoActivo':$('input[name="r_tipo"]:checked').val()
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_new');

        }
      }
}



  function imprimirDevolucion(tipoR){

    var idRegistro = $('#i_folio_recepcion').attr('idS10');
    if(idRegistro>0){

      if(tipoR=='R'){
        var datos = {
            'path':'formato_activo_fijo_devolucion',
            'idRegistro':idRegistro,
            'nombreArchivo':'entradapordevolucionderesponsiva',
            'concepto':'ENTRADA POR DEVOLUCIÓN DE RESPONSIVA',
            'tipo':1
        };

      }else{

        var datos = {
            'path':'formato_activo_fijo_devolucion',
            'idRegistro':idRegistro,
            'nombreArchivo':'entradapordevoluciondecomodato',
            'concepto':'ENTRADA POR DEVOLUCIÓN DE COMODATO',
            'tipo':1
        };

      }
            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_new');
    }else{
         // mandarMensaje('El Activo no cuenta con Entrada de Almacen');
       var datos = {
              'path':'formato_activo_fijo_s',
              'id': $("#b_guardar_activo").attr('alt') ,
              'nombreArchivo':'responsiva',
              'tipo':1
          };

          let objJsonStr = JSON.stringify(datos);
          let datosJ = datosUrl(objJsonStr);

          window.open("php/convierte_pdf.php?D="+datosJ,'_new');
    }

  }




  $(document).on('click','#b_buscar_clientes',function(){
    muestraRazonesSocialesUnidadSucursal('renglon_razones_sociales','t_razones_sociales','dialog_razones_sociales',$('#s_responsable_unidades_c').val(),$('#s_responsable_sucursales_c').val())
  });

  $('#t_razones_sociales').on('click', '.renglon_razones_sociales', function(){
    var idRazonSocial = $(this).attr('alt');
    var razonSocial = $(this).attr('alt2');

    $('#i_cliente_c').val(razonSocial).attr('alt',idRazonSocial);
    $('#dialog_razones_sociales').modal('hide');
  
  });

  //---MGFS 17-12-2019 SE AGREGA LA BUSUQEDA DE REQUISICIONES DE GASTOS PARA RELACIONAR EL GASTO
  $('#b_buscar').click(function(){
      muestraSelectUnidades(matriz, 's_filtro_unidad', idUnidadActual);
      //-->NJES Feb/10/2020 se comenta porque ya no existe el elemento en html
      //muestraSucursalesPermiso('s_filtro_sucursal',idUnidadActual,modulo,idUsuario);
      $('#i_filtro_1').val('');
      $('#i_fecha_inicio').val('');
      $('#i_fecha_fin').val('');
      $('.requisicion-busqueda').remove();
      $('#dialog_buscar_requisiciones').modal('show');
  });

  
  $(document).on('change','#s_filtro_unidad',function(){

    var idUnidad=$(this).val();
    if(idUnidad!= ''){
        $('.img-flag').css({'width':'50px','height':'20px'});
    }
    //-->NJES Feb/10/2020 se comenta porque ya no existe el elemento en html
    //muestraSucursalesPermiso('s_filtro_sucursal',idUnidad,modulo,idUsuario);
    $('#i_filtro_requisiciones').val('');
    $('#i_fecha_inicio').val('');
    $('#i_fecha_fin').val('');
    $('.requisicion-busqueda').remove();
      
  });

    

  /*$(document).on('change', '#s_filtro_sucursal',function(){
      buscarRequisicion();
  });*/

  $('#i_fecha_inicio').change(function(){

      if($('#i_fecha_inicio').val() != '')
      {
          $('#i_fecha_fin').prop('disabled',false);
          buscarRequisicion();
      }

  });

  $('#i_fecha_fin').change(function(){  

    //-->NJES Feb/10/2020 se comenta porque ya no existe el elemento en html
      /*if($('#s_filtro_sucursal').val()>0){
          buscarRequisicion();
      }*/
      
  });

  function buscarRequisicion(){

    $('.requisicion-busqueda').remove();

    $.ajax({
        type: 'POST',
        url: 'php/requisiciones_buscar_todas.php',
        dataType:"json", 
        data:{
            'mantenimiento':0,
            'idUnidadNegocio':$('#s_filtro_unidad').val(),
            //-->NJES Feb/10/2020 se comenta porque ya no existe el elemento en html
            //'idSucursal':$('#s_filtro_sucursal').val(),
            'fecha_de':$('#i_fecha_inicio').val(),
            'fecha_a':$('#i_fecha_fin').val()
        },
        success: function(data){
            
            for(var i=0; data.length>i; i++){

                var requisicion = data[i];

                var estatus = 'Pendiente';

                if(requisicion.estatus == 2)
                    estatus = 'Autorizada';

                if(requisicion.estatus == 3)
                    estatus = 'No autorizada';

                if(requisicion.estatus == 4)
                    estatus = 'Orden de Compra';

                if(requisicion.estatus == 5)
                    estatus = 'Por Pagar';

                if(requisicion.estatus == 6)
                    estatus = 'Pagada';

                if(requisicion.estatus == 7)
                    estatus = 'Cancelada';

                var html = "<tr class='requisicion-busqueda' alt='" + requisicion.id + "'>";
                html += "<td>" + requisicion.folio + "</td>";
                html += "<td>" + requisicion.unidad + "</td>";
                html += "<td>" + requisicion.sucursal + "</td>";
                html += "<td>" + requisicion.are + "</td>";
                html += "<td>" + requisicion.depto + "</td>";
                html += "<td>" + estatus + "</td>";
                html += "</tr>";

                $('#t_requisiciones_b tbody').append(html);
            
            }
        
  
        },
        error: function (xhr)
        {
            console.log('php/requisiciones_buscar_todas.php->'+JSON.stringify(xhr));
            mandarMensaje('Ocurrio un error al buscar la requisiciones');
        }
    });

  }

       

        
  $("#t_requisiciones_b").on('click',".requisicion-busqueda",function(){
      var idR = $(this).attr('alt');
      $.ajax({
          type: 'POST',
          url: 'php/requisiciones_buscar_todas.php',
          dataType:"json", 
          data:{
              'mantenimiento':0,
              'id': idR
          },
          success: function(data)
          {
      
              for(var i=0; data.length>i; i++)
              {

                  var requisicion = data[i];
                  id = requisicion.id;
                  idUnidad = requisicion.id_unidad_negocio;
                  idSucursal = requisicion.id_sucursal;
                  idArea = requisicion.id_area;
                  idDepartamento = requisicion.id_departamento;

                  nombreProveedor = requisicion.nombre_proveedor;

                  $('#i_id_requisicion').val(requisicion.id);


                  limpiarCombos();

                  $('#s_id_unidad').val(idUnidad);
                  $("#s_id_unidad").select2({
                      templateResult: setCurrency,
                      templateSelection: setCurrency
                  });
                  $('.img-flag').css({'width':'50px','height':'20px'}); //Cambia el tamaño de la imagen que se mostrara en el selectB

                  optionSurucursal = new Option(requisicion.sucursal, requisicion.id_sucursal, true, true);
                  $('#s_id_sucursal').append(optionSurucursal).trigger('change');

                  optionArea = new Option(requisicion.are, requisicion.id_area, true, true);
                  $('#s_id_area').append(optionArea).trigger('change');

                  optionDepto = new Option(requisicion.depto, requisicion.id_departamento, true, true);
                  $('#s_id_departamento').append(optionDepto).trigger('change');

                  $("#s_id_unidad").prop("disabled", true)
                  $("#s_id_sucursal").prop("disabled", true)
                  $("#s_id_area").prop("disabled", true)
                  $("#s_id_departamento").prop("disabled", true)


                  $('#i_subtotal').val(formatearNumero(requisicion.subtotal));
                  $('#i_total_iva').val(formatearNumero(requisicion.iva));
                  $('#i_total').val(formatearNumero(requisicion.total));

                  $('#i_folio').val(requisicion.folio);
                  $('#i_fecha_pedido').val(requisicion.fecha_pedido);
                  $('#i_solicito').val(requisicion.solicito);
                  $('#i_dias').val(requisicion.tiempo_entrega);
                  $('#i_id_usuario').val(requisicion.id_capturo);
                  $('#i_capturo').val(requisicion.capturo);
                  $('#ta_descripcion').val(requisicion.descripcion);
                  $('#i_orden_compra').val(requisicion.folio_orden_compra);

                  $('#i_proveedor').attr('alt', requisicion.id_proveedor).val(requisicion.proveedor);

                  $('#d_estatus').removeAttr('class');
                  $('#d_estatus').text('').removeAttr('class');

                  // 1 = Pendiente, 2 = Autorizadar, 3 = NO autorizada, 4 = Orden de compra, 5 = Por Pagar, 6 =  Pagada
                  if(requisicion.estatus == 1)
                  {
                      $('#b_cancelar').prop('disabled', false);
                      $('#d_estatus').addClass('alert alert-sm alert-info').text('PENDIENTE');
                      $('#b_guardar').prop('disabled', false);
                      $('#b_imprimir').prop('disabled', false);
                  }
                  
                  if(requisicion.estatus == 2)
                  {
                      $('#d_estatus').addClass('alert alert-sm alert-success').text('AUTORIZADA');
                  }
                  if(requisicion.estatus == 3)
                  {
                      $('#d_estatus').addClass('alert alert-sm alert-danger').text('NO AUTORIZADA');
                  }
                  if(requisicion.estatus == 4)
                  {
                      $('#d_estatus').addClass('alert alert-sm alert-info').text('ORDENADA');
                  }
                  if(requisicion.estatus == 5)
                  {
                      $('#d_estatus').addClass('alert alert-sm alert-default').text('POR PAGAR');
                  }
                  if(requisicion.estatus == 6)
                  {
                      $('#d_estatus').addClass('alert alert-sm alert-success').text('PAGADA');
                  }

                  if(requisicion.estatus == 7)
                  {
                      $('#b_cancelar').prop('disabled', true);
                      $('#b_guardar').prop('disabled', true);
                      $('#b_imprimir').prop('disabled', true);
                      $('#d_estatus').addClass('alert alert-sm alert-danger').text('CANCELADA');
                  }

                  
                  if(requisicion.tipo == 0)
                      $('#r_activo').prop('checked',true);
                  else if(requisicion.tipo == 1)
                      $('#r_gasto').prop('checked',true);    
                  else if(requisicion.tipo == 2)
                      $('#r_mantenimiento').prop('checked',true);
                  else
                      $('#r_stock').prop('checked',true);

                  $('#t_partidas >tbody tr').remove();
                  $.ajax({
                      type: 'POST',
                      url: 'php/requisiciones_buscar_detalles_modificacion.php',
                      dataType:"json", 
                      data:{
                          'id':requisicion.id
                      },
                      success: function(data)
                      {
                          
                          totalPartidas = 0;
                          //var data = JSON.parse(data);
                          for(var i=0; data.length>i; i++)
                          {

                              var detalle = data[i];

                              totalPartidas++;
                              
                              var classExcede='';
                              if(parseInt(detalle.excede_presupuesto)==1){
                                  classExcede='excede';
                              }

                              var html = "<tr class='partida-requisicion "+classExcede+"' excedePresupuesto='"+detalle.excede_presupuesto+"' alt='" + totalPartidas +  "' producto='" + detalle.id_producto + "' concepto='" + detalle.concepto+ "' id_familia='" + detalle.id_familia + "' familia='" + detalle.familia + "' id_linea='" + detalle.id_linea + "' linea='" + detalle.linea + "' precio='" + detalle.costo_unitario + "' cantidad='" +  detalle.cantidad + "' costo='" + redondear(parseFloat(detalle.costo_unitario) * parseFloat(detalle.cantidad)) + "' descripcion='" + detalle.descripcion + "' justificacion='" + detalle.justificacion + "' iva='" + detalle.porcentaje_iva + "' >";
                              html += "<td>" + detalle.familia + "</td>";
                              html += "<td>" + detalle.linea + "</td>";
                              html += "<td>" + detalle.concepto + "</td>";
                              html += "<td>" + detalle.descripcion + "</td>";
                              html += "<td align='right'>" + detalle.cantidad + "</td>";
                              html += "<td align='right'>" + formatearNumero(detalle.costo_unitario) + "</td>";
                              html += "<td align='right'>" + detalle.porcentaje_iva + "</td>";
                              html += "<td align='right'>" + formatearNumero(parseFloat(detalle.costo_unitario) * parseFloat(detalle.cantidad)) + "</td>";
                              
                              html += "<td>" + detalle.justificacion + "</td>";

                              var botonTalla = '';
                              if(parseInt(detalle.verifica_talla) == 1)
                              {

                                  botonTalla = "<button type='button' class='btn btn-success btn-sm form-control' id='b_talla' alt='" + detalle.id_producto + "'  alt2='" + detalle.cantidad + "'  alt3='" + totalPartidas + "' ><i class='fa fa-list' aria-hidden='true'></i></button><input  class='tallas-i' type='hidden' id='i_talla" + totalPartidas + "'  name='i_talla" + totalPartidas + "' value='" + detalle.tallas + "'>";

                              }

                              html += "<td>" + botonTalla + "</td>";

                              html += "<td><button type='button' class='btn btn-danger btn-sm form-control' id='b_eliminar' alt='" + detalle.id_producto + "'><i class='fa fa-remove' aria-hidden='true'></i></button></td>";

                              html += "</tr>";

                              $('#t_partidas tbody').append(html);

                              totalPartidas++;
                          
                          }

                
                      },
                      error: function (xhr)
                      {
                          mandarMensaje(xhr.responseText);
                      }
                  });

              }              

              $('#dialog_buscar_requisiciones').modal('hide');
    
          },
          error: function (xhr)
          {
              mandarMensaje('ERROR');
          }

      });

      
  });
  

  //-->NJES May/15/2020 para alarmas se puede asignar a un responsable externo de la empresa
  $('#ch_responsable_externo').click(function(){
    if($('#ch_responsable_externo').is(':checked'))
    {
      $('#i_empleado').prop('readonly',false).val('').attr('alt',0);
      $('#div_boton_busca_resp').css('display','none');
    }else{
      $('#i_empleado').prop('readonly',true);
      $('#div_boton_busca_resp').css('display','block');
    }
  });

  //-->NJES December/17/2020 inactivar activo y solicitar fecha bala obligatoria cuando se inactiva
  $('#ch_inactivo').change(function(){
    if($('#ch_inactivo').is(':checked'))
    {
      $('#label_fecha_baja').removeClass('requerido').addClass('requerido');
      $('#i_fecha_baja').val('').prop('disabled',false).removeClass('validate[required]').addClass('validate[required]');
    }else{
      if(($('#b_guardar_activo').attr('alt') > 0 || $('#b_guardar_activo').attr('alt') != '' || $('#b_guardar_activo').attr('alt') != null) && validarEstatus() == 1)
      {
        $('#ch_inactivo').prop('checked',true);
        solicitarReactivar();
      }else{
        $('#i_fecha_baja').val('').prop('disabled',true).removeClass('validate[required]');
        $('#label_fecha_baja').removeClass('requerido');
      }
    }
  });

  function validarEstatus(){
    var dato = 0;

    $.ajax({
      type: 'POST',
      url: 'php/activos_verificar_estatus.php',
      //dataType:"json", 
      data:{
          'id': $('#b_guardar_activo').attr('alt')
      },
      async: false,
      success: function(data)
      {
        dato = data;
      },
      error: function (xhr)
        {
          console.log('php/activos_verificar_estatus.php-->'+xhr.responseText);
          mandarMensaje('*Error al verificar estatus del activo');
        }
    });

    return dato;
  }

  function solicitarReactivar(){
    $.ajax({
      type: 'POST',
      url: 'php/activos_solicitar_reactivar.php',
      //dataType:"json", 
      data:{
          'id': $('#b_guardar_activo').attr('alt')
      },
      success: function(data)
      {
        if(data > 0)
        {
          mandarMensaje('El activo se reactivará una vez que sea validado por contraloría');
          $('#ch_inactivo').prop('disabled',true);
          $('#label_reactivar').text('Solicitud en proceso para reactivar activo').removeClass('badge badge-warning').addClass('badge badge-warning');
        }else{
          mandarMensaje('Error al solicitar reactivación de activo');
          $('#ch_inactivo').prop('disabled',false);
          $('#label_reactivar').text('').removeClass('badge badge-warning');
        }
      },
      error: function (xhr)
        {
          console.log('php/activos_solicitar_reactivar.php-->'+xhr.responseText);
          mandarMensaje('*Error al solicitar reactivación de activo');
        }
    });
  }

  //-->NJES January/07/2020
  function guardarResponsivaFirmadaPDF(input,boton){
    //alert(input+' , '+boton);
    var archivoPDF = document.getElementById(input);
    var i_pdf = archivoPDF.files; 

    var datos = new FormData();
    datos.append('pdf',i_pdf[0]);

    var ficheroPDF = $('#'+input).val();   
    var extPDF = ficheroPDF.split('.');
    extPDF = extPDF[extPDF.length -1];

    var verificaExtenciones=esPDFXML(extPDF);
          
    if(verificaExtenciones == 0)
    {
      var fileSize = document.getElementById(input).files;

			if(fileSize[0].size <= 2000000)
			{
        jQuery.ajax({
          url: 'php/activos_guardar_pdf_responsiva_firmada.php',
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          type: 'POST',
          success: function(data){
            console.log('data firmada: '+data);
            if(data == 1) 
            {
              $('#'+boton).prop('disabled',false);
            }else{
              mandarMensaje("No se subio el archivo formato responsiva firmada");
              $('#'+boton).prop('disabled',true);
            }

          },
          error: function(data){
            mandarMensaje("Error al Subir el archivo formato responsiva firmada");
            $('#'+boton).prop('disabled',true);
          }
        });
      }else{
				mandarMensaje("No se guardo el archivo salida por responsiva firmada porque el tamaño maximo es de 2 Mb");
			}
    }else{
      mandarMensaje('No se guardo el archivo salida por responsiva firmada porque el archivo no es pdf.');
    }
  }

  function esPDFXML(extPDF){
    var esPDF = extPDF.toLowerCase();
    var extenciones=0;

    if(esPDF!='' && esPDF!='pdf'){
        extenciones = 1;
    }
    
    return extenciones;
  }

$('#preview_i_veh_responsiva_firmada').click(function(){
  return muestraResponsivaFirmadaPDF();
});

$('#preview_i_cel_responsiva_firmada').click(function(){
  return muestraResponsivaFirmadaPDF();
});

$('#preview_i_eq_responsiva_firmada').click(function(){
  return muestraResponsivaFirmadaPDF();
});

$('#preview_i_armas_responsiva_firmada').click(function(){
  return muestraResponsivaFirmadaPDF();
});

function muestraResponsivaFirmadaPDF(){
    $("#div_archivo").empty();
    $("#div_archivo").html('');
    id = $('#b_guardar_activo').attr('alt');
    var ruta = '';
   
    ruta='activosResponsivaFirmada/responsiva_firmada_'+id+'.pdf';
    var fil="<iframe width='100%' height='500px' src='"+ruta+"'>";
    $('#label_pdf').html('Salida por Responsiva Firmada')
    
    $("#div_archivo").empty();
    $("#div_archivo").html('');
    $("#div_archivo").append(fil);
    $('#dialog_archivo').modal('show');
}

function existeArchvioResponsivaFirmada(id){
  var dato = 0;

  $.ajax({
      type: 'POST',
      url: 'php/activos_verificar_existe_responsiva_firmada.php',
      //dataType:"json", 
      data:{
          'id': id
      },
      async: false,
      success: function(data)
      {
        dato = data;
      },
      error: function (xhr)
        {
          console.log('php/activos_verificar_existe_responsiva_firmada.php-->'+xhr.responseText);
          mandarMensaje('*Error al verificar si existe archivo salida por responsiva firmada');
        }
    });

    return dato;
}

function existeArchvioBitacora(id_activo,id_bitacora,tipo){
  var dato = 0;

  $.ajax({
      type: 'POST',
      url: 'php/activos_verificar_existe_archivo_bitacora.php',
      data:{
        'id_activo' : id_activo,
        'id_bitacora': id_bitacora,
        'tipo' : tipo
      },
      async: false,
      success: function(data)
      {
        dato = data;
      },
      error: function (xhr)
        {
          console.log('php/activos_verificar_existe_responsiva_firmada.php-->'+xhr.responseText);
          mandarMensaje('*Error al verificar si existe archivo '+ tipo);
        }
    });

    return dato;
}

function verArchivoBitacora(id_activo,id_bitacora,tipo){
    $("#div_archivo").empty();
    $("#div_archivo").val('');

    if(tipo == 'evidencia')
    {
      var ruta='activosBitacoraEvidencia/formato_evidencia_'+id_activo+'_'+id_bitacora+'.pdf';
      $('#label_pdf').html('Evidencia PDF');
      var fil="<iframe width='100%' height='500px' src='"+ruta+"'>";
    }
    
    if(tipo == 'foto1')
    {
      var ruta='activosBitacoraFoto1/formato_foto1_'+id_activo+'_'+id_bitacora+'.jpg';
      $('#label_pdf').html('Foto 1');
      var fil="<iframe width='80%' height='400px' src='"+ruta+"'>";
    }

    if(tipo == 'foto2')
    {
      var ruta='activosBitacoraFoto2/formato_foto2_'+id_activo+'_'+id_bitacora+'.jpg';
      $('#label_pdf').html('Foto 2');
      var fil="<iframe width='80%' height='400px' src='"+ruta+"'>";
    }
    
    $.ajax({
      url:ruta,
      type:'HEAD',
      error: function()
      {
        mandarMensaje('No existe archivo');
      },
      success: function()
      {
        $("#div_archivo").empty();
        $("#div_archivo").val('');
        $("#div_archivo").append(fil);
        $('#dialog_archivo').modal('show');
      }
    });
}

$(document).on('click','.b_evidencia',function(){
  var id_activo = $(this).attr('alt1');
  var id_bitacora = $(this).attr('alt2');

  verArchivoBitacora(id_activo,id_bitacora,'evidencia');
});

$(document).on('click','.b_foto1',function(){
  var id_activo = $(this).attr('alt1');
  var id_bitacora = $(this).attr('alt2');

  verArchivoBitacora(id_activo,id_bitacora,'foto1');
});

$(document).on('click','.b_foto2',function(){
  var id_activo = $(this).attr('alt1');
  var id_bitacora = $(this).attr('alt2');

  verArchivoBitacora(id_activo,id_bitacora,'foto2');
});

</script>
</html>
