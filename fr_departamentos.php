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
    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Departamentos</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-5"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_nuevo"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_buscar"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-1"><input id="i_id_sucursal" type="hidden"/></div>
                    <div class="col-sm-12 col-md-10">
                        <form id="forma" name="forma">
                            <div class="form-group row">
                                <label for="i_id_departamento" class="col-sm-2 col-md-2 col-form-label ">ID </label>
                                <div class="col-sm-12 col-md-3">
                                    <input type="text" class="form-control"  id="i_id_departamento" autocomplete="off" disabled="disabled">
                                </div>
                                <div class="col-sm-12 col-md-2"></div>
                                <label for="s_id_unidades" class="col-sm-2 col-md-1 col-form-label requerido">Unidad </label>
                                <div class="col-sm-12 col-md-4">
                                <div class="row">
                                     <div class="col-sm-12 col-md-12">
                                        <select id="s_id_unidades" name="s_id_unidades" class="form-control validate[required]"  autocomplete="off"></select>
                                    </div>
                                </div>
                            </div>
                            </div>
                           <div class="form-group row">
                                <label for="i_clave" class="col-sm-2 col-md-2 col-form-label requerido">Clave </label>
                                <div class="col-sm-12 col-md-3">
                                    <input type="text" class="form-control validate[required minSize[1]]" id="i_clave" disabled="disabled" autocomplete="off">
                                </div>
                                <div class="col-sm-12 col-md-2"></div>
                                <label for="s_id_sucursales" class="col-sm-2 col-md-1 col-form-label requerido">Sucursal </label>
            
                                <div class="col-sm-12 col-md-4">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <select id="s_id_sucursales" name="s_id_sucursales" class="form-control validate[required]" autocomplete="off"></select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="i_descripcion" class="col-2 col-md-2 col-form-label requerido">Descripción </label><br>
                                <div class="col-sm-12 col-md-5">
                                    <input type="text" class="form-control validate[required]" id="i_descripcion" autocomplete="off">
                                </div>
                                
                                <label for="s_id_area" class="col-sm-2 col-md-1 col-form-label requerido">Área </label>
                                        
                                <div class="col-sm-12 col-md-4">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <select id="s_id_area" name="s_id_area" disabled class="form-control form-control-sm validate[required]" autocomplete="off"></select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 col-md-2"></div>
                                <div class="col-sm-12 col-md-5">
                                    <div class="row">
                                    Operativo 
                                        <div class="col-sm-12 col-md-3">
                                           <input type="radio" name="r_operativo_interno" id="r_operativo" value="O"> 
                                        </div>
                                        Interno 
                                        <div class="col-sm-12 col-md-2">
                                            <input type="radio" name="r_operativo_interno" id="r_interno" value="I"> 
                                        </div>
                                    </div>
                                </div>
                                <label id="l_servicio" for="i_servicio_inicio" class="col-sm-2 col-md-2 col-form-label">Inicio Servicio </label>
                                <div id="d_servicio" class="col-sm-12 col-md-3">
                                    <input type="text" class="form-control" id="i_servicio_inicio" disabled="disabled" autocomplete="off">
                                </div>
                            </div>
                            </form>
                            <br>
                            <form id="form_domicilio" name="form_domicilio">
                            <p class="text-light bg-info">&nbsp;&nbsp; Domicilio del Servicio</p>
                            <div class="form-group row">
                                <label for="i_domicilio" class="col-2 col-md-2 col-form-label requerido">Domicilio </label><br>
                                <div class="col-sm-12 col-md-4">
                                    <input type="text" class="form-control validate[required]" id="i_domicilio" autocomplete="off">
                                </div>

                                <label for="i_num_ext" class="col-1 col-md-1 col-form-label requerido">Ext </label><br>
                                <div class="col-sm-2 col-md-2">
                                    <input type="text" class="form-control validate[required]" id="i_num_ext" autocomplete="off">
                                </div>

                                <label for="i_num_int" class="col-1 col-md-1 col-form-label requerido">Int </label><br>
                                <div class="col-sm-2 col-md-2">
                                    <input type="text" class="form-control validate[required]" id="i_num_int" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_cp" class="col-2 col-md-2 col-form-label requerido">Código Postal </label><br>
                                <div class="col-sm-12 col-md-3">
                                    <div class="row">
                                        
                                        <div class="input-group col-sm-12 col-md-9">
                                            <input type="text" id="i_cp" name="i_cp" class="form-control validate[required,custom[integer]]" readonly autocomplete="off">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary" type="button" id="b_buscar_cp" style="margin:0px;">
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <label for="s_pais" class="col-1 col-md-1 col-form-label requerido">País </label><br>
                                <div class="col-sm-12 col-md-3">
                                    <select id="s_pais" name="s_pais" class="form-control validate[required]" autocomplete="off"></select>
                                </div>
                                
                            </div>

                            <div class="form-group row">
                                <label for="i_colonia" class="col-sm-2 col-md-2 col-form-label requerido">Colonia </label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="text" class="form-control validate[required]" id="i_colonia" disabled autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_id_municipio" class="col-2 col-md-2 col-form-label requerido">Municipio </label><br>
                                <div class="col-sm-2 col-md-2">
                                    <input type="text" class="form-control validate[required]" id="i_id_municipio" disabled autocomplete="off">
                                </div>
                                <div class="col-sm-2 col-md-8">
                                    <input type="text" class="form-control validate[required]" id="i_municipio" disabled autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_id_estado" class="col-2 col-md-2 col-form-label requerido">Estado </label><br>
                                <div class="col-sm-2 col-md-2">
                                    <input type="text" class="form-control validate[required]" id="i_id_estado" disabled autocomplete="off">
                                </div>
                                <div class="col-sm-2 col-md-8">
                                    <input type="text" class="form-control validate[required]" id="i_estado" disabled autocomplete="off">
                                </div>
                            </div>
                           <hr style="border:1px solid #17A2B8;">
                          
                           </form>
                           <form id="form_nomina" name="form_nomina"> 
                            <div class="form-group row">
                                <!-- MGFS 07-01-2020 se quita el requerido de Depto nomina, Ubicacion y se agregan notas--->
                                <label for="i_departamento_nomina" class="col-2 col-md-2 col-form-label">Depto Nómina </label><br>
                                <div class="col-sm-12 col-md-5">
                                    <div class="row">
                                        <div class="input-group col-sm-12 col-md-12">
                                            <input type="text" id="i_departamento_nomina" name="i_departamento_nomina" class="form-control" readonly autocomplete="off">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary" type="button" id="b_buscar_deptos_nomina" style="margin:0px;">
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <label class="col-sm-12 col-md-5 notaVerde" >* Solo aplica para Unidades de Negocio distintas a Secorp</label>
                            </div>

                            <div class="form-group row">
                                <label for="i_departamento_interno" class="col-2 col-md-2 col-form-label requerido">Depto Interno </label><br>
                                <div class="col-sm-12 col-md-5">
                                    <div class="row">
                                        <div class="input-group col-sm-12 col-md-12">
                                            <input type="text" id="i_departamento_interno" name="i_departamento_interno" class="form-control validate[required]" readonly autocomplete="off">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary" type="button" id="b_buscar_deptos_internos" style="margin:0px;">
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                            
                            
                            <div class="form-group row">
                                <label for="i_ubicacion" class="col-sm-2 col-md-2 col-form-label">Ubicación </label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="text" class="form-control" id="i_ubicacion" autocomplete="off">
                                </div>
                                <label class="col-sm-12 col-md-2 notaVerde" >* Geoposición</label>
                            </div>

                            <div class="form-group row">
                                <label for="i_supervisor" class="col-2 col-md-2 col-form-label requerido">Supervisor </label><br>
                                <div class="col-sm-12 col-md-5">
                                    <div class="row">
                                        <div class="input-group col-sm-12 col-md-12">
                                            <input type="text" id="i_supervisor" name="i_supervisor" class="form-control validate[required]" readonly autocomplete="off">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary verificar_permiso" alt="BOTON_ASIGNAR_SUPERVISOR" type="button" id="b_buscar_supervisor" style="margin:0px;">
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                </div>
                                <span class="col-sm-12 col-md-2 badge badge-secondary" id="dato_contrato" style="display:none; vertical-align: middle; padding-bottom:0px;"></span>
                            </div>

                           <!--NJES Feb/14/2020 se agrega cliente y razon social para generar contrato si es departamento operativo-->
                            <div class="form-group row">
                                <label for="i_cliente" class="col-sm-12 col-md-2 col-form-label requerido">Cliente</label>
                                <div class="input-group col-sm-12 col-md-4">
                                    <input type="text" id="i_cliente" name="i_cliente" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_buscar_clientes" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <label for="s_razon_social_cliente" class="col-sm-12 col-md-2 col-form-label requerido">Razón Social </label>
                                <div class="col-sm-12 col-md-4">
                                    <select id="s_razon_social_cliente" name="s_razon_social_cliente" class="form-control form-control-sm validate[required]" autocomplete="off"></select>
                                </div>
                            </div>
                            
                        </form>

                        <div class="form-group row">
                            <label for="ch_inactivo" class="col-sm-2 col-md-2 col-form-label">Inactivo</label>
                            <div class="col-sm-10 col-md-2">
                            <br>
                                <input type="checkbox" id="ch_inactivo" name="ch_inactivo" value="">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-4"><!--<button type="button" class="btn btn-success btn-sm form-control verificar_permiso" alt="BOTON_ASIGNAR_SUPERVISOR" id="b_asignar_supervisor"><i class="fa fa-user-secret" aria-hidden="true"></i> Asignar a Supervisor</button>--></div>
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-12 col-md-4">
                        <button type="button" class="btn btn-success btn-sm form-control verificar_permiso" alt="BOTON_EXCEL_Departamentos" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                        <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
                            <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
                            <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
                            <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
                        </form>
                    </div>
                </div>

            <br>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
</body>

<div id="dialog_buscar_departamentos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Departamentos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_departamentos" id="i_filtro_departamentos" class="form-control filtrar_renglones" alt="renglon_departamentos" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_departamentos">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Clave</th>
                          <th scope="col">Descripción</th>
                          <th scope="col">Unidad</th>
                          <th scope="col">Sucursal</th>
                          <th scope="col">Área</th>
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

<div id="dialog_buscar_departamentos_nomina" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Departamentos Nómina</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_departamentos_nomina" id="i_filtro_departamentos_nomina" class="form-control filtrar_renglones" alt="renglon_departamentos_nomina" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_departamentos_nomina">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Clave</th>
                          <th scope="col">Descripción</th>
                          <th scope="col">Unidad</th>
                          <th scope="col">Sucursal</th>
                          <th scope="col">Área</th>
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

<div id="dialog_buscar_departamentos_internos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Departamentos Internos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_departamentos_interno" id="i_filtro_departamentos_interno" class="form-control filtrar_renglones" alt="renglon_departamentos_internos" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_departamentos_internos">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Clave</th>
                          <th scope="col">Descripción</th>
                          <th scope="col">Unidad</th>
                          <th scope="col">Sucursal</th>
                          <th scope="col">Área</th>
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

<div id="dialog_buscar_cp" class="modal fade bd-example-modal-lg"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Códigos Postales</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <label for="s_estados">Estado</label>
                    <select class="form-control coti" id="s_estados" style="width: 100%;"></select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label for="s_municipios">Municipio</label>
                    <select class="form-control coti" id="s_municipios" style="width: 100%;"></select>
                </div>
                <div class="col-sm-12 col-md-4"><input type="text" name="i_filtro_cp" id="i_filtro_cp" class="form-control filtrar_renglones" alt="renglon_cp" placeholder="Filtrar" autocomplete="off"></div>
            </div>                               
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_cp">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Código Postal</th>
                          <th scope="col">Estado</th>
                          <th scope="col">Municipio</th>
                          <th scope="col">Colonia</th>
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

<div id="dialog_asignar_supervisor" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Asignar Supervisor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_supervisor"> 
            <div class="form-group row">
                <label for="i_departamento" class="col-sm-2 col-md-2 col-form-label requerido">Departamento </label>
                <div class="col-sm-12 col-md-8">
                    <input type="text" class="form-control validate[required]" id="i_departamento">
                </div>
            </div>
            <div class="form-group row">
                <label for="i_supervisor" class="col-2 col-md-2 col-form-label requerido">Supervisor </label><br>
                <div class="col-sm-12 col-md-5">
                    <div class="row">
                        <div class="input-group col-sm-12 col-md-12">
                            <input type="text" id="i_supervisor" name="i_supervisor" class="form-control validate[required]" readonly autocomplete="off">
                            <div class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="b_buscar_supervisor" style="margin:0px;">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                 </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>    
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-dark btn-sm" id="b_guardar_supervisor"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                   
      </div>
    </div>
  </div>
</div>

<div id="dialog_buscar_supervisores" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Supervisores</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_supervisores" id="i_filtro_supervisores" class="form-control filtrar_renglones" alt="renglon_supervisores" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_supervisores">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">ID</th>
                          <th scope="col">Nombre</th>
                          <th scope="col">Sucursal</th>
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

<div id="dialog_clientes" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Clientes</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_cliente" id="i_filtro_cliente" alt="renglon_cliente" class="filtrar_renglones form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_clientes">
                    <thead>
                        <tr class="renglon">
                            <th scope="col" style="text-align:left;">ID</th>
                            <th scope="col">Nombre Comercial</th>
                            <th scope="col">Fecha Inicio</th>
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
<script src="vendor/select2/js/select2.js"></script>

<script>
  
    //-->NJES Feb/14/2020 se agrega contrato cliente si el departamento es operativo
    var idContrato=0; 

    var idDepartamento=0;
    var departamentoOriginal='';
    var tipo_mov=0;
    var modulo='DEPARTAMENTOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var usuario='<?php echo $_SESSION['usuario']?>';
    var matriz = <?php echo $_SESSION['sucursales']?>;

    $(function(){

        mostrarBotonAyuda(modulo);

        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        muestraSucursalesAcceso('s_id_sucursales',idUnidadActual,idUsuario);
        muestraAreasAcceso('s_id_area', $('#s_id_sucursales').val());

        muestraSelectPaises('s_pais');

        $('#ch_inactivo').prop('checked',false).prop('disabled',true);  
        $('#r_operativo').prop('checked',true); 
        $('#l_servicio,#d_servicio').show(); 


        $('#r_interno').on('click',function(){
            if($(this).is(':checked')){
                $('#form_domicilio input').val('');
                $('#form_domicilio').hide();

                $('#form_nomina input').val('');
                $('#form_nomina').hide();

                $('#l_servicio,#d_servicio').hide(); 

                $('#b_asignar_supervisor').prop('disabled',true);
            }
        });

        $('#r_operativo').on('click',function(){
            if($(this).is(':checked')){

                $('#form_domicilio input').val('');
                muestraSelectPaises('s_pais');
                $('#form_domicilio').show();

                $('#form_nomina input').val('');
                $('#form_nomina').show();

                $('#l_servicio,#d_servicio').show(); 

                $('#b_asignar_supervisor').prop('disabled',false);
            }
        });

        //-->NJES Feb/14/2020 si cambia el tipo de departamento mostar u ocultar cliente para crear o no contratos_clientes
        //verificaTipoDepto();

        $('#s_id_sucursales').change(function(){
            muestraAreasAcceso('s_id_area', $('#s_id_sucursales').val());
            if($('#s_id_sucursales').val()!=''){
               $('#s_id_area').prop('disabled',false);
               if(tipo_mov == 0){
                   buscaClaveDepartamento();
               } 
               
            }
           
        });

        $('#s_id_area').change(function(){
            $('#s_id_departamento').prop('disabled',false); 
            muestraDepartamentoArea('s_id_departamento', $('#s_id_sucursales').val(), $('#s_id_area').val());
        });
               
        $('#s_id_unidades').change(function(){
            idUnidadActual=$(this).val();
            muestraSucursalesAcceso('s_id_sucursales',idUnidadActual,idUsuario);


            $('#i_clave').val('');
           
            asignaDeptoOperaciones(idUnidadActual);
            
           
        });

        function buscaClaveDepartamento(){
            $.ajax({
            type: 'POST',
            url: 'php/departamentos_buscar_clave.php',
            data:{'idSucursal':$('#s_id_sucursales').val()
            },
            success: function(data) {
                console.log(data);
                $('#i_clave').val(data);

            },
            error: function (xhr) {
                console.log('php/departamentos_buscar_clave.php-->'+JSON.stringify(xhr));
                mandarMensaje('Error en el sistema');
            }
            });
        }

        


        $('#b_buscar').on('click',function(){

            $('#forma').validationEngine('hide');
            $('#i_filtro_departamentos').val('');
            $('.renglon_departamentos').remove();
   
            $.ajax({

                type: 'POST',
                url: 'php/departamentos_buscar.php',
                dataType:"json", 
                data:{'estatus':2},

                success: function(data) {
                   
                   if(data.length != 0){

                        $('.renglon_departamentos').remove();
                   
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var inactivo='';
                            
                            if(parseInt(data[i].inactivo) == 1){

                                inactivo='Inactivo';
                            }else{
                                inactivo='Activo';
                            }

                            var html='<tr class="renglon_departamentos" alt="'+data[i].id+'" alt2="'+data[i].id_unidad_negocio+'" alt3="'+data[i].id_sucursal+'" alt4="'+data[i].id_area+'">\
                                        <td data-label="Clave">' + data[i].clave+ '</td>\
                                        <td data-label="Descripcion">' + data[i].descripcion+ '</td>\
                                        <td data-label="Unidad">' + data[i].unidad+ '</td>\
                                        <td data-label="Sucursal">' + data[i].sucursal+ '</td>\
                                        <td data-label="Área">' + data[i].area+ '</td>\
                                        <td data-label="Estatus">' + inactivo+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_departamentos tbody').append(html);   
                            $('#dialog_buscar_departamentos').modal('show');   
                        }
                   }else{

                        mandarMensaje('No se encontró información');
                   }

                },
                error: function (xhr) {
                    console.log('php/departamentos_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        });

        $('#t_departamentos').on('click', '.renglon_departamentos', function() {
            
            tipo_mov = 1;
            $('#b_guardar').prop('disabled',false);
            $('#ch_inactivo').prop('disabled', false);
            idDepartamento = $(this).attr('alt');
            
            muestraSucursalesAcceso('s_id_sucursales',$(this).attr('alt2'),idUsuario);
           
            $('#dialog_buscar_departamentos').modal('hide');
            $('#form_domicilio input').val('');
            muestraRegistro();


        });



        function muestraRegistro(){ 

            $.ajax({
                type: 'POST',
                url: 'php/departamentos_buscar_id.php',
                dataType:"json", 
                data:{
                    'idDepartamento':idDepartamento
                },
                success: function(data) {
                   
                    idDepartamento=data[0].id;
                    departamentoOriginal=data[0].clave;
                    //-->NJES Feb/14/2020 se agrega contrato cliente si el departamento es operativo
                    idContrato = data[0].id_contrato;
                    if(data[0].id_contrato > 0)
                        $('#dato_contrato').text('ID contrato: '+data[0].id_contrato).css('display','block');
                    else
                        $('#dato_contrato').text('').css('display','none');

                    $('#b_asignar_supervisor').prop('disabled',true);
                    $('#form_domicilio').hide();
                    $('#form_nomina').hide();

                    $('#i_id_departamento').val(idDepartamento);
                    $('#i_clave').val(data[0].clave);

                    $('#s_id_unidades').val(data[0].id_unidad_negocio).prop('disabled',true);
                    $("#s_id_unidades").select2({
                            templateResult: setCurrency,
                            templateSelection: setCurrency
                    });
                    $('.img-flag').css({'width':'50px','height':'20px'}); //Cambia el tamaño de la imagen que se mostrara en el select

                    if(data[0].id_sucursal != 0){
                        $('#s_id_sucursales').val(data[0].id_sucursal).prop('disabled',true);
                        $('#s_id_sucursales').select2({placeholder: $(this).data('elemento')});
                    }else{
                        $('#s_id_sucursales').val('');
                        $('#s_id_sucursales').select2({placeholder: 'Selecciona'});
                    }
                        
                    if(data[0].id_area != 0){
                        $('#s_id_area').val(data[0].id_area);
                        $('#s_id_area').select2({placeholder: $(this).data('elemento')});
                    }else{
                        $('#s_id_area').val('');
                        $('#s_id_area').select2({placeholder: 'Selecciona'});
                    }
                    $('#i_descripcion').val(data[0].descripcion);
                   
                    //O=Operativo I=Interno
                   
                    if(data[0].tipo == 'O')
                    {
                        $('#r_operativo').prop('checked',true);
                        muestraSelectPaises('s_pais');
                        $('#form_domicilio').show();
                        $('#form_nomina').show();
                        $('#b_asignar_supervisor').prop('disabled',false);
                        $('#l_servicio,#d_servicio').show(); 
                        $('#i_cliente').attr('alt',data[0].id_cliente).val(data[0].cliente);
                        var optionRazonSocial = new Option(data[0].razon_social_cliente, data[0].id_razon_social, true, true);
                        $('#s_razon_social_cliente').append(optionRazonSocial).trigger('change');
            
                    }else{
                       
                        $('#r_interno').prop('checked',true);
                        $('#form_domicilio').val('');
                        $('#form_nomina').val('');
                        $('#l_servicio,#d_servicio').hide(); 
                    }
                    $('#i_servicio_inicio').val(data[0].servicio_inicio);

                    $('#i_domicilio').val(data[0].domicilio);
                    $('#i_cp').val(data[0].codigo_postal);
                    $('#i_colonia').val(data[0].colonia);
                    $('#i_num_ext').val(data[0].no_ext);
                    $('#i_num_int').val(data[0].no_int);
                    if (data[0].facturable == 0) {
                        $('#ch_facturable').prop('checked', false);
                    } else {
                        $('#ch_facturable').prop('checked', true);
                    }

                    if(data[0].id_pais != 0)
                    {
                        $('#s_pais').val(data[0].id_pais);
                        $('#s_pais').select2({placeholder: $(this).data('elemento')});
                    }else{
                        $('#s_pais').val('');
                        $('#s_pais').select2({placeholder: 'Selecciona'});
                    }
                    $('#i_id_estado').val(data[0].id_estado);
                    $('#i_estado').val(data[0].estado);
                    $('#i_id_municipio').val(data[0].id_municipio);
                    $('#i_municipio').val(data[0].municipio);
                    

                   
                    $('#i_departamento_nomina').val(data[0].departamento_nomina).attr('alt',data[0].id_departamento_nomina);
                    $('#i_departamento_interno').val(data[0].departamento_interno).attr('alt',data[0].id_departamento_interno);
                   
                    $('#i_ubicacion').val(data[0].ubicacion);
                   
                    if (data[0].inactivo == 0) {
                        $('#ch_inactivo').prop('checked', false);
                    } else {
                        $('#ch_inactivo').prop('checked', true);
                    }

                    $('#i_supervisor').attr('alt',data[0].id_supervisor).val(data[0].supervisor);
                   //$('#b_asignar_supervisor').attr('alt',data[0].id_supervisor).attr('alt2',data[0].supervisor);
                   
                },
                error: function (xhr) {
                    console.log('php/departamentos_buscar_id.php-->'+JSON.stringify(xhr));
                    mandarMensaje(xhr.responseText);
                }
            });
        }

        $('#b_guardar').click(function(){
          
           $('#b_guardar').prop('disabled',true);

            if ($('#forma').validationEngine('validate') && $('#form_nomina').validationEngine('validate')){
                if($('#r_operativo').is(':checked')==true){
                    if ($('#form_domicilio').validationEngine('validate')){
                        verificar();
                    }else{
                        $('#b_guardar').prop('disabled',false);
                    }
                }else{
                    verificar();
                }
                

            }else{
               
                $('#b_guardar').prop('disabled',false);
            }
        });


        function verificar()
        {

            if($('#i_clave').val() != '')
            {


                $.ajax({
                    type: 'POST',
                    url: 'php/departamentos_verificar.php',
                    dataType:"json", 
                    data:  {'clave':$('#i_clave').val()
                    },
                    success: function(data) 
                    {
                        console.log(data);
                        
                        if(data == 1){
                            
                            if (tipo_mov == 1 && departamentoOriginal == $('#i_clave').val()) {
                                guardar();
                            }else{

                                mandarMensaje('La clave: '+ $('#i_clave').val()+' ya existe intenta con otro');
                                //$('#i_clave').val('');
                                $('#b_guardar').prop('disabled',false);
                            }
                        }else{
                            guardar();
                        }
                    },
                    error: function (xhr) {
                        console.log('php/departamentos_verificar.php-->'+JSON.stringify(xhr));
                        mandarMensaje('Error en el sistema');
                    }
                });

            }
            else
            {
                $('#b_guardar').prop('disabled',false);
                mandarMensaje('La Clave es Obligatoria');
            }
            
            

            
        }

        
        /* funcion que manda a generar la insecion o actualizacion de un registro */    
        function guardar(){
         
            $.ajax({
                type: 'POST',
                url: 'php/departamentos_guardar.php', 
                dataType:"json", 
                data: {
                        'datos':obtenerDatos()
                },
                //una vez finalizado correctamente
                success: function(data){
                  
                    if (data > 0 ) {
                        if (tipo_mov == 0){
                            
                            mandarMensaje('Se guardó el nuevo registro');
                            $('#b_nuevo').click();
    
                        }else{
                                
                            mandarMensaje('Se actualizó el registro');
                            $('#b_nuevo').click();
                               
                        }
                      

                    }else{
                           
                        mandarMensaje('Error en el guardado');
                        $('#b_guardar').prop('disabled',false);
                    }

                },
                    //si ha ocurrido un error
                 error: function(xhr){
                   console.log('php/departamentos_guardar.php-->'+JSON.stringify(xhr));
                    mandarMensaje("Ha ocurrido un error.");
                    $('#b_guardar').prop('disabled',false);
                }
            });
           
        }
        /* obtine los datos y los guarda en un arreglo*/
        function obtenerDatos(){
           
            var paquete = [];
                paquete[0]= 1;
            var cont = 0;
            var paq = {
                    'tipo_mov' : tipo_mov,
                    'idDepartamento' : idDepartamento,
                    'clave' : $('#i_clave').val(),
                    'descripcion' : $('#i_descripcion').val(),
                   
                    'idUnidad' : $('#s_id_unidades').val(),
                    'idSucursal' : $('#s_id_sucursales').val(),
                    'idArea' : $('#s_id_area').val(),
                    'servicioInicio' : $('#i_servicio_inicio').val(),

                    'domicilio' : $('#i_domicilio').val(),
                    'cp' : $('#i_cp').val(),
                    'colonia' : $('#i_colonia').val(),
                    'numInt' : $('#i_num_int').val(),
                    'numExt' : $('#i_num_ext').val(),

                    'tipo' : $("#r_operativo").is(':checked') ? 'O' : 'I',

                    'idPais' : $('#s_pais').val(),
                    'idEstado' : $('#i_id_estado').val(),
                    'idMunicipio' : $('#i_id_municipio').val(),

                    'idDepartamentoNomina' : $('#i_departamento_nomina').attr('alt'),
                    'idDepartamentoInterno' : $('#i_departamento_interno').attr('alt'),
                    'ubicacion' : $('#i_ubicacion').val(),
                    'inactivo' : $("#ch_inactivo").is(':checked') ? 1 : 0,
                    'idSupervisor' : $('#i_supervisor').attr('alt'),
                    //-->NJES Feb/14/2020 se envian parametros cliente y razón social para generar contrato cliente
                    'idCliente' : $('#i_cliente').attr('alt'),
                    'idRazonSocialCliente' : $('#s_razon_social_cliente').val(),
                    'idContrato' : idContrato
                }

                paquete.push(paq);
              
            return paquete;
        }   
        
        //************Busca los cp por estado y municipio */
        $('#b_buscar_cp').on('click',function(){
            $('#i_cp').validationEngine('hide');
            $('#i_filtro_cp').val('');
            $('.renglon_cp').remove();
            muestraSelectEstados('s_estados');
            muestraSelectMunicipios('s_municipios',0);
            $('#dialog_buscar_cp').modal('show'); 

        });

        $(document).on('change','#s_estados,#s_municipios',function(){
            muestraSelectMunicipios('s_municipios',$('#s_estados').val());
            buscarCp();
        });

        function buscarCp(){
           
            $('#i_filtro_cp').val('');
            $('.renglon_cp').remove();

            $.ajax({

                type: 'POST',
                url: 'php/codigo_postal_buscar.php',
                dataType:"json", 
                data:{
                    'idEstado':$('#s_estados').val(),
                    'idMunicipio': $('#s_municipios').val()
                },
                success: function(data) {
                
                if(data.length != 0){

                    $('.renglon_cp').remove();
                
                    for(var i=0;data.length>i;i++){

                        ///llena la tabla con renglones de registros

                        var html='<tr class="renglon_cp" alt="'+data[i].id_colonia+'" alt2="'+data[i].colonia+'" alt3="'+data[i].codigo_postal+'" alt4="'+data[i].estado+'" alt5="'+data[i].id_estado+'"alt6="'+data[i].municipio+'"alt7="'+data[i].id_municipio+'">\
                                    <td data-label="ID">' + data[i].codigo_postal+ '</td>\
                                    <td data-label="Clave">' + data[i].estado+ '</td>\
                                    <td data-label="Descripción">' + data[i].municipio+ '</td>\
                                    <td data-label="Tallas">' + data[i].colonia+ '</td>\
                                </tr>';
                        ///agrega la tabla creada al div 
                        $('#t_cp tbody').append(html);   
                             
                    }
                }else{

                    mandarMensaje('No se encontró información');
                }

                },
                error: function (xhr) {
                    console.log('php/codigo_postal_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        $('#t_cp').on('click', '.renglon_cp', function() {

            var  idColonia = $(this).attr('alt');
            var  colonia = $(this).attr('alt2');
            var  cp = $(this).attr('alt3');
            var  estado = $(this).attr('alt4');
            var  idEstado = $(this).attr('alt5');
            var  municipio = $(this).attr('alt6');
            var  idMunicipio = $(this).attr('alt7');

            $('#i_cp').val(cp);
            $('#i_colonia').val(colonia).attr('alt',idColonia);
            $('#i_id_estado').val(idEstado);
            $('#i_id_municipio').val(idMunicipio);
            $('#i_estado').val(estado);
            $('#i_municipio').val(municipio);
               
            $('#dialog_buscar_cp').modal('hide');

        });

       

        $('#b_nuevo').on('click',function(){
            limpiar();
        });
        /* Limpia el modulo comple al dar click en nuevo o guardad*/
        function limpiar(){
         
            idContrato = 0;
            idDepartamento=0;
            departamentoOriginal='';
            tipo_mov=0;
            $('input').not('input:radio').val('');
            $('#form_domicilio').validationEngine('hide');
            $('#form_nomina').validationEngine('hide');
            $('#b_guardar').prop('disabled',false);
            $('#ch_inactivo').prop('checked',false).prop('disabled',true);
            $('#r_operativo').prop('checked',true); 
            $('#l_servicio,#d_servicio').show(); 
            $('#form_domicilio').show();
            $('#form_nomina').show();

            muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
            muestraSucursalesAcceso('s_id_sucursales',idUnidadActual,idUsuario);
            muestraAreasAcceso('s_id_area', $('#s_id_sucursales').val());
            muestraSelectPaises('s_pais');

            $('#s_id_unidades').prop('disabled',false);
            $('#s_id_sucursales').prop('disabled',false);
            $('#s_id_area').prop('disabled',false);
            $('#s_pais').prop('disabled',false);

            //-->NJES Feb/14/2020 si cambia el tipo de departamento mostar u ocultar cliente para crear o no contratos_clientes
            //verificaTipoDepto();
            $('#s_razon_social_cliente').html('').val('');
            $('#dato_contrato').text('').css('display','none');
            
        }

        $('#b_excel').click(function(){
            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
            
            $('#i_nombre_excel').val('Registros Departamentos');
            $('#i_fecha_excel').val(hoy);
            $('#i_modulo_excel').val('DEPARTAMENTOS');
            
            $("#f_imprimir_excel").submit();
        });


        $('#b_buscar_deptos_nomina').on('click',function(){

           
            $('#i_filtro_departamentos_nomina').val('');
            $('.renglon_departamentos_nomina').remove();

            $.ajax({

                type: 'POST',
                url: 'php/departamentos_buscar_nomina.php',
                dataType:"json", 
                data:{

                },
                success: function(data) {
                
                if(data.length != 0){

                        $('.renglon_departamentos_nomina').remove();
                
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var inactivo='';
                            
                            if(parseInt(data[i].inactivo) == 1){

                                inactivo='Inactivo';
                            }else{
                                inactivo='Activo';
                            }

                            var html='<tr class="renglon_departamentos_nomina" alt="'+data[i].id+'" alt2="'+data[i].descripcion+'">\
                                        <td data-label="Clave">' + data[i].clave+ '</td>\
                                        <td data-label="Descripcion">' + data[i].descripcion+ '</td>\
                                        <td data-label="Unidad">' + data[i].unidad+ '</td>\
                                        <td data-label="Sucursal">' + data[i].sucursal+ '</td>\
                                        <td data-label="Área">' + data[i].area+ '</td>\
                                        <td data-label="Estatus">' + inactivo+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_departamentos_nomina tbody').append(html);   
                            $('#dialog_buscar_departamentos_nomina').modal('show');   
                        }
                }else{

                        mandarMensaje('No se encontró información');
                }

                },
                error: function (xhr) {
                    console.log('php/departamentos_buscar_nomina.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
            });

            $('#t_departamentos_nomina').on('click', '.renglon_departamentos_nomina', function() {
                var idDepartamentoN = $(this).attr('alt');
                var departamentoN = $(this).attr('alt2');
           
                $('#i_departamento_nomina').val(departamentoN).attr('alt',idDepartamentoN);
                $('#dialog_buscar_departamentos_nomina').modal('hide');
        
            });


            $('#b_buscar_deptos_internos').on('click',function(){
               
                $('#i_filtro_departamentos_interno').val('');
                $('.renglon_departamentos_interno').remove();

                $.ajax({

                    type: 'POST',
                    url: 'php/departamentos_buscar_internos.php',
                    dataType:"json", 
                    data:{
                        idUnidad : $('#s_id_unidades').val()
                    },
                    success: function(data) {
                    console.log('res:'+data);
                    if(data.length != 0){

                            $('.renglon_departamentos_internos').remove();
                    
                            for(var i=0;data.length>i;i++){

                                ///llena la tabla con renglones de registros
                                var inactivo='';
                                
                                if(parseInt(data[i].inactivo) == 1){

                                    inactivo='Inactivo';
                                }else{
                                    inactivo='Activo';
                                }

                                var html='<tr class="renglon_departamentos_internos" alt="'+data[i].id+'" alt2="'+data[i].descripcion+'">\
                                            <td data-label="Clave">' + data[i].clave+ '</td>\
                                            <td data-label="Descripcion">' + data[i].descripcion+ '</td>\
                                            <td data-label="Unidad">' + data[i].unidad+ '</td>\
                                            <td data-label="Sucursal">' + data[i].sucursal+ '</td>\
                                            <td data-label="Área">' + data[i].area+ '</td>\
                                            <td data-label="Estatus">' + inactivo+ '</td>\
                                        </tr>';
                                ///agrega la tabla creada al div 
                                $('#t_departamentos_internos tbody').append(html);   
                                $('#dialog_buscar_departamentos_internos').modal('show');   
                            }
                    }else{

                            mandarMensaje('No se encontró información');
                    }

                    },
                    error: function (xhr) {
                        console.log('php/departamentos_buscar_internos.php-->'+JSON.stringify(xhr));
                        mandarMensaje('Error en el sistema');
                    }
                });
                });

                $('#t_departamentos_internos').on('click', '.renglon_departamentos_internos', function() {
                    
                    var idDepartamentoI = $(this).attr('alt');
                    var departamentoI = $(this).attr('alt2');

                    $('#i_departamento_interno').val(departamentoI).attr('alt',idDepartamentoI);
                    $('#dialog_buscar_departamentos_internos').modal('hide');

                });

            $('#b_asignar_supervisor').on('click',function(){
                
                var idSupervisor=$(this).attr('alt');
                var supervisor=$(this).attr('alt2');
                if($('#i_id_departamento').val()!=''){

                    $('#i_supervisor').val(supervisor).attr('alt',idSupervisor);
                    $('#i_departamento').val($('#i_descripcion').val());

                    $('#dialog_asignar_supervisor').modal('show');
                }else{
                    mandarMensaje('Debes buscar primero un departamento');
                }
                
            });

            $('#b_guardar_supervisor').on('click',function(){
                 $('#b_guardar_supervisor').prop('disabled',true);

                if ($('#form_supervisor').validationEngine('validate')){
                    $.ajax({
    
                        type: 'POST',
                        url: 'php/departamentos_asignar_supervisor.php',
                        data:{
                            'idDepartamento' : $('#i_id_departamento').val(),
                            'idSupervisor' : $('#i_supervisor').attr('alt')
                        },
                        success: function(data){
                            $('#b_guardar_supervisor').prop('disabled',false);
                            if(data > 0){
                                $('#b_asignar_supervisor').attr('alt',$('#i_supervisor').attr('alt')).attr('alt2',$('#i_supervisor').val());
             
                                mandarMensaje('El supervisor: '+$('#i_supervisor').val()+' fue asignado correctamente');
                            }else{
                                mandarMensaje('Ocurrio un error durante el proceso')
                            }
                        },
                        error: function (xhr) {
                            console.log('php/departamentos_asignar_supervisor.php'+JSON.stringify(xhr))
                            mandarMensaje('Error en el sistema');
                        }
                    });

                }else{
                
                    $('#b_guardar_supervisor').prop('disabled',false);
                }
            });


            $('#b_buscar_supervisor').on('click',function(){
                
                $('#i_filtro_supervisores').val('');
                $('.renglon_supervisores').remove();
       
                $.ajax({
    
                    type: 'POST',
                    url: 'php/empleados_buscar_supervisores.php',
                    dataType:"json", 
                    data:{
                        'idEmpleado':0
                    },
    
                    success: function(data) {
                      

                      //console.log(data);
                       if(data.length != 0 ){
    
                            $('.renglon_supervisores').remove();
                       
                            for(var i=0;data.length>i;i++){
    
                                
    
                                var html='<tr class="renglon_supervisores" alt="'+data[i].id_trabajador+'" alt2="'+data[i].nombre+'">\
                                            <td data-label="usuario">' + data[i].id_trabajador+ '</td>\
                                            <td data-label="usuario">' + data[i].nombre+ '</td>\
                                             <td data-label="usuario">' + data[i].sucursal+ '</td>\
                                        </tr>';
                                ///agrega la tabla creada al div 
                                $('#t_supervisores tbody').append(html);   
                                $('#dialog_buscar_supervisores').modal('show');   
                            }
                       }else{

                            mandarMensaje('No se encontró información');
                       }
    
                    },
                    error: function (xhr) {
                        
                        mandarMensaje('Error en el sistema *********');
                    }
                });
            });
    
             
    
            $('#t_supervisores').on('click', '.renglon_supervisores', function() {
                
                var idSupervisor = $(this).attr('alt');
                var supervisor = $(this).attr('alt2');
                $('#i_supervisor').attr('alt',idSupervisor).val(supervisor);

                $('#dialog_buscar_supervisores').modal('hide');
    
            });



            function asignaDeptoOperaciones(idUnidad){
               
                $('#i_departamento_interno').attr('alt',0).val('');

                $.ajax({

                    type: 'POST',
                    url: 'php/departamentos_buscar_internos_operaciones.php',
                    dataType:"json", 
                    data:{
                        'idUnidad' : idUnidad
                    },
                    success: function(data) {
                        if(data!=''){
                            $('#i_departamento_interno').attr('alt',data[0].id_depto).val(data[0].clave+' - '+data[0].descripcion);
                 
                        }else{
                           
                            if($("#r_operativo").is(':checked')==true){
                                mandarMensaje('NO se asignado un departamento de operaciones para esta unidad de negocio');
                            }
                        }
                           
                    },
                    error: function (xhr) {
                        console.log('php/departamentos_buscar_internos_operaciones.php-->'+JSON.stringify(xhr));
                        if($("#r_operativo").is(':checked')==true){
                            mandarMensaje('No encontró un depto de operaciones para esta unidad de negocio');
                        }
                    }
                });
          
            }
    
            //-->NJES Feb/14/2020 si cambia el tipo de departamento mostar u ocultar cliente para crear o no contratos_clientes
            /*$("input[name=r_operativo_interno]:radio").change(function(){
                verificaTipoDepto();
            });

            function verificaTipoDepto(){
                if($("input[name=r_operativo_interno]:checked").val() == 'O')
                {
                    $('.div_cliente_razon_social').css('display','block');
                }else{
                    $('.div_cliente_razon_social').css('display','none');
                }
            }*/

            $('#b_buscar_clientes').click(function(){
                $('#i_filtro_cliente').val('');
                muestraModalClientes('renglon_cliente','t_clientes tbody','dialog_clientes');
            });

            $('#t_clientes').on('click', '.renglon_cliente', function() {
                var id = $(this).attr('alt');
                var nombre = $(this).attr('alt2');
                $('#i_cliente').attr('alt',id).val(nombre);
                $('#dialog_clientes').modal('hide'); 

                if($('#s_id_unidades').val() != '')
                {
                    muestraSelectRazonesSociales(id,$('#s_id_unidades').val(),'s_razon_social_cliente');
                }
            });

    });

</script>

</html>