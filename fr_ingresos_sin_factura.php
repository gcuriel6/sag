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

    @media screen and(max-width: 1030px){
        .modal-lg{
            min-width: 800px;
            max-width: 800px;
        }
    }

    @media screen and (max-width: 600px) {
        .modal-dialog{
            max-width: 300px;
        }
    }
    #dialog_buscar_sin_factura {
        overflow-y:auto;
    }

    #dialog_buscar_sin_factura >  .modal-lg{
    
        min-width: 97%;
        max-width: 97%;
    }
    .Cancelada {
        color:#721C24;
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
                        <div class="titulo_ban">Ingresos Sin Factura</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-3"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_nuevo"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_buscar"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-danger btn-sm form-control" id="b_cancelar"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</button>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-sm-12 col-md-1"><input id="i_id_sucursal" type="hidden"/></div>
                    <div class="col-sm-12 col-md-10">
                        <form id="forma" name="forma">
                            <div class="row">
                                <div class="col-sm-12 col-md-10">
                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-3">
                                            <label for="s_id_unidad" class="col-form-label">Unidad de Negocio </label>
                                            <select id="s_id_unidad" name="s_id_unidad" class="form-control" autocomplete="off" style="width:100%;"></select>
                                        </div>
                                        <div class="col-sm-12 col-md-1">
                                            <label for="">SIN Unidad</label>
                                            <input type="checkbox" name="" id="ch_sin_unidad">
                                        </div>
                                        <div class="col-sm-12 col-md-1">
                                            <label for="">FONDEO</label>
                                            <input type="checkbox" name="" id="ch_fondeo">
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="s_id_sucursal" class="col-form-label">Sucursal </label>
                                            <select id="s_id_sucursal" name="s_id_sucursal" class="form-control" autocomplete="off" style="width:100%;"></select>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="s_cuenta" class="col-form-label requerido">Cuenta</label>
                                            <select id="s_cuenta" name="s_cuenta" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <div id="d_estatus" class="alert"></div>
                                </div>
                            </div>
                            <!--<div class="form-group row">
                                <label for="i_empresa_fiscal" class="col-sm-2 col-md-2 col-form-label requerido">Empresa </label>
                                <div class="input-group col-sm-8 col-md-8">
                                    <input type="text" id="i_empresa_fiscal" name="i_empresa_fiscal" class="form-control validate[required]" readonly autocomplete="off" aria-describedby="b_buscar_empresa">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_buscar_empresa" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="s_cuenta" class="col-sm-2 col-md-2 col-form-label requerido">Cuenta</label>
                                <div class="col-sm-12 col-md-5">
                                    <select id="s_cuenta" name="s_cuenta" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="s_tipo_ingreso" class="col-sm-2 col-md-2 col-form-label requerido">Tipo Ingreso </label>
                                <div class="col-sm-12 col-md-5">
                                    <select id="s_tipo_ingreso" name="s_tipo_ingreso" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div>

                            
                            <div class="form-group row">
                                <label for="i_fecha" class="col-sm-2 col-md-2 col-form-label requerido">Fecha </label>
                                <div class="col-sm-2 col-md-2">
                                    <input type="text" id="i_fecha" name="i_fecha" readonly class="form-control form-control-sm fecha validate[required]" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ta_observaciones" class="col-sm-2 col-md-2 col-form-label requerido">Observaciones </label>
                                <div class="col-sm-9 col-md-9">
                                    <textarea  id="ta_observaciones" name="ta_observaciones" class="form-control validate[required]" autocomplete="off"></textarea>
                                </div>
                            </div>   
                            
                            <div class="form-group row">
                                <label for="i_importe" class="col-sm-2 col-md-2 col-form-label requerido">Importe </label>
                                <div class="col-sm-12 col-md-3">
                                    <input type="text" class="form-control validate[required,custom[number],min[0.01]]" id="i_importe" name="i_importe" autocomplete="off">
                                </div>
                            </div>-->

                            <!-- <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <label for="s_id_area" class="col-form-label">Área </label>
                                    <select id="s_id_area" name="s_id_area" class="form-control" autocomplete="off" style="width:100%;"></select>
                                </div>
                                <div class="col-sm-12 col-md-1"></div>
                                <div class="col-sm-12 col-md-5">
                                    <label for="s_id_departamento" class="col-form-label">Departamento Interno </label>
                                    <select id="s_id_departamento" name="s_id_departamento" class="form-control form-control-sm" autocomplete="off" style="width:100%;"></select>
                                </div>
                            </div> -->
                            <!-- <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <label for="i_empresa_fiscal" class="col-form-label">Empresa </label>
                                    <div class="row">
                                        <div class="input-group col-sm-12 col-md-12">
                                            <input type="text" id="i_empresa_fiscal" name="i_empresa_fiscal" class="form-control" readonly autocomplete="off" aria-describedby="b_buscar_empresa">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary" type="button" id="b_buscar_empresa" style="margin:0px;">
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-1"></div>
                                
                            </div> -->
                            <div class="form-group row">
                                <div class="col-sm-12 col-md-4">
                                    <label for="s_tipo_ingreso" class="col-form-label requerido">Tipo Ingreso </label>
                                    <select id="s_tipo_ingreso" name="s_tipo_ingreso" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="i_importe" class="col-form-label requerido">Importe </label>
                                    <input type="text" class="form-control validate[required,custom[number],min[0.01]]" id="i_importe" name="i_importe" autocomplete="off">
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="i_fecha" class="col-form-label requerido">Fecha </label>
                                    <input type="text" id="i_fecha" name="i_fecha" readonly class="form-control form-control-sm fecha validate[required]" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ta_observaciones" class="col-sm-2 col-md-2 col-form-label requerido">Observaciones </label>
                                <div class="col-sm-9 col-md-9">
                                    <textarea  id="ta_observaciones" name="ta_observaciones" class="form-control validate[required]" autocomplete="off"></textarea>
                                </div>
                            </div>  

                        </form>

                    </div>
                </div>
               
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
</body>

<div id="dialog_buscar_empresa" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda Empresa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_empresa" id="i_filtro_empresa" class="form-control filtrar_renglones" alt="renglon_empresa" placeholder="Filtrar" autocomplete="off"></div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_empresa">
                        <thead>
                            <tr class="renglon">
                            <th scope="col">Razón Social</th>
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


<div id="dialog_buscar_bancos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Bancos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_bancos" id="i_filtro_bancos" class="form-control filtrar_renglones" alt="renglon_bancos" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_bancos">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Clave</th>
                          <th scope="col">Descripción</th>
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

<div id="dialog_buscar_sin_factura" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Ingresos sin Factura</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
            <div class="col-sm-12 col-md-5">
                        <div class="row">
                            <div class="col-sm-12 col-md-1">Del: </div>
                            <div class="input-group col-sm-12 col-md-5">
                                <input type="text" name="i_fecha_inicio" id="i_fecha_inicio" class="form-control fecha" autocomplete="off" readonly>
                                <div class="input-group-addon input_group_span">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-1">Al: </div>
                            <div class="input-group col-sm-12 col-md-5">
                                <input type="text" name="i_fecha_fin" id="i_fecha_fin" class="form-control fecha" autocomplete="off" readonly disabled>
                                <div class="input-group-addon input_group_span">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_ingresos_sin_factura" id="i_filtro_ingresos_sin_factura" class="form-control filtrar_renglones" alt="renglon_ingresos_sin_factura" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_ingresos_sin_factura">
                        <thead>
                            <tr class="renglon">
                                <th scope="col">Unidad de Negocio</th>
                                <th scope="col">Sucursal</th>
                                <th scope="col">Área</th>
                                <th scope="col">Departamento Interno</th>
                                <th scope="col">Empresa Fiscal</th>
                                <th scope="col" width="10%">Cuenta</th>
                                <th scope="col" width="10%">Tipo Ingreso</th>
                                <th scope="col" width="10%">Fecha</th>
                                <th scope="col" width="10%">importe</th>
                                <th scope="col" width="10%">Estatus</th>
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
  
    var idIngreso=0;
    var tipoMov=0;
    var modulo='INGRESOS_SIN_FACTURA';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var matriz = <?php echo $_SESSION['sucursales']; ?>;
    var idBanco=0;
    $(function(){
        mostrarBotonAyuda(modulo);
        //--> NJES Jan/21/2020 mostrar solo las cuentas bancos y la caja chica de la sucursal seleccionada 
       
        muestraTiposIngresos('s_tipo_ingreso');
        muestraSelectUnidades(matriz, 's_id_unidad', idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursal', idUnidadActual, modulo,idUsuario);
        muestraAreasAccesoValor('s_id_area',3);
        muestraCuentasBancosCajaChicaSucursal('s_cuenta',$('#s_id_unidad').val(),0);

        $('#s_id_unidad').change(function()
       {

            var idUnidadNegocio = $('#s_id_unidad').val();
            $('.img-flag').css({'width':'50px','height':'20px'});
            muestraSucursalesPermiso('s_id_sucursal', idUnidadNegocio, modulo,idUsuario);
            $('#s_cuenta').empty().prop('disabled',true);

        });

       $('#s_id_sucursal').change(function(){
           var idSucursal = $('#s_id_sucursal').val();
           var idArea = $('#s_id_area').val();
           if(idSucursal > 0 && idArea > 0){
                muestraDepartamentoAreaInternos('s_id_departamento', idSucursal, idArea);
                $("#s_id_departamento").prop("disabled", false);
                $('#s_cuenta').prop('disabled',false);

                //--> NJES Jan/21/2020 mostrar solo las cuentas bancos y la caja chica de la sucursal seleccionada 
                //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
                muestraCuentasBancosCajaChicaSucursal('s_cuenta',$('#s_id_unidad').val(),idSucursal);
            }
        });


       $('#s_id_area').change(function()
       {

            var idSucursal = $('#s_id_sucursal').val();
            var idArea = $('#s_id_area').val();
            if(idSucursal > 0 && idArea > 0){
                muestraDepartamentoAreaInternos('s_id_departamento', idSucursal, idArea);
                $("#s_id_departamento").prop("disabled", false);
            }
           

        });

        $('#b_cancelar').prop('disabled',true);

        $('#i_fecha').val(hoy);

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        });

        $('#s_cuenta').change(function(){
            idBanco=$('#s_cuenta option:selected').attr('alt');
        });

        /*Busca razón social y selecciona*/
        $('#b_buscar_empresa').click(function(){
            $('#i_filtro_empresa').val('');
            muestraModalEmpresasFiscalesGenerica('renglon_empresa','t_empresa tbody','dialog_buscar_empresa');
        });

        $(document).on('click', '.renglon_empresa', function() {
           
            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            $('#i_empresa_fiscal').attr('alt',id).val(nombre);
            $('#dialog_buscar_empresa').modal('hide');

        });

        $('#b_buscar').on('click',function(){
           
            $('#i_fecha_inicio').val('').prop('disabled',false);
            $('#i_fecha_fin').val('').prop('disabled',false);
           
            buscarIngresos();
        });

        $('#i_fecha_inicio').change(function(){
            if($('#i_fecha_inicio').val() != '')
            {
                $('#i_fecha_fin').prop('disabled',false);
                buscarIngresos();
            }
        });

        $('#i_fecha_fin').change(function(){
            buscarIngresos();
        });

        $('#i_importe').on('change',function(){
            var valor=$(this).val();
            if($(this).validationEngine()){
                $('#i_importe').val(formatearNumero(valor));
            }else{
               
            }
        });

        function buscarIngresos(){
            $('#dialog_buscar_sin_factura').modal('show'); 

            $('#forma').validationEngine('hide');
            $('#i_filtro_ingresos_sin_factura').val('');
            $('.renglon_ingresos_sin_factura').remove();
   
            $.ajax({

                type: 'POST',
                url: 'php/ingresos_sin_factura_buscar.php',
                dataType:"json", 
                data:{
                    'fechaInicio':$('#i_fecha_inicio').val(),
                    'fechaFin':$('#i_fecha_fin').val()
                },
                success: function(data) {
                   
                   if(data.length != 0){

                        $('.renglon_ingresos_sin_factura').remove();
                   
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var estatus='';
                            
                            if(parseInt(data[i].estatus) == 1){

                                estatus='Activa';
                            }else{
                                estatus='Cancelada';
                            }

                            var html='<tr class="renglon_ingresos_sin_factura '+estatus+'" alt="'+data[i].id+'">\
                                        <td data-label="Unidad de Negocio">' + data[i].unidad_negocio+ '</td>\
                                        <td data-label="Sucursal">' + data[i].sucursal+ '</td>\
                                        <td data-label="Área">' + data[i].area+ '</td>\
                                        <td data-label="Departamento Interno">' + data[i].departamento+ '</td>\
                                        <td data-label="Empresa">' + data[i].empresa_fiscal+ '</td>\
                                        <td data-label="Cuenta">' + data[i].cuenta+ '</td>\
                                        <td data-label="Tipo Ingreso">' + data[i].tipo_ingreso+ '</td>\
                                        <td data-label="Fecha">' + data[i].fecha+ '</td>\
                                        <td data-label="Observaciones">' + formatearNumero(data[i].importe)+ '</td>\
                                        <td data-label="Estatus">' + estatus+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_ingresos_sin_factura tbody').append(html);   
                              
                        }
                   }else{
                    var html='<tr class="renglon_ingresos_sin_factura">\
                                        <td colspan="8">No se encontró información</td>\
                                    </tr>';
                        $('#t_ingresos_sin_factura tbody').append(html);  
                   }

                },
                error: function (xhr) {
                    console.log('php/ingresos_sin_factura_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje(' *No se encontró información al buscar ingresos sin factura.');
                }
            });
        }

        $('#t_ingresos_sin_factura').on('click', '.renglon_ingresos_sin_factura', function() {
            tipoMov=1;
            $('input,select,textarea').prop('disabled',true);
            $('#b_guardar').prop('disabled',true);
            
            idIngreso = $(this).attr('alt');
            $('#dialog_buscar_sin_factura').modal('hide');
            muestraRegistro();


        });



        function muestraRegistro(){ 
            $.ajax({
                type: 'POST',
                url: 'php/ingresos_sin_factura_buscar_id.php',
                dataType:"json", 
                data:{
                    'idIngreso':idIngreso
                },
                success: function(data) {
                    $('#d_estatus').removeAttr('class');
                    idIngreso=data[0].id;
                  
                    $('#i_empresa_fiscal').attr('alt',data[0].id_empresa_fiscal).val(data[0].empresa_fiscal);
                    idBanco=data[0].id_banco;
                    
                    var optionTipoIngreso = new Option(data[0].tipo_ingreso, data[0].id_tipo_ingreso, true, true);
                    $('#s_tipo_ingreso').append(optionTipoIngreso).trigger('change');
                    $('#i_fecha').val(data[0].fecha);
                    $('#ta_observaciones').val(data[0].observaciones);
                    $('#i_importe').val(formatearNumero(data[0].importe));
                  
                    $('#s_id_unidad').val(data[0].id_unidad_negocio);
                    $("#s_id_unidad").select2({
                        templateResult: setCurrency,
                        templateSelection: setCurrency
                    });
                    $('.img-flag').css({'width':'50px','height':'20px'}); //Cambia el tamaño de la imagen que se mostrara en el selectB

                    var optionSurucursal = new Option(data[0].sucursal, data[0].id_sucursal, true, true);
                    $('#s_id_sucursal').append(optionSurucursal).trigger('change');
                    //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso
                    muestraCuentasBancosCajaChicaSucursal('s_cuenta',data[0].id_unidad_negocio,data[0].id_sucursal);

                    var optionCuenta = new Option(data[0].cuenta, data[0].id_cuenta_banco, true, true);
                    $('#s_cuenta').append(optionCuenta).trigger('change');

                    var optionArea = new Option(data[0].area, data[0].id_area, true, true);
                    $('#s_id_area').append(optionArea).trigger('change');

                    var optionDepto = new Option(data[0].departamento, data[0].id_departamento, true, true);
                    $('#s_id_departamento').append(optionDepto).trigger('change').prop('disabled',true);

                    if(data[0].estatus == 1){
                        $('#d_estatus').addClass('alert alert-sm alert-info').text('ACTIVA');
                        habilita();

                    }
                    if(data[0].estatus == 0){
                        $('#d_estatus').addClass('alert alert-sm alert-danger').text('CANCELADA');
                        deshabilita();
                    }
                   
                },
                error: function (xhr) {
                    console.log('php/ingresos_sin_factura_buscar_id.php-->'+JSON.stringify(xhr));
                    mandarMensaje(xhr.responseText);
                }
            });
        }

        function habilita(){
            $('#b_guardar').prop('disabled',true);
            $('#b_cancelar').prop('disabled',false);
        }

        function deshabilita(){
            $('#b_guardar').prop('disabled',true);
            $('#b_cancelar').prop('disabled',true);
        }

        $('#b_guardar').click(function(){
          
           $('#b_guardar').prop('disabled',true);

            if ($('#forma').validationEngine('validate')){
                
               guardar();

            }else{
               
                $('#b_guardar').prop('disabled',false);
            }
        });

        
        /* funcion que manda a generar la insecion o actualizacion de un registro */    
        function guardar(){

            $.ajax({
                type: 'POST',
                url: 'php/ingresos_sin_factura_guardar.php', 
                dataType:"json", 
                data: {
                        'datos':obtenerDatos()

                },
                //una vez finalizado correctamente
                success: function(data){
                  
                    if (data > 0 ) {
                        if (tipoMov == 0){
                            
                            mandarMensaje('Se guardó el nuevo registro');
                            $('#b_nuevo').click();
    
                        }else{
                                
                            mandarMensaje('Se canceló correctamente el registro');
                            $('#b_nuevo').click();
                               
                        }
                      

                    }else{
                           
                        mandarMensaje('Error en el guardado');
                        $('#b_guardar').prop('disabled',false);
                    }

                },
                    //si ha ocurrido un error
                 error: function(xhr){
                    console.log('php/ingresos_sin_factura_guardar.php-->'+JSON.stringify(xhr));
                    mandarMensaje("Ha ocurrido un error.");
                    $('#b_guardar').prop('disabled',false);
                }
            });
           
        }
        /* obtine los datos y los guarda en un arreglo*/
        //-->NJES INGRESOS SIN FACTURA (1) 
        //* Agregar campos para especificar la Unidad de Negocio, la sucursal, el área y el departamento interno. Por default se debe mostrar seleccionada el área FINANZAS . 
        //*  Afectar los presupuestos de ingreso de acuerdo a la clasificación Unidad de Negocio – Sucursal – Área – Departamento Interno de los ingresos sin factura.
        // Dic/19/2019<--//
        function obtenerDatos(){
            var paquete = [];
                paquete[0]= 1;
            var cont = 0;

            let unidad = $('#s_id_unidad').val();
            let sucursal = 0;
            let area = 0;
            let dept = 0;
            let empr = 0;
            let fondeo = 0;

            // if($('#i_empresa_fiscal').attr('alt') != "" && $('#i_empresa_fiscal').attr('alt') != 0 && $('#i_empresa_fiscal').attr('alt') != NULL){
            //     empr = $('#i_empresa_fiscal').attr('alt');
            // }

            
            if ($('#ch_sin_unidad').is(':checked')) {
                unidad = 0;
            }

            if ($('#ch_fondeo').is(':checked')) {
                fondeo = 1;
            }

            if($('#s_id_sucursal').val() != 0 && $('#s_id_sucursal').val() != "" && $('#s_id_sucursal').val() != null){
                sucursal = $('#s_id_sucursal').val();
            }

            // if($('#s_id_area').val() != 0 && $('#s_id_area').val() != "" && $('#s_id_area').val() != NULL){
            //     area = $('#s_id_area').val();
            // }

            // if($('#s_id_departamento').val() != 0 && $('#s_id_departamento').val() != "" && $('#s_id_departamento').val() != NULL){
            //     dept = $('#s_id_departamento').val();
            // }

            var paq = {
                    'tipoMov'   : tipoMov,
                    'idUsuario' : idUsuario,
                    'idIngreso' : idIngreso,
                    'idEmpresa' : empr,
                    'idBanco' : idBanco,
                    'cuenta' : $('#s_cuenta').val(),
                    'idTipoIngreso' : $('#s_tipo_ingreso').val(),
                    'fecha' : $('#i_fecha').val(),
                    'observaciones' :  $('#ta_observaciones').val(),
                    'importe' :  quitaComa($('#i_importe').val()),
                    'justificacion' :  $('#ta_justificacion').val(),
                    'tipoCuenta' : $('#s_cuenta option:selected').attr('alt2'),
                    'descripcion' : $('#s_cuenta option:selected').text(),
                    'idUnidadNegocio': unidad,
                    'idSucursal': sucursal,
                    'idArea': area,
                    'idDepartamento': dept,
                    fondeo
                }
                paquete.push(paq);
              
            return paquete;
        }    
       
    
        $('#b_nuevo').on('click',function(){
            limpiar();
        });
        /* Limpia el modulo comple al dar click en nuevo o guardad*/
        function limpiar(){
         
            idIngreso=0;
            tipoMov=0;
            idBanco=0;
           
            $('input,textarea,select').val('').prop('disabled',false);
            $('#i_empresa_fiscal').attr('alt',0);
            $('#i_banco').attr('alt',0);
            $('form').validationEngine('hide');
            $('#b_guardar').prop('disabled',false);
            $('#b_cancelar').prop('disabled',true);


            mostrarBotonAyuda(modulo);
            //--> NJES Jan/21/2020 mostrar solo las cuentas bancos y la caja chica de la sucursal seleccionada 
            $('#s_cuenta').html('');
            muestraTiposIngresos('s_tipo_ingreso');
          
            $('#i_fecha').val(hoy);
            $('#d_estatus').removeAttr('class').text('');
          
            muestraSelectUnidades(matriz, 's_id_unidad', idUnidadActual);
            muestraSucursalesPermiso('s_id_sucursal', idUnidadActual, modulo,idUsuario);
            muestraAreasAccesoValor('s_id_area',3);
            $('#s_id_departamento').html('');
            $('#ch_sin_unidad').prop('checked',false);
            $('#ch_fondeo').prop('checked',false);
        }

        $('#b_cancelar').on('click',function(){
           
            $('#dialog_justificacion').modal('show');
            $('#b_cancelar_registro').prop('disabled',false);
            $('#form_justificacion').validationEngine('hide');
            $('#ta_justificacion').prop('disabled',false);
        });

        $(document).on('click','#b_cancelar_registro',function(){

            $('#b_cancelar_registro').prop('disabled',true);
            if($('#form_justificacion').validationEngine('validate')){
                tipoMov=1;
                guardar();
                $('#dialog_justificacion').modal('hide');
            }else{
                $('#b_cancelar_registro').prop('disabled',false);
            }
            
        });
       

    });

</script>

</html>