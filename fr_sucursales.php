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
                        <div class="titulo_ban">Sucursales</div>
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
                <br><br>

                <div class="row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <form id="forma" name="forma">
                            <div class="form-group row">
                                <label for="s_id_unidades" class="col-sm-2 col-md-2 col-form-label requerido">Unidad de Negocio </label>
                                <div class="col-sm-12 col-md-4">
                                    <select id="s_id_unidades" name="s_id_unidades" class="form-control validate[required]" autocomplete="off"></select>
                                </div>
                                <div class="col-sm-12 col-md-2"></div>
                                <label for="i_id" class="col-sm-12 col-md-1 col-form-label">ID </label>
                                <div class="col-sm-12 col-md-2">
                                <input type="text" id="i_id" name="i_id" class="form-control" readonly/>
                                </div>
                            </div>
                            <div class="row">
                                <label for="i_clave" class="col-sm-2 col-md-2 col-form-label requerido">Clave </label>
                                <div class="col-sm-12 col-md-3">
                                    <input type="text" id="i_clave" name="i_clave" class="form-control validate[required]" autocomplete="off"/>
                                </div>
                               
                            </div>
                            <br>
                            <div class="row">
                                <label for="i_nombre_corto" class="col-sm-2 col-md-2 col-form-label requerido">N-Corto </label>
                                <div class="col-sm-12 col-md-3">
                                    <input type="text" id="i_nombre_corto" name="i_nombre_corto" class="form-control validate[required]" autocomplete="off"/>
                                </div>
                                
                                <label for="i_descripcion" class="col-sm-2 col-md-2 col-form-label requerido">Descripción </label>
                                <div class="col-sm-12 col-md-4">
                                    <input type="text" id="i_descripcion" name="i_descripcion" class="form-control validate[required]" autocomplete="off"/>
                                </div>
                               
                            </div>  
                             <br>
                            <p class="text-light bg-info">&nbsp;&nbsp; Domicilio de la Sucursal</p>
                            <div class="form-group row">
                                <label for="i_domicilio" class="col-2 col-md-2 col-form-label requerido">Domicilio </label><br>
                                <div class="col-sm-12 col-md-4">
                                    <input type="text" class="form-control validate[required]" id="i_domicilio">
                                </div>

                                <label for="i_num_ext" class="col-1 col-md-1 col-form-label requerido">Ext </label><br>
                                <div class="col-sm-2 col-md-2">
                                    <input type="text" class="form-control validate[required]" id="i_num_ext">
                                </div>

                                <label for="i_num_int" class="col-1 col-md-1 col-form-label requerido">Int </label><br>
                                <div class="col-sm-2 col-md-2">
                                    <input type="text" class="form-control validate[required]" id="i_num_int">
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
                                    <select id="s_pais" name="s_pais" class="form-control validate[required]"></select>
                                </div>
                                
                            </div>

                            <div class="form-group row">
                                <label for="i_colonia" class="col-sm-2 col-md-2 col-form-label requerido">Colonia </label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="text" class="form-control validate[required]" id="i_colonia" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_id_municipio" class="col-2 col-md-2 col-form-label requerido">Municipio </label><br>
                                <div class="col-sm-2 col-md-2">
                                    <input type="text" class="form-control validate[required]" id="i_id_municipio" disabled>
                                </div>
                                <div class="col-sm-2 col-md-8">
                                    <input type="text" class="form-control validate[required]" id="i_municipio" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_id_estado" class="col-2 col-md-2 col-form-label requerido">Estado </label><br>
                                <div class="col-sm-2 col-md-2">
                                    <input type="text" class="form-control validate[required]" id="i_id_estado" disabled>
                                </div>
                                <div class="col-sm-2 col-md-8">
                                    <input type="text" class="form-control validate[required]" id="i_estado" disabled>
                                </div>
                            </div>
                           <hr style="border:1px solid #17A2B8;">
                          
                           <br> 
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group row">
                                        <label for="ch_nomina" class="col-sm-3 col-md-2">Nómina</label>
                                        <div class="col-sm-2 col-md-2">
                                            <input type="checkbox" id="ch_nomina" name="ch_nomina" value="">
                                        </div>
                                   </div>
                                    <div class="form-group row">
                                        <label for="ch_inactivo" class="col-sm-2 col-md-2">Inactivo</label>
                                        <div class="col-sm-10 col-md-2">
                                            <input type="checkbox" id="ch_inactivo" name="ch_inactivo" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-2"></div>
                                        <div class="col-sm-12 col-md-8">
                                            <button type="button" class="btn btn-primary btn-sm form-control" id="b_montos_nomina"><i class="fa fa-building-o" aria-hidden="true"></i> Montos de Nómina</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-2"></div>
                                        <div class="col-sm-12 col-md-8">
                                            <button type="button" class="btn btn-success btn-sm form-control verificar_permiso" alt="BOTON_EXCEL_SUCURSALES" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
                    <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
                    <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
                    <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
                </form>

            <br>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
</body>

<div id="dialog_buscar_sucursales" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Sucursales</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_sucursales" id="i_filtro_sucursales" class="form-control filtrar_renglones" alt="renglon_sucursales" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_sucursales">
                        <thead>
                            <tr class="renglon">
                                <th scope="col">Id Sucursal</th>
                                <th scope="col">Unidad Negocio</th>
                                <th scope="col">Clave Sucursal</th>
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
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
</div>

<div id="dialog_montos_nomina" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Montos de Nómina</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="forma_montos_nomina" name="forma_montos_nomina">
                <div class="form-group row">
                    <label for="ch_descuento_dia" class="col-sm-3 col-md-4">Descuento de día 28 ó 29</label>
                    <div class="col-sm-2 col-md-1">
                        <input type="checkbox" id="ch_descuento_dia" name="ch_descuento_dia" value="">
                    </div>
                    <label for="ch_descuento_caja" class="col-sm-3 col-md-3 col-form-label">Descuento de Caja </label>
                    <div class="col-sm-2 col-md-1">
                        <input type="checkbox" id="ch_descuento_caja" name="ch_descuento_caja" value="">
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <input type="text" id="i_descuento_caja" name="i_descuento_caja" class="form-control validate[custom[number]]" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="ch_anticipos" class="col-sm-2 col-md-2">Anticipos</label>
                    <div class="col-sm-10 col-md-1">
                        <input type="checkbox" id="ch_anticipos" name="ch_anticipos" value="">
                    </div>
                    <label for="ch_anticipos_administrativa" class="col-sm-4 col-md-4">Anticipos Nómina Administrativa</label>
                    <div class="col-sm-10 col-md-2">
                        <input type="checkbox" id="ch_anticipos_administrativa" name="ch_anticipos_administrativa" value="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6"></div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group row">
                            <label for="s_sucursales_ref" class="col-sm-12 col-md-12 col-form-label">Valores de referencia</label>
                            <div class="col-sm-12 col-md-12">
                                <select id="s_sucursales_ref" name="s_sucursales_ref" class="form-control" style="width:100%;"></select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <br>
                        <button type="button" class="btn btn-info btn-sm form-control" id="b_copiar"><i class="fa fa-clone" aria-hidden="true"></i> Copiar</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Clave</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Importe</th>
                                    <th scope="col"></th>
                                    <th scope="col">Importe</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_t_montos_nomina">
                            <table class="tablon"  id="t_montos_nomina">
                                <tbody>
                                    
                                </tbody>
                            </table>  
                        </div>  
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <button type="button" class="btn btn-warning btn-sm form-control" id="b_solicitar_nomina"><i class="fa fa-paper-plane" aria-hidden="true"></i> Solicitar alta o modificación de sucursal</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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

<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
  
    var idSucursal=0;
    var claveOriginal='';
    var nombreOriginalSucursal='';
    var tipo_mov=0;
    var modulo='SUCURSALES';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUnidadNegocio=0;
    var nombreUnidadN='';
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;

    var matriz = <?php echo $_SESSION['sucursales']?>;
    $(function(){

        mostrarBotonAyuda(modulo);
        muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);

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

        $('#b_solicitar_nomina').prop('disabled',true);
        $('#b_copiar').prop('disabled',true);

        $('#ch_inactivo').prop('checked',false).attr('disabled',true);

        habilitaBotonMontosNomina();
        habilitaInputDescuentoCaja();
        muestraNominaMotivos();

        muestraUnidadesTodas('s_id_unidades', idUnidadActual);

        muestraSelectPaises('s_pais');
        muestraSelectEstados('s_estado');
        muestraSelectMunicipios('s_municipio',0);

        $('#s_estado').change(function(){
            muestraSelectMunicipios('s_municipio',$('#s_estado').val());
        });
       
       
        $('#b_buscar').on('click',function(){

            $('#forma').validationEngine('hide');
            $('#i_filtro_sucursales').val('');
            $('.renglon_sucursales').remove();
            
            $.ajax({

                type: 'POST',
                url: 'php/sucursales_buscar.php',
                dataType:"json", 
                data:{'estatus':2,'lista':listaUnidadesNegocioId(matriz)},

                success: function(data) {
                   if(data.length != 0){

                        $('.renglon_sucursales').remove();
                   
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var activo='';
                            
                            if(parseInt(data[i].activo) == 1){

                                activo='Activo';
                            }else{
                                activo='Inactivo';
                            }

                            var html='<tr class="renglon_sucursales" alt="'+data[i].id_sucursal+'" alt2="'+data[i].id_unidad_negocio+'" data-nom_unidad="'+data[i].nombre_unidad_negocio+'">\
                                        <td data-label="Id Sucursal">' + data[i].id_sucursal+ '</td>\
                                        <td data-label="Unidad Negocio">' + data[i].nombre_unidad_negocio+ '</td>\
                                        <td data-label="Clave Sucursal">' + data[i].clave+ '</td>\
                                        <td data-label="Descripción">' + data[i].nombre+ '</td>\
                                        <td data-label="Estatus">' + activo+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_sucursales tbody').append(html);   
                            $('#dialog_buscar_sucursales').modal('show');   
                        }
                   }else{

                        mandarMensaje('No se encontró información');
                   }

                },
                error: function (xhr) {
                    mandarMensaje('Error en el sistema '+xhr.responseText);
                }
            });
        });

        $('#t_sucursales').on('click', '.renglon_sucursales', function() {
            
            tipo_mov = 1;
            $('#b_guardar').prop('disabled',false);
            idSucursal = $(this).attr('alt');
            idUnidadNegocio = $(this).attr('alt2');
            nombreUnidadN=$(this).data('nom_unidad');
            $('#dialog_buscar_sucursales').modal('hide');
            muestraRegistro();
            $('#b_solicitar_nomina').prop('disabled',false);
            muestraNominaMotivosIdSucursal();
        });

        function muestraRegistro(){ 
        
            $.ajax({
                type: 'POST',
                url: 'php/sucursales_buscar_id.php',
                dataType:"json", 
                data:{
                    'idSucursal':idSucursal
                },
                success: function(data) {
                    
                    claveOriginal=data[0].clave;
                    nombreOriginalSucursal = data[0].nombre;

                    $('#s_id_unidades').val(data[0].id_unidad_negocio);
                    $("#s_id_unidades").select2({
                        templateResult: setCurrency,
                        templateSelection: setCurrency
                    });
                    $('.img-flag').css({'width':'50px','height':'20px'}); //Cambia el tamaño de la imagen que se mostrara en el select
                    
                    $('#i_id').val(data[0].id_sucursal);
                    $('#i_clave').val(data[0].clave);
                    $('#i_nombre_corto').val(data[0].nombre);
                    $('#i_descripcion').val(data[0].descr);

                    $('#i_domicilio').val(data[0].calle);
                    $('#i_cp').val(data[0].codigopostal);
                    $('#i_colonia').val(data[0].colonia);
                    $('#i_num_ext').val(data[0].no_exterior);
                    $('#i_num_int').val(data[0].no_interior);

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
        
                    if (data[0].activo == 1) {
                        $('#ch_inactivo').prop('checked', false).attr('disabled',false);
                    } else {
                        $('#ch_inactivo').prop('checked', true).attr('disabled',false);
                    }

                    if(data[0].dia_28 == 0 && data[0].anticipo == 0 && data[0].anticipo_a == 0 && data[0].descuento_caja == 0){
                        $('#ch_nomina').prop('checked', false);
                        habilitaBotonMontosNomina();
                    } else {
                        $('#ch_nomina').prop('checked', true);
                        habilitaBotonMontosNomina();
                    }

                    if (data[0].dia_28 != 0) {
                        $('#ch_descuento_dia').prop('checked', true);
                    }else{
                        $('#ch_descuento_dia').prop('checked', false);
                    }

                    if (data[0].anticipo != 0) {
                        $('#ch_anticipos').prop('checked', true);
                    }else{
                        $('#ch_anticipos').prop('checked', false);
                    }

                    if (data[0].anticipo_a != 0) {
                        $('#ch_anticipos_administrativa').prop('checked', true);
                    }else{
                        $('#ch_anticipos_administrativa').prop('checked', false);
                    }

                    if (data[0].descuento_caja != 0) {
                        $('#ch_descuento_caja').prop('checked', true);
                        habilitaInputDescuentoCaja();
                        $('#i_descuento_caja').val(formatearNumero(data[0].monto_descuento_caja));
                    }else{
                        $('#ch_descuento_caja').prop('checked', false);
                        habilitaInputDescuentoCaja();
                        $('#i_descuento_caja').val('');
                    }

                },
                error: function (xhr) {
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        $('#b_guardar').click(function(){
           
            $('#b_guardar').prop('disabled',true);

            if ($('#forma').validationEngine('validate')){
                
                verificar();

            }else{
               
                $('#b_guardar').prop('disabled',false);
            }
        });


        function verificar(){

            $.ajax({
                type: 'POST',
                url: 'php/sucursales_verificar.php',
                dataType:"json", 
                data:  {'clave':$('#i_clave').val()},
                success: function(data) 
                {
                    if(data == 1){
                        
                        if (tipo_mov == 1 && claveOriginal === $('#i_clave').val()) {
                            guardar();
                        } else {

                            mandarMensaje('La clave: '+ $('#i_clave').val()+' ya existe intenta con otra');
                            $('#i_clave').val('');
                            $('#b_guardar').prop('disabled',false);
                        }
                    } else {
                        guardar();
                    }
                },
                error: function (xhr) {
                    console.log('php/sucursales_verificar.php -->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de verificar sucursal');
                    $('#b_guardar').prop('disabled',false);
                }
            });
        }

        
        /* funcion que manda a generar la insecion o actualizacion de un registro */
        function guardar(){
            var datos = Array();

            datos ={
                'idSucursal':idSucursal,
                'id_unidad_negocio':$('#s_id_unidades').val(),
                'clave':$('#i_clave').val(),
                'nombre':$('#i_nombre_corto').val(),
                'descripcion':$('#i_descripcion').val(),

                'calle':$('#i_domicilio').val(),
                'no_exterior':$('#i_num_ext').val(),
                'no_interior':$('#i_num_int').val(),
                'colonia':$('#i_colonia').val(),
                'codigo_postal':$('#i_cp').val(),
                'id_pais':$('#s_pais').val(),
                'id_estado':$('#i_id_estado').val(),
                'id_municipio':$('#i_id_municipio').val(),

                'nomina':$('#ch_nomina').is(':checked') ? 1 : 0,
                'inactivo':$('#ch_inactivo').is(':checked') ? 0 : 1,
                'ch_descuento_dia':$('#ch_descuento_dia').is(':checked') ? 1 : 0,
                'ch_anticipos':$('#ch_anticipos').is(':checked') ? 1 : 0,
                'ch_anticipos_administrativa':$('#ch_anticipos_administrativa').is(':checked') ? 1 : 0,
                'ch_descuento_caja':$('#ch_descuento_caja').is(':checked') ? 1 : 0,
                'descuento_caja':quitaComa($('#i_descuento_caja').val()),
                'tipo_mov':tipo_mov
            }

            $.ajax({
                type: 'POST',
                url: 'php/sucursales_guardar.php',  
                dataType: 'json',
                data:{'datos':datos},
                success: function(data)
                {
                    if(data > 0)
                    {
                        if(tipo_mov == 0)
                        {
                            mandarMensaje('Se guardó el nuevo registro');
                            limpiar();
                        }else{
                            mandarMensaje('Se actualizó el registro');
                            limpiar();
                        }
                    }else{
                        mandarMensaje('Error en el guardado');
                        $('#b_guardar').prop('disabled',false);
                    }
                },
                //si ha ocurrido un error
                error: function(xhr){
                    console.log('php/sucursales_guardar.php -->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al guardar sucursal');
                    $('#b_guardar').prop('disabled',false);
                }
            });
        }

        $('#ch_nomina').change(function(){
            habilitaBotonMontosNomina();
        });

        function habilitaBotonMontosNomina(){
            if($('#ch_nomina').is(':checked')){
                $('#b_montos_nomina').prop('disabled',false);
            }else{
                $('#b_montos_nomina').prop('disabled',true);
            }
        }

        $('#ch_descuento_caja').change(function(){
            habilitaInputDescuentoCaja();
        });

        function habilitaInputDescuentoCaja(){
            if($('#ch_descuento_caja').is(':checked')){
                $('#i_descuento_caja').prop('disabled',false);
            }else{
                $('#i_descuento_caja').prop('disabled',true);
            }
        }

        $('#b_montos_nomina').click(function(){
            muestraSucursalesReferencia();
            $('#dialog_montos_nomina').modal('show');
        });

        $('#b_nuevo').on('click',function(){
            limpiar();
        });

        /*Limpia el modulo comple al dar click en nuevo o guardad*/
        function limpiar(){

            $('input,textarea').val('');
            $('form').validationEngine('hide');
            $('#b_guardar').prop('disabled',false);
            $('#ch_inactivo').prop('checked',false).attr('disabled',true);
            $('#ch_nomina').prop('checked',false);
            $('#ch_descuento_dia').prop('checked', false);
            $('#ch_anticipos').prop('checked', false);
            $('#ch_anticipos_administrativa').prop('checked', false);
            $('#ch_descuento_caja').prop('checked', false);
            $('#b_copiar').prop('disabled',true);
            habilitaInputDescuentoCaja();
            habilitaBotonMontosNomina();

            $('#s_id_unidades').val(idUnidadActual);
            $("#s_id_unidades").select2({
                templateResult: setCurrency,
                templateSelection: setCurrency
            });
            $('.img-flag').css('height','20px'); //Cambia el tamaño de la imagen que se mostrara en el select
            
            idSucursal=0;
            tipo_mov=0;
            claveOriginal='';
            nombreOriginalSucursal='';

            limpiaSelectPaisesEstadosMunicipios('s_pais','s_estado','s_municipio');
            muestraNominaMotivos();

            $('#s_sucursales_ref').val('');
            $('#s_sucursales_ref').select2({placeholder: 'Selecciona'});

            $('#b_solicitar_nomina').prop('disabled',true);
        }

        /*Muestra las sucursales que tienen info en tabla motivos y que sean de las unidad de negocio seleccionada*/
        function muestraSucursalesReferencia(){
            $('#s_sucursales_ref').select2();

            $('#s_sucursales_ref').html('');
            var html='';
            html='<option value="" disabled selected>Selecciona</option>';
            $('#s_sucursales_ref').append(html);
            
            $.ajax({
                type: 'POST',
                url: 'php/motivos_buscar_opciones_sucursales.php',
                dataType:"json", 
                data:{'idUnidadNegocio':idUnidadNegocio},
                success: function(data) {
                    console.log(data);
                    if(data!=0){
                        var arreglo=data;
                        for(var i=0;i<arreglo.length;i++){
                            var dato=arreglo[i];
                            
                            html+='<option value="'+dato.id_sucursal+'">'+dato.descr+'</option>';
                        }
                        $('#s_sucursales_ref').html(html);
                    }

                },
                error: function (xhr) {  
                    console.log('php/motivos_buscar_opciones_sucursales.php -->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de sucursales de referencia');
                }
            });
        }

        $('#s_sucursales_ref').change(function(){
            var id_referencia=$('#s_sucursales_ref').val();

            importesReferencia(id_referencia,'#i_motivo_ref_');
            $('#b_copiar').prop('disabled',false);
        });

        function importesReferencia(id_referencia,input){

            //--toma el id de la unidad con la que esta guardada la sucursal,
            //--no el que se haya seleccionado en ese momento ni la unidad actual
            $.ajax({
                type: 'POST',
                url: 'php/motivos_buscar_importe_referencia.php',
                dataType:"json", 
                data:{'id_referencia':id_referencia}, 
                success: function(data) {

                    if(data!=0){
                        var arreglo=data;
                        for(var i=0;i<arreglo.length;i++){
                            var dato=arreglo[i];

                            if(dato.importe > 0){
                                var importe=dato.importe;
                            }else{
                                var importe='';
                            }
                            
                            $(input+''+dato.id_motivo).val(importe);
                        }
                    }

                },
                error: function (xhr) {  
                    console.log('php/motivos_buscar_opciones_sucursales.php -->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar los importes de la sucursal referencia');
                }
            });
        }

        $('#b_copiar').click(function(){
            var id_referencia=$('#s_sucursales_ref').val();

            importesReferencia(id_referencia,'#i_motivo_');
        });

        /*Obtengo los registros de la tabla motivos que son la referencia para los montos de la nomina*/
        function muestraNominaMotivos(){

            $.ajax({
                type: 'POST',
                url: 'php/motivos_buscar.php',
                dataType:"json", 
                success: function(data) {
                    if(data.length != 0){

                        $('.renglon_motivos').remove();
                
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_motivos" alt="'+data[i].id_motivo+'">\
                                        <td data-label="Clave" class="td_clave"><input type="text" class="form-control validate[custom[number]]" disabled value="'+data[i].clave+'"></td>\
                                        <td data-label="Descripción" class="td_descripcion"><input type="text" class="form-control validate[custom[number]]" disabled value="'+data[i].descr+'"></td>\
                                        <td data-label="Importe"><input id="i_motivo_'+data[i].id_motivo+'" type="text" class="importe_motivos form-control validate[custom[number]]" value=""></td>\
                                        <td scope="col"></td>\
                                        <td data-label="Importe Referencia"><input id="i_motivo_ref_'+data[i].id_motivo+'" type="text" class="motivo_referencia form-control validate[custom[number]]" disabled></td>\
                                        <td scope="col"></td>\
                                    </tr>';  
                            
                            $('#t_montos_nomina').append(html);  
                        }

                    }else{

                        mandarMensaje('No se encontró información');
                    }

                },
                error: function (xhr) {
                    console.log('php/motivos_buscar.php -->'+JSON.stringify(xhr));
                    console.log('* No se encontró información de motivos sucursal');
                }
            });
        }

        /*Obtengo los registros de la tabla motivos que son la referencia para los montos de la nomina 
            al seleccionar un registro de sucursal*/
        function muestraNominaMotivosIdSucursal(){
            //--toma el id de la unidad con la que esta guardada la sucursal,
            //--no el que se haya seleccionado en ese momento ni la unidad actual
            $.ajax({
                type: 'POST',
                url: 'php/motivos_buscar_id_sucursal.php',
                dataType:"json", 
                data:{'idSucursal':idSucursal},
                success: function(data) {
                if(data.length != 0){

                        $('.renglon_motivos').remove();
                
                        for(var i=0;data.length>i;i++){

                            if(data[i].importe > 0){
                                var importe=data[i].importe;
                            }else{
                                var importe='';
                            }

                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_motivos" alt="'+data[i].id_motivo+'">\
                                        <td data-label="Clave" class="td_clave"><input type="text" class="form-control validate[custom[number]]" disabled value="'+data[i].clave+'"></td>\
                                        <td data-label="Descripción" class="td_descripcion"><input type="text" class="form-control validate[custom[number]]" disabled value="'+data[i].descr+'"></td>\
                                        <td data-label="Importe"><input id="i_motivo_'+data[i].id_motivo+'" type="text" class="importe_motivos form-control validate[custom[number]]" value="'+formatearNumero(importe)+'"></td>\
                                        <td scope="col"></td>\
                                        <td data-label="Importe Referencia"><input id="i_motivo_ref_'+data[i].id_motivo+'" type="text" class="motivo_referencia form-control validate[custom[number]]" disabled></td>\
                                        <td scope="col"></td>\
                                    </tr>';  
                            
                            $('#t_montos_nomina').append(html);  
                        }

                }else{

                        mandarMensaje('No se encontró información');
                }

                },
                error: function (xhr) {
                    console.log('php/motivos_buscar_id_sucursal.php -->'+JSON.stringify(xhr));
                    console.log('* No se encontró información, probablemente no se han asignado montos a la nomina para la sucursal');
                }
            });
        }

        $('#b_solicitar_nomina').click(function(){
            $('#b_solicitar_nomina').prop('disabled',true);
            //--toma el id de la unidad con la que esta guardada la sucursal,
            //--no el que se haya seleccionado en ese momento ni la unidad actual

            //console.log(JSON.stringify(obtenerImportes()));
            var datos_importe = obtenerImportes();
            
            $.ajax({
                type: 'POST',
                url: 'php/motivos_solicitar.php',  
                dataType: 'json',
                data:{'idSucursal':idSucursal,'sucursal':nombreOriginalSucursal/*claveOriginal*/,'datos_importe':datos_importe},
                success: function(data)
                {   
                    if(data == 1)
                    {
                        mandarMensaje('Solicitud enviada');
                    }else{
                        mandarMensaje('Error al enviar');
                    }

                    $('#b_solicitar_nomina').prop('disabled',false);
                },
                //si ha ocurrido un error
                error: function(xhr){
                    console.log('php/motivos_solicitar.php -->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de solicitar motivos sucursal');
                    $('#b_solicitar_nomina').prop('disabled',false);
                }
            });
        });

        function obtenerImportes(){
			var j = 0;
			var datos = [];
			
			$(".renglon_motivos").each(function() {//recorre los renglones de tabla t_proceso
				
                if($(this).find('td').eq(2).find('input').val() != '' && parseFloat($(this).find('td').eq(2).find('input').val()) > 0){
                    
                    var id = $(this).attr('alt');
                    var clave = $(this).find('td').eq(0).find('input').val(); //toma el valor del primer input del td
                    var descripcion = $(this).find('td').eq(1).find('input').val();
                    var importe = quitaComa($(this).find('td').eq(2).find('input').val());

                    datos[j] = {
                        'id_motivo':id,
                        'clave':clave,
                        'descripcion':descripcion,
                        'importe':importe
                    };

                    j++;
                }
			});
						
			return datos;
        }
        
        $('#b_excel').click(function(){
            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
            
            $("#i_nombre_excel").val('Registros Sucursales');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val('SUCURSALES');
            
            $("#f_imprimir_excel").submit();
        });


        //************Busca los cp por estado y municipio */
        $('#b_buscar_cp').on('click',function(){
            $('#i_cp').validationEngine('hide');
            $('#i_filtro_cp').val('');
            $('.renglon_cp').remove();
            muestraSelectEstados('s_estados');
            muestraSelectMunicipios('s_municipios',0);
            $('#dialog_buscar_cp').modal('show'); 

        });

        $(document).on('change','#s_estados',function(){
            buscarCp($('#s_estados').val(),0);
            muestraSelectMunicipios('s_municipios',$('#s_estados').val());
        });
        $(document).on('change','#s_municipios',function(){
            buscarCp($('#s_estados').val(),$('#s_municipios').val());
        });

        function buscarCp(idEstado,idMunicipio){
           
            $('#i_filtro_cp').val('');
            $('.renglon_cp').remove();

            $.ajax({

                type: 'POST',
                url: 'php/codigo_postal_buscar.php',
                dataType:"json", 
                data:{
                    'idEstado':idEstado,
                    'idMunicipio': idMunicipio
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

        
    });

</script>

</html>