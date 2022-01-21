
<?php
session_start();
$idServicio=0;
$regresar=0;
$regresarS=0;
$idSucursal=0;
$razonSocial='';
$nombreCorto='';
$regresar=0;
$reporta=0;
$tipoM='general';
$cuenta = '';

if(isset($_GET['idServicio'])!=0 && $_GET['regresar']==1){

    $idServicio=$_GET['idServicio'];
    $razonSocial=$_GET['razonSocial'];
    $nombreCorto=$_GET['nombreCorto'];
    $cuenta=$_GET['cuenta'];
    $idSucursal=$_GET['idSucursal'];
    $regresar=1;
    $reporta=3;
    $tipoM=$_GET['tipo'];
}
if(isset($_GET['regresarS'])==1){
    $regresarS=1;
}
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

    textarea{
       resize:none;
   }

   #d_estatus_oc{
       padding-top:7px;
       text-align:center;
       font-weight:bold;
       font-size:15px;
       height:40px;
       vertical-align:middle;
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
                        <div class="titulo_ban">Orden de Servicio</div>
                    </div>
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control verificar_permiso" id="b_regresar" alt="SERVICIOS"><i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar A Servicios</button>
                    </div>
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-12 col-md-3">
                        <button type="button" class="btn btn-warning btn-sm form-control verificar_permiso" id="b_seguimiento" alt="ORDENES_PENDIENTES"><i class="fa fa-arrow-right" aria-hidden="true"></i> Pendientes</button>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-2"></div>
               
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
                        <button type="button" class="btn btn-info btn-sm form-control" id="b_imprimir"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>
                    </div>
                </div>
                <br><br>

                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-sm-12 col-md-10">
                        <form id="forma" name="forma">

                            <div class="form-group row">
                                <label for="i_folio" class="col-sm-2 col-md-2 col-form-label ">Folio </label>
                                <div class="col-sm-2 col-md-2">
                                    <input  type="text" id="i_folio" name="i_folio" class="form-control" autocomplete="off" readonly>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <div id="d_estatus_oc" class="alert alert-sm alert-success"></div>
                                </div>
                                <div class="col-sm-12 col-md-1"></div>
                                <label for="i_folio" class="col-sm-1 col-md-1 col-form-label ">Capturó </label>
                                <div class="col-sm-12 col-md-4">
                                    <input type="text" class="form-control" id="i_usuario_captura" name="i_usuario_captura" readonly>
                                </div>
                               
                            </div>
                            <div class="form-group row">
                                <label for="s_id_sucursales" class="col-sm-2 col-md-2 col-form-label requerido">Sucursal </label>
                                <div class="col-sm-4 col-md-4">
                                    <select id="s_id_sucursales" name="s_id_sucursales" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div>
                                <div class="col-sm-2 col-md-2"></div>
                                <label for="i_fecha" class="col-sm-1 col-md-1 col-form-label">Fecha</label>
                                <div class="col-sm-3 col-md-3">
                                    <input type="text" class="form-control" id="i_fecha" readonly>
                                </div>
                               
                            </div>

                            <div class="form-group row">
                                <label for="i_cliente" class="col-2 col-md-2 col-form-label requerido">Cliente </label><br>
                                <div class="col-sm-12 col-md-6">
                                    <div class="row">
                                        <div class="input-group col-sm-12 col-md-12">
                                            <input type="text" id="i_cliente" name="i_cliente" class="form-control validate[required]" readonly autocomplete="off">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary" type="button" id="b_buscar_clientes" style="margin:0px;">
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <label for="i_cuenta" class="col-sm-1 col-md-1 col-form-label">Cuenta</label>
                                <div class="col-sm-3 col-md-3">
                                    <input type="text" class="form-control" id="i_cuenta" readonly>
                                </div>
                               
                            </div>

                            <div class="form-group row">
                                <label for="i_servicio" class="col-sm-2 col-md-2 col-form-label requerido">Servicio</label>
                                <div class="col-sm-12 col-md-6">
                                    <input type="text" class="form-control validate[required]" id="i_servicio" name="i_servicio" value="INSTALACIÓN" autocomplete="off">
                                </div>
                                <label for="s_reporta" class="col-sm-1 col-md-1 col-form-label requerido">Reporta </label>
                                <div class="col-sm-3 col-md-3">
                                    <select class="form-control validate[required]" id="s_reporta" name="s_reporta"></select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="ta_descripcion" class="col-sm-2 col-md-2 col-form-label requerido">Descripción</label>
                                <div class="col-sm-12 col-md-10">
                                    <textarea class="form-control validate[required]" id="ta_descripcion" name="ta_descripcion"></textarea>
                                </div>
                            </div>

                            
                            <div class="form-group row">
                                
                                <label for="s_prioridad" class="col-sm-2 col-md-2 col-form-label requerido">Prioridad </label>
                                <div class="col-sm-2 col-md-2">
                                    <select class="form-control validate[required]" id="s_prioridad" name="s_prioridad"></select>
                                </div>
                                <label for="s_clasificacion_servicios" class="col-sm-2 col-md-2 col-form-label requerido">Clasificación </label>
                                <div class="col-sm-3 col-md-6">
                                    <select class="form-control validate[required]" id="s_clasificacion_servicios" name="s_clasificacion_servicios"></select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="row">
                                        <label for="i_fecha_servicio" class="col-sm-12 col-md-7 col-form-label">Fecha Programada de Servicio</label>
                                        <div class="input-group col-sm-12 col-md-5">
                                            <input type="text" name="i_fecha_servicio" id="i_fecha_servicio" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                                            <div class="input-group-addon input_group_span">
                                                <span class="input-group-text">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="row">
                                        <label for="i_fecha_solicitud" class="col-sm-12 col-md-7 col-form-label requerido">Fecha Solicitud de Servicio</label>
                                        <div class="input-group col-sm-12 col-md-5">
                                            <input type="text" name="i_fecha_solicitud" id="i_fecha_solicitud" class="form-control form-control-sm fecha validate[required]" alt="EDITAR_FECHA_SOLICITUD" autocomplete="off" readonly>
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
                        </form>

                    </div>
                </div>

            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
</body>

<div id="dialog_buscar_ordenes_servicios" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda Ordenes de Servicio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="form-group row">
                <label for="s_id_sucursales_filtro" class="col-sm-2 col-md-2 col-form-label">Sucursal </label>
                <div class="col-sm-3 col-md-5">
                    <select id="s_id_sucursales_filtro" name="s_id_sucursales_filtro" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <input type="text" name="i_filtro_ordenes" id="i_filtro_ordenes" class="form-control filtrar_renglones" alt="renglon_ordenes" placeholder="Filtrar" autocomplete="off">
                </div>
                <div class="col-sm-12 col-md-1">Del: </div>
                <div class="input-group col-sm-12 col-md-3">
                    <input type="text" name="i_fecha_inicio" id="i_fecha_inicio" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                    <div class="input-group-addon input_group_span">
                        <span class="input-group-text">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-md-1">Al: </div>
                <div class="input-group col-sm-12 col-md-3">
                    <input type="text" name="i_fecha_fin" id="i_fecha_fin" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                    <div class="input-group-addon input_group_span">
                        <span class="input-group-text">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
                
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_ordenes">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Sucursal</th>
                          <th scope="col">Folio</th>
                          <th scope="col">Fecha Programada</th>
                          <th scope="col">Cliente</th>
                          <th scope="col">Servicio</th>
                          <th scope="col">Prioridad</th>
                          <th scope="col">Estatus</th>
                          <th scope="col">Usuario</th>
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

<div id="dialog_buscar_servicios" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Servicios</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_servicios" id="i_filtro_servicios" class="form-control filtrar_renglones" alt="renglon_servicios" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_servicios">
                      <thead>
                        <tr class="renglon">
                          <th scope="col" width="15%">Sucursal</th>
                          <th scope="col" width="10%">Cuenta</th>
                          <th scope="col" width="10%">RFC</th>
                          <th scope="col" width="10%">Nombre Corto</th>
                          <th scope="col" width="15%">Razon Social</th>
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
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="js/general.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
  
    var idOrdenServicio=0;
    var idServicio=<?php echo $idServicio?>;
    var razonSocial='<?php echo $razonSocial?>';
    var nombreCorto='<?php echo $nombreCorto?>';
    var cuenta='<?php echo $cuenta?>';
    var idSucursal='<?php echo $idSucursal?>';
    var regresar=<?php echo $regresar?>;
    var regresarS=<?php echo $regresarS?>;
    var reporta=<?php echo $reporta?>;
    var tipoM = '<?php echo $tipoM ?>';
    var tipoMov=0;
    var modulo='ORDEN_SERVICIO';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var usuario='<?php echo $_SESSION['usuario']?>';
    var nombre='<?php echo $_SESSION['nombre']?>';
    
    $(function(){

        mostrarBotonAyuda(modulo);
        muestraSucursalesPermiso('s_id_sucursales',idUnidadActual,modulo,idUsuario);
        muestraSucursalesPermiso('s_id_sucursales_filtro',idUnidadActual,modulo,idUsuario);
        muestraSelectPrioridad('s_prioridad');
        muestraSelectClasificacionServicios('s_clasificacion_servicios');

        //-->NJES May/22/2020 verifica los botones que tengan la clase verifica_permiso para ver si tienen permiso segun la forma indicada en el alt
        verificarPermisosAlarmas(idUsuario,idUnidadActual);

        $('#b_imprimir').prop('disabled',true);
      
        $('#i_folio').val('');

        if(tipoM == 'instalacion')
            muestraSelectReporta('s_reporta','instalacion');
        else if(tipoM == 'ventas')
            muestraSelectReporta('s_reporta','ventas');
        else
            limpiar();

        if(regresarS==1){
            $('#b_nuevo').click();
            
        }

        if(regresar==1){
            $('#b_regresar').attr('alt2',idServicio);
            $('#i_cliente').attr('alt',idServicio).val(nombreCorto);
            $('#i_cuenta').val(cuenta);
            
            if(parseInt(idSucursal) != 0)
            {
                $('#s_id_sucursales').val(idSucursal);
                $('#s_id_sucursales').select2({placeholder: $(this).data('elemento')});
           
            }

            if(parseInt(reporta) != 0)
            {
                $('#s_reporta').select2({placeholder: $(this).data('elemento')});
            }else{
             
                muestraSelectReporta('s_reporta','general');
            }
        }

        
        
        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        });


        $('#b_buscar_clientes').on('click',function(){

            //-->NJES October/20/2020 buscar los clientes por sucursal
            if($('#s_id_sucursales').val() != null)
            {
                $('#forma').validationEngine('hide');
                $('#i_filtro_servicios').val('');
                $('.renglon_servicios').remove();

                $.ajax({

                    type: 'POST',
                    url: 'php/servicios_buscar.php',
                    dataType:"json", 
                    data:{
                        'estatus':2,
                        'idSucursal':$('#s_id_sucursales').val()
                    },

                    success: function(data) {
                    console.log(data);
                    if(data.length != 0){

                        $('.renglon_servicios').remove();
                
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var activo='';
                            
                            if(parseInt(data[i].activo) == 1){

                                activo='Activo';
                            }else{
                                activo='Inactivo';
                            }

                            var html='<tr class="renglon_servicios" alt="'+data[i].id+'"  alt2="' + data[i].razon_social+ '" alt3="' + data[i].nombre_corto+ '" alt4="' + data[i].cuenta+ '">\
                                        <td data-label="Sucursal">' + data[i].sucursal+ '</td>\
                                        <td data-label="ID">' + data[i].cuenta+ '</td>\
                                        <td data-label="RFC">' + data[i].rfc+ '</td>\
                                        <td data-label="Nombre">' + data[i].nombre_corto+ '</td>\
                                        <td data-label="Razón Social">' + data[i].razon_social+ '</td>\
                                        <td data-label="Estatus">' + activo+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_servicios tbody').append(html);   
                            $('#dialog_buscar_servicios').modal('show');   
                        }

                    }else{

                            mandarMensaje('No se encontró información');
                    }

                    },
                    error: function (xhr) {
                        console.log('php/servicios_buscar.php-->'+JSON.stringify(xhr));
                        mandarMensaje('* Error en el sistema');
                    }
                });
            }else{
                mandarMensaje('Selecciona una sucursal para iniciar la busqueda de clientes');
            }
        });

        $('#t_servicios').on('click', '.renglon_servicios', function(){
            var idServicio = $(this).attr('alt');
            var razonSocial = $(this).attr('alt2');
            var nombreCorto = $(this).attr('alt3');
            var cuenta = $(this).attr('alt4');

            $('#i_cliente').attr('alt',idServicio).val(nombreCorto);
            $('#i_cuenta').val(cuenta);

            $('#dialog_buscar_servicios').modal('hide');
    
        });


       

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
                url: 'php/servicios_ordenes_guardar.php', 
                dataType:"json", 
                data: {
                        'datos':obtenerDatos()

                },
                //una vez finalizado correctamente
                success: function(data){
                    console.log(data);
                    if (data > 0 ) {
                        if (tipoMov == 0){
                            
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
                    console.log('php/servicios_ordenes_guardar.php -->'+JSON.stringify(xhr));
                    mandarMensaje("* Ha ocurrido un error.");
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
                    'tipoMov' : tipoMov,
                    'idOrdenServicio' : idOrdenServicio,
                    'idUnidad' : idUnidadActual,
                    'idSucursal' : $('#s_id_sucursales').val(),
                    'idServicio' : $('#i_cliente').attr('alt'),
                    'reporta' : $('#s_reporta').val(),
                    'servicio' : $('#i_servicio').val(),
                    'descripcion' : $('#ta_descripcion').val(),
                    'prioridad' : $('#s_prioridad').val(),
                    'idClasificacionServicio' : $('#s_clasificacion_servicios').val(),
                    'fechaProgramada' : $("#i_fecha_servicio").val(),
                    'fechaSolicitud' : $('#i_fecha_solicitud').val(),
                    'idUsuario' : idUsuario
                }
                paquete.push(paq);
              
            return paquete;
        } 


        $('#i_fecha_inicio').change(function()
        {

            if($('#i_fecha_inicio').val() != '')
            {
                $('#i_fecha_fin').prop('disabled',false);
                buscarOrdenes();
            }

        });

        $('#i_fecha_fin').change(function(){ 

            buscarOrdenes();

        });


        $('#b_buscar').on('click',function(){
            $('#dialog_buscar_ordenes_servicios').modal('show');
            $('#t_ordenes > tbody').empty();   
            $('#i_fecha_inicio').val(primerDiaMes);
            $('#i_fecha_fin').val(ultimoDiaMes);
            buscarOrdenes();

        });


        function buscarOrdenes(){

            //-->NJES November/11/2020 agregar filtro sucursales
            if($('#s_id_sucursales_filtro').val() != null)
                var idSucursal = $('#s_id_sucursales_filtro').val();
            else
                var idSucursal = muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario);

            $('#forma').validationEngine('hide');
            $('#i_filtro_ordenes').val('');
            $('.renglon_ordenes').remove();

            $.ajax({

                type: 'POST',
                url: 'php/servicios_ordenes_buscar.php',
                dataType:"json", 
                data:{
                    'fechaInicio' : $('#i_fecha_inicio').val(),
                    'fechaFin' : $('#i_fecha_fin').val(),
                    'idSucursal': idSucursal
                },

                success: function(data) {
                console.log(data);
                if(data.length != 0){

                    $('.renglon_ordenes').remove();
            
                    for(var i=0;data.length>i;i++){

                        ///llena la tabla con renglones de registros
                        var html='<tr class="renglon_ordenes" alt="'+data[i].id+'">\
                                    <td data-label="Sucursal">' +data[i].sucursal+ '</td>\
                                    <td data-label="Folio">' +data[i].id+ '</td>\
                                    <td data-label="Fecha Programada">' +data[i].fecha_servicio+ '</td>\
                                    <td data-label="Cliente">' + data[i].cliente+ '</td>\
                                    <td data-label="Servicio">' + data[i].servicio+ '</td>\
                                    <td data-label="Servicio">' + data[i].prioridad+ '</td>\
                                    <td data-label="Estatus">' + data[i].estatus+ '</td>\
                                    <td data-label="Usuario">' + data[i].usuario+ '</td>\
                                </tr>';
                        ///agrega la tabla creada al div 
                        $('#t_ordenes tbody').append(html);     
                    }

                }else{

                        mandarMensaje('No se encontró información');
                }

                },
                error: function (xhr) {
                    console.log('php/servicios_ordenes_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* Error en el sistema');
                }
            });
        } 

        $('#t_ordenes').on('click', '.renglon_ordenes', function(){
            idOrdenServicio = $(this).attr('alt');
            tipoMov = 1;
            $('#dialog_buscar_ordenes_servicios').modal('hide');
            muestraRegistro();
            verificarPermisosAlarmas(idUsuario,idUnidadActual);
        });
     

         function muestraRegistro(){ 
            $('#b_guardar').prop('disabled',true);
            $('#b_imprimir').prop('disabled',false);
            $.ajax({
                type: 'POST',
                url: 'php/servicios_ordenes_buscar_id.php',
                dataType:"json", 
                data:{
                    'idOrdenServicio':idOrdenServicio
                },
                success: function(data) {
                    
                    idOrdenServicio=data[0].id;
                    $('#i_usuario_captura').val(data[0].usuario+'-'+data[0].nombre);
                    $('#b_regresar').attr('alt2',data[0].id_servicio);

                    $('#d_estatus_oc').removeAttr('class');
                    if(data[0].estatus_cierre==1){
                        $('#d_estatus_oc').addClass('alert alert-sm alert-success').text('CERRADA');
                    }else{
                        if(data[0].estatus_orden == 'A')
                        {
                            $('#d_estatus_oc').addClass('alert alert-sm alert-info').text('ACTIVA');

                        }else if(data[0].estatus_orden == 'P'){
                            $('#d_estatus_oc').addClass('alert alert-sm alert-warning').text('PENDIENTE');

                        }else{
                            $('#d_estatus_oc').addClass('alert alert-sm alert-danger').text('CANCELADA');
                        }
                    }

                    $('#i_folio').val(data[0].id);
                    $('#i_cliente').val(data[0].cliente).attr('alt',data[0].id_servicio);
                    $('#i_cuenta').val(data[0].cuenta);
                    $('#i_servicio').val(data[0].servicio);
                    $('#ta_descripcion').val(data[0].descripcion);
                    $('#i_fecha').val(data[0].fecha_captura);
                    $('#i_fecha_servicio').val(data[0].fecha_servicio);
                    $('#i_fecha_solicitud').val(data[0].fecha_solicitud);
            
                    if(data[0].id_sucursal != 0)
                    {
                        $('#s_id_sucursales').val(data[0].id_sucursal);
                        $('#s_id_sucursales').select2({placeholder: $(this).data('elemento')});
                    }else{
                        $('#s_id_sucursales').val('');
                        $('#s_id_sucursales').select2({placeholder: 'Selecciona'});
                    }

                    if(data[0].reporta != 0)
                    {
                        $('#s_reporta').select2({placeholder: $(this).data('elemento')});
                    }else{
                        
                        muestraSelectReporta('s_reporta','general');
                    }

                    if(data[0].prioridad != 0)
                    {
                        $('#s_prioridad').val(data[0].prioridad);
                        $('#s_prioridad').select2({placeholder: $(this).data('elemento')});
                    }else{
                        $('#s_prioridad').val('');
                        $('#s_prioridad').select2({placeholder: 'Selecciona'});
                    }
                    if(data[0].id_clasificacion_servicio != 0)
                    {
                        $('#s_clasificacion_servicios').val(data[0].id_clasificacion_servicio);
                        $('#s_clasificacion_servicios').select2({placeholder: $(this).data('elemento')});
                    }else{
                        $('#s_clasificacion_servicios').val('');
                        $('#s_clasificacion_servicios').select2({placeholder: 'Selecciona'});
                    }

                    //-->NJES June/30/2020 verifica si tiene permiso para editar la fecha solicitud servicio y quita o agrega la clase del datepicker o lo remueve
                    if(verificaPermisoEditarFecha('EDITAR_FECHA_SOLICITUD') == 1)
                    {
                        $('#i_fecha_solicitud').removeClass('fecha').addClass('fecha').datepicker({
                            format : "yyyy-mm-dd",
                            autoclose: true,
                            language: "es",
                            todayHighlight: true
                        });
                    }else
                        $('#i_fecha_solicitud').removeClass('fecha').datepicker('remove');
                   
                },
                error: function (xhr) {
                    console.log('php/servicios_ordenes_buscar_id.php-->'+JSON.stringify(xhr));
                    mandarMensaje(xhr.responseText);
                }
            });
        }

        $('#b_regresar').on('click',function(){
            var idServicio=$(this).attr('alt2');
            window.open("fr_servicios.php?regresar=1","_self");
        });

        $('#b_seguimiento').on('click',function(){
            window.open("fr_servicios_ordenes_seguimiento.php","_self");
        }); 
       
        

        $('#b_nuevo').on('click',function(){
            limpiar();
        });
        /* Limpia el modulo comple al dar click en nuevo o guardad*/
        function limpiar(){
         
            idOrdenServicio=0;
            tipoMov=0;
            $('input,textarea').val('');
            $('form').validationEngine('hide');
            $('#b_guardar').prop('disabled',false);
            muestraSelectReporta('s_reporta','general');
            muestraSelectPrioridad('s_prioridad');
            muestraSelectClasificacionServicios('s_clasificacion_servicios');
            $('#i_fecha_solicitud,#s_reporta').prop('disabled',false);
            $('#b_imprimir').prop('disabled',true);
            $('#d_estatus_oc').removeAttr('class');
            $('#i_folio').val('');
            $('#i_usuario_captura').val('').val(usuario+'-'+nombre);

            $('#i_fecha_solicitud').removeClass('fecha').addClass('fecha');
        }

        $('#b_imprimir').click(function(){
            if(idOrdenServicio > 0 ){
                imprimir();
            }else{
                mandarMensaje('Debes selecionar una orden de servicio, para imprimir');
            }
           

        });


        function imprimir(){
           
            var datos = {
                'path':'formato_orden_servicio',
                'idRegistro':idOrdenServicio,
                'nombreArchivo':'orden_servicio',
                'tipo':1,
                'modulo':'orden_servicio'
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_new')
           

        }

        //-->NJES June/30/2020 verifica si tiene permiso el boton o input
        function verificaPermisoEditarFecha(boton){
            var permiso = 0;
            $.ajax({
                type: 'POST',
                url: 'php/permisos_botones_alarmas_buscar.php', 
                data:{
                    'idUsuario' : idUsuario,
                    'boton':boton,
                    'idBoton':0,
                    'idUnidadNegocio':idUnidadActual
                },
                async: false,
                success: function(data) {
                    //data 1 = si permiso
                    permiso = data;
                },
                error: function (xhr) {
                    console.log("verificarPermisos: "+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al verificar permisos Alarmas');
                }
            });

            return permiso;
        }

        $('#s_id_sucursales_filtro').change(function(){
            buscarOrdenes();
        });

    });

</script>

</html>