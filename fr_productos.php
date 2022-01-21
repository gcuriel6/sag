<?php
session_start();
$idProducto=0;
$regresar=0;

if(isset($_GET['idProducto'])!=0 && $_GET['regresar']==1){

    $idProducto=$_GET['idProducto'];
    $regresar=1;
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
    #b_ver_equivalente_usado{
        display:none;
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
                        <div class="titulo_ban">Productos</div>
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

                <div class="row">
                    <div class="col-sm-12 col-md-2"><input id="i_id_sucursal" type="hidden"/></div>
                    <div class="col-sm-12 col-md-10">
                        <form id="forma" name="forma">
                            <div class="form-group row">
                                <label for="i_id_producto" class="col-sm-2 col-md-2 col-form-label requerido">ID </label>
                                <div class="col-sm-12 col-md-2">
                                    <input type="text" class="form-control"  id="i_id_producto" autocomplete="off" disabled="disabled">
                                </div>

                                <div class="col-sm-12 col-md-2"></div>
                                <div class="col-sm-12 col-md-3">
                                    <button type="button" class="btn btn-info btn-sm form-control" id="b_ver_equivalente_usado"><i class="fa fa-eye" aria-hidden="true"></i> Equivalente Usado</button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_clave" class="col-sm-2 col-md-2 col-form-label requerido">Clave </label>
                                <div class="col-sm-12 col-md-2">
                                    <input type="text" class="form-control validate[maxSize[25]]"  id="i_clave" name="i_clave" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                            <label for="i_familia" class="col-2 col-md-2 col-form-label requerido">Familia </label><br>
                               
                                <div class="col-sm-12 col-md-6">
                                    <div class="row">
                                    
                                        <div class="input-group col-sm-12 col-md-9">
                                            <input type="text" id="i_familia" name="i_familia" class="form-control validate[required]" readonly autocomplete="off">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary" type="button" id="b_buscar_familias" style="margin:0px;">
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                            <label for="i_linea" class="col-2 col-md-2 col-form-label requerido">Línea </label><br>
                               
                                <div class="col-sm-12 col-md-6">
                                    <div class="row">
                                    
                                        <div class="input-group col-sm-12 col-md-9">
                                            <input type="text" id="i_linea" name="i_linea" class="form-control validate[required]" readonly autocomplete="off">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary" type="button" id="b_buscar_lineas" style="margin:0px;">
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_concepto" class="col-sm-2 col-md-2 col-form-label requerido">Concepto</label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="text" class="form-control validate[required]" id="i_concepto" name="i_concepto">
                                </div>
                            </div>
                           <div class="form-group row"><!--MGFS 22-10-2019 Quitar obligatoriedad a los campos "código de barras", "costo" e "IVA". El campo "costo" se actualizará según el último precio de compra pero será posible modificarlo. Cuando se modifique, se agregará en bitácora el cambio.-->
                                <label for="i_codigo_barras" class="col-sm-2 col-md-2 col-form-label">Código de Barras </label>
                                <div class="col-sm-12 col-md-3">
                                    <input type="text" class="form-control" id="i_codigo_barras">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_costo" class="col-sm-2 col-md-2 col-form-label">Costo </label>
                                <div class="col-sm-12 col-md-3">
                                    <input type="text" class="form-control validate[custom[number]]" id="i_costo">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_iva" class="col-sm-2 col-md-2 col-form-label">IVA</label>
                                <div class="col-sm-12 col-md-2">
                                    <input type="text" class="form-control validate[custom[number],min[0],max[16]]" id="i_iva" name="i_iva" values="16">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ch_servicio" class="col-sm-2 col-md-2 col-form-label">Servicio</label>
                                <div class="col-sm-10 col-md-2">
                                    <input type="checkbox" id="ch_servicio" name="ch_servicio" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ch_inactivo" class="col-sm-2 col-md-2 col-form-label">Inactivo</label>
                                <div class="col-sm-10 col-md-2">
                                    <input type="checkbox" id="ch_inactivo" name="ch_inactivo" value="">
                                </div>
                            </div>
                            
                        </form>

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-12 col-md-10">

                        <table class="tablon"  id="t_bitacora">
                        <thead>
                            <tr class="renglon"  style="background-color: #CCE5FF;font-size: 14px;">
                                <th scope="col" colspan="5">Bitácora cambio de Costo</th>
                                
                            </tr>
                            
                            <tr class="renglon">
                            <th scope="col">Módulo</th>
                            <th scope="col">Unidad de Negocio</th>
                            <th scope="col">Costo</th>
                            <th scope="col">Fecha Cambio</th>
                            <th scope="col">Usuario</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        </table>  
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-4"><button type="button" class="btn btn-success btn-sm form-control verificar_permiso" alt="BOTON_ASIGNAR_UNIDAD_NEGOCIO" id="b_asignar_unidad"><i class="fa fa-external-link-square" aria-hidden="true"></i> Asignar Unidades de Negocio</button></div>
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-12 col-md-4">
                        <button type="button" class="btn btn-success btn-sm form-control verificar_permiso" alt="BOTON_EXCEL_PRODUCTOS" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
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

<div id="dialog_buscar_productos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Productos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="input-group col-sm-12 col-md-4">
                    <input type="text" id="i_familia_filtro" name="i_familia_filtro" class="form-control" placeholder="Filtrar Por Familia" readonly autocomplete="off">
                    <div class="input-group-btn">
                        <button class="btn btn-primary" type="button" id="b_buscar_familia_filtro" style="margin:0px;">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </div> 
                <div class="input-group col-sm-12 col-md-4">
                    <input type="text" id="i_linea_filtro" name="i_linea_filtro" class="form-control" placeholder="Filtrar Por Línea" readonly autocomplete="off">
                    <div class="input-group-btn">
                        <button class="btn btn-primary" type="button" id="b_buscar_lineas_filtro" style="margin:0px;">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>  
                <div class="col-sm-12 col-md-4"><input type="text" name="i_filtro_producto" id="i_filtro_producto" class="form-control filtrar_renglones" alt="renglon_producto" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_productos">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Catalogo</th>
                          <th scope="col">Familia</th>
                          <th scope="col">Línea</th>
                          <th scope="col">Concepto</th>
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

<div id="dialog_buscar_familias" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Familias</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_familias" id="i_filtro_familias" class="form-control filtrar_renglones" alt="renglon_familias" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_familias">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">ID</th>
                          <th scope="col">Clave</th>
                          <th scope="col">Descripción</th>
                          <th scope="col">Tallas</th>
                          <th scope="col">Tipo</th>
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

<div id="dialog_buscar_lineas" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Líneas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_lineas" id="i_filtro_lineas" class="form-control filtrar_renglones" alt="renglon_lineas" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_lineas">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Clave</th>
                          <th scope="col">Descripción</th>
                          <th scope="col">Familia</th>
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

<div id="dialog_equivalente_usado" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Productos Equivalente Usado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <b>ID:</b> <label id="dato_id_eu"></label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <b>Clave:</b> <label id="dato_clave_eu"></label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <b>Familia:</b> <label id="dato_familia_eu"></label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <b>Línea:</b> <label id="dato_linea_eu"></label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <b>Concepto:</b> <label id="dato_concepto_eu"></label>
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
  
    var idProducto=<?php echo $idProducto?>;
    var productoOriginal='';
    var tipo_mov=0;
    var modulo='PRODUCTOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var regresar=<?php echo $regresar?>;
    var costoOriginal=0;
    $(function(){

        mostrarBotonAyuda(modulo);

        muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);

        $('#ch_inactivo').prop('checked',false).prop('disabled',true); 

        if(regresar==1){
            muestraRegistro();
            buscaBitacora();
        } 

        //************Solo muestra las familias activas */
        $('#b_buscar_familias').on('click',function(){
           $('#i_familia').validationEngine('hide'); 
           buscaFamilias(1);
        });
        $('#b_buscar_familia_filtro').on('click',function(){
           buscaFamilias(2);
        });

        $('#b_buscar_lineas').prop('disabled',true);
        $('#b_buscar_lineas_filtro').prop('disabled',true);

        function buscaFamilias(boton){
            $('#i_filtro_familias').val('');
            $('.renglon_familias').remove();

            $.ajax({

                type: 'POST',
                url: 'php/familias_buscar.php',
                dataType:"json", 
                data:{'estatus':0},

                success: function(data) {
                
                if(data.length != 0){

                        $('.renglon_familias').remove();
                
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var inactivo='';
                            
                            if(parseInt(data[i].inactivo) == 1){

                                inactivo='inactivo';
                            }else{
                                inactivo='Activa';
                            }

                            var html='<tr class="renglon_familias" alt="'+data[i].id+'" alt2="'+data[i].descripcion+'" boton="'+boton+'">\
                                        <td data-label="ID">' + data[i].id+ '</td>\
                                        <td data-label="Clave">' + data[i].clave+ '</td>\
                                        <td data-label="Descripción">' + data[i].descripcion+ '</td>\
                                        <td data-label="Tallas">' + data[i].tallas+ '</td>\
                                        <td data-label="Tipo">' + data[i].tipo+ '</td>\
                                        <td data-label="Estatus">' + inactivo+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_familias tbody').append(html);   
                            $('#dialog_buscar_familias').modal('show');   
                        }
                }else{

                        mandarMensaje('No se encontró información');
                }

                },
                error: function (xhr) {
                    console.log('php/familias_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* Error en el sistema');
                }
            });
        }

        $('#t_familias').on('click', '.renglon_familias', function() {
            var boton = $(this).attr('boton');
            var  idFamilia = $(this).attr('alt');
            var  familia = $(this).attr('alt2');
            if(boton==1){
                $('#i_familia').attr('alt',idFamilia).val(familia);
                $('#b_buscar_lineas').prop('disabled',false);
            }else{
                $('#i_familia_filtro').attr('alt',idFamilia).val(familia);
                $('#b_buscar_lineas_filtro').prop('disabled',false);
                buscarProductos();
            }

            $('#i_linea').val('');
            $('#i_linea_filtro').val('');
            
            $('#dialog_buscar_familias').modal('hide');

        });


        //************Solo muestra las familias activas */
        $('#b_buscar_lineas').on('click',function(){
           $('#i_linea').validationEngine('hide');
           buscaLineas(1);
        });
        $('#b_buscar_lineas_filtro').on('click',function(){
            buscaLineas(2);
        });

        function buscaLineas(boton){

            if(boton==1){
                var  idFamilia = $('#i_familia').attr('alt');
            }else{
                var  idFamilia = $('#i_familia_filtro').attr('alt');
            }

                $('#i_filtro_lineas').val('');
                $('.renglon_lineas').remove();

                $.ajax({

                    type: 'POST',
                    url: 'php/lineas_buscar_idFamilia.php',
                    dataType:"json", 
                    data:{'idFamilia':idFamilia},

                    success: function(data) {
                  
                    if(data.length != 0){

                            $('.renglon_lineas').remove();
                    
                            for(var i=0;data.length>i;i++){

                                ///llena la tabla con renglones de registros
                                var inactiva='';
                                
                                if(parseInt(data[i].inactiva) == 1){

                                    inactiva='Inactiva';
                                }else{
                                    inactiva='Activa';
                                }

                                var html='<tr class="renglon_lineas" alt="'+data[i].id+'" alt2="' + data[i].descripcion+ '" boton="'+boton+'">\
                                            <td data-label="Clave">' + data[i].clave+ '</td>\
                                            <td data-label="Descripción">' + data[i].descripcion+ '</td>\
                                            <td data-label="Familia">' + data[i].familia+ '</td>\
                                            <td data-label="Estatus">' + inactiva+ '</td>\
                                        </tr>';
                                ///agrega la tabla creada al div 
                                $('#t_lineas tbody').append(html);   
                                $('#dialog_buscar_lineas').modal('show');   
                            }
                    }else{

                            mandarMensaje('No se encontró información');
                    }

                    },
                    error: function (xhr) {
                        console.log('php/lineas_buscar.php-->'+JSON.stringify(xhr));
                        mandarMensaje('* Error en el sistema');
                    }
                });
            }

            $('#t_lineas').on('click', '.renglon_lineas', function() {
                var boton = $(this).attr('boton');
                var idLinea = $(this).attr('alt');
                var linea = $(this).attr('alt2');

                if(boton==1){
                    $('#i_linea').val(linea).attr('alt',idLinea);
                }else{
                    $('#i_linea_filtro').val(linea).attr('alt',idLinea);
                    buscarProductos();
                }

                

                $('#dialog_buscar_lineas').modal('hide');


            });

        $('#i_iva').on('change',function(){
            if($(this).validationEngine('validate')==false) {

                var iva=$('#i_iva').val();
                if(iva==0 || iva==8 || iva==16){

                }else{
                    $('#i_iva').val(16);
                    mandarMensaje('Para el iva solo puedes ingresar 0, 8 o 16');
                }

            }else{
                $('#i_iva').val(16);
            }
        });        




        $('#b_buscar').on('click',function(){
            $('#forma').validationEngine('hide');
            $('#i_filtro_producto').val('');
            $('.renglon_producto').remove();
            $('#i_familia_filtro').val('').attr('alt',0);
            $('#i_linea_filtro').val('').attr('alt',0);
            $('#dialog_buscar_productos').modal('show'); 
        });


        function buscarProductos(){
            $('#t_productos tbody').empty();
            
            $.ajax({

                type: 'POST',
                url: 'php/productos_buscar_filtros.php',
                dataType:"json", 
                data:{'idFamilia':$('#i_familia_filtro').attr('alt'),
                      'idLinea':$('#i_linea_filtro').attr('alt')
                },
                success: function(data) {
                    console.log('php/productos_buscar.php-->'+JSON.stringify(data));
                   if(data.length != 0){

                        $('.renglon_producto').remove();
                   
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var inactivo='';
                            
                            if(parseInt(data[i].inactivo) == 1){

                                inactivo='Inactivo';
                            }else{
                                inactivo='Activa';
                            }

                            var html='<tr class="renglon_producto" alt="'+data[i].id+'">\
                                        <td data-label="Catalogo">' + data[i].id+ '</td>\
                                        <td data-label="Familia">' + data[i].familia+ '</td>\
                                        <td data-label="Línea">' + data[i].linea+ '</td>\
                                        <td data-label="Concepto">' + data[i].concepto+ '</td>\
                                        <td data-label="Estatus">' + inactivo+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_productos tbody').append(html);   
                              
                        }
                   }else{

                        mandarMensaje('No se encontró información');
                   }

                },
                error: function (xhr) {
                    console.log('php/productos_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* Error en el sistema');
                }
            });
        }

        $('#t_productos').on('click', '.renglon_producto', function() {
            
            tipo_mov = 1;
            $('#b_guardar').prop('disabled',false);
            $('#ch_inactivo').prop('disabled', false);
            idProducto = $(this).attr('alt');
           
            $('#dialog_buscar_productos').modal('hide');
            muestraRegistro();
            buscaBitacora();

            $('#b_buscar_lineas').prop('disabled',false);
            $('#b_buscar_lineas_filtro').prop('disabled',false);

        });



        function muestraRegistro(){ 
            costoOriginal=0;
            $.ajax({
                type: 'POST',
                url: 'php/productos_buscar_id.php',
                dataType:"json", 
                data:{
                    'idProducto':idProducto
                },
                success: function(data) {
                  
                    productoOriginal=data[0].clave;
                    $('#i_id_producto').val(idProducto);
                    $('#i_clave').val(data[0].clave);
                    $('#i_familia').val(data[0].familia).attr('alt',data[0].id_familia);
                    $('#i_linea').val(data[0].linea).attr('alt',data[0].id_linea);
                    $('#i_concepto').val(data[0].concepto);

                    if (data[0].servicio == 0) {
                        $('#ch_servicio').prop('checked', false);
                    } else {
                        $('#ch_servicio').prop('checked', true);
                    }

                    $('#i_codigo_barras').val(data[0].codigo_barras);
                    $('#i_costo').val(formatearNumero(data[0].costo));
                    costoOriginal=data[0].costo;
                    $('#i_iva').val(data[0].iva);
                    
                    if (data[0].inactivo == 0) {
                        $('#ch_inactivo').prop('checked', false);
                    } else {
                        $('#ch_inactivo').prop('checked', true);
                    }

                    if(data[0].equivalente_usado > 0)
                    {
                        $('#b_ver_equivalente_usado').css('display','block').attr('alt',data[0].equivalente_usado);
                        $('#b_buscar_familias').prop('disabled',true);
                    }else{
                        $('#b_ver_equivalente_usado').css('display','none').attr('alt',0); 
                        $('#b_buscar_familias').prop('disabled',false);
                    }
                   
                },
                error: function (xhr) {
                    console.log('php/productos_buscar_id.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontro información al buscar producto');
                }
            });
        }

        function buscaBitacora(){

            $('.renglon_bitacora').remove();

            $.ajax({

                type: 'POST',
                url: 'php/productos_buscar_bitacora.php',
                dataType:"json", 
                data:{'idProducto':idProducto},

                success: function(data) {
                
                if(data.length != 0){

                        $('.renglon_bitacora').remove();
                
                        for(var i=0;data.length>i;i++){

                            var html='<tr class="renglon_bitacora">\
                                        <td data-label="Modulo">' + data[i].modulo+ '</td>\
                                        <td data-label="Unidad">' + data[i].unidad+ '</td>\
                                        <td data-label="Costo">' + formatearNumero(data[i].nuevo_costo)+ '</td>\
                                        <td data-label="Fecha Cambio">' + data[i].fecha_cambio+ '</td>\
                                        <td data-label="Usuario">' + data[i].usuario+ '</td>\
                                      </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_bitacora tbody').append(html);     
                        }
                }else{

                        //mandarMensaje('No se encontraron unidades de negocio relacionadas');
                }

                },
                error: function (xhr) {
                    console.log('php/productos_buscar_unidades.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* Error en el sistema');
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
                url: 'php/productos_verificar.php',
                //dataType:"json", 
                data:  {'clave':$('#i_clave').val()},
                success: function(data) 
                {
                    if(data == 1){
                        
                        if (tipo_mov == 1 && productoOriginal === $('#i_clave').val()) {
                            guardar();
                        } else {

                            mandarMensaje('La clave : '+ $('#i_clave').val()+' ya existe intenta con otra');
                            $('#i_clave').val('');
                            $('#b_guardar').prop('disabled',false);
                        }
                    } else {
                        //-->NJES April/28/2020 si es un producto para la familia uniformes generar su equivalente usado
                        var idFamilia = $('#i_familia').attr('alt');
                        var idLinea = $('#i_linea').attr('alt');
                        if(idFamilia == 1)
                        {
                            //--> verificar si la linea seleccionada tiene linea usada
                            if(tieneLineaUsado(idLinea) > 0)
                            {
                                guardar();
                            }else{
                                mandarMensaje('No se puede guardar, porque la línea seleccionada para el producto para la familia uniformes, no tiene una familia equivalente a usada.');
                                $('#b_guardar').prop('disabled',false);
                            }
                        }else
                            guardar();
                    }
                },
                error: function (xhr) {
                    mandarMensaje('* No se encontro información al verificar la clave.');
                    console.log('php/productos_verificar.php --> '+JSON.stringify(xhr));
                    $('#b_guardar').prop('disabled',false);
                }
            });
        }


        //-->NJES April/28/2020 busca si una linea tiene linea usada
        function tieneLineaUsado(idLinea){
            var verifica = 1;

            $.ajax({
                type: 'POST',
                url: 'php/lineas_buscar_usado_id_linea.php',
                data:  {'idLinea':idLinea},
                async: false, //-->quita asincrono para que pueda returnar el valor cuando ya se haya terminado el proceso ajax
                success: function(data) 
                {
                    verifica = data;
                },
                error: function (xhr) {
                    console.log('php/lineas_buscar_usado_id_linea.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontro información al buscar linea usada de la linea');
                }
            });

            return verifica;
        }
        
        /* funcion que manda a generar la insecion o actualizacion de un registro */    
        function guardar(){
         $.ajax({
                type: 'POST',
                url: 'php/productos_guardar.php', 
                //dataType:"json", 
                data: {
                        'datos':obtenerDatos()

                },
                //una vez finalizado correctamente
                success: function(data){
                    console.log('data: '+data);
                  console.log(JSON.stringify(data));
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
                    console.log('php/productos_guardar.php -->'+JSON.stringify(xhr));
                    mandarMensaje("* Error en el guardado.");
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
                    'idProducto' : idProducto,
                    'clave' : $('#i_clave').val(),
                    'idFamilia':$('#i_familia').attr('alt'),
                    'idLinea':$('#i_linea').attr('alt'),
                    'concepto' : $('#i_concepto').val(),
                    'servicio' : $("#ch_servicio").is(':checked') ? 1 : 0,
                    'codigoBarras' : $('#i_codigo_barras').val(),
                    'costo' : quitaComa($('#i_costo').val()),
                    'costoOriginal' : costoOriginal,
                    'iva' : $('#i_iva').val(),
                    'inactivo' : $("#ch_inactivo").is(':checked') ? 1 : 0,
                    'idUnidad':idUnidadActual,
                    'idUsuario':idUsuario
                }
                paquete.push(paq);
              
            return paquete;
        }    
       
        

        $('#b_nuevo').on('click',function(){
            limpiar();
        });
        /* Limpia el modulo comple al dar click en nuevo o guardad*/
        function limpiar(){
         
            idProducto=0;
            productoOriginal='';
            tipo_mov=0;
            costoOriginal=0;

            $('input').val('');
            $('#i_familia').attr('alt',0);
            $('#i_linea').attr('alt',0);
            $('form').validationEngine('hide');
            $('#b_guardar').prop('disabled',false);
            $('#ch_servicio').prop('checked',false);
            $('#ch_inactivo').prop('checked',false).prop('disabled',true);
            $('.renglon_bitacora').remove();
            
        }

        $('#b_excel').click(function(){
            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
            
            $('#i_nombre_excel').val('Registros Productos');
            $('#i_fecha_excel').val(hoy);
            $('#i_modulo_excel').val('PRODUCTOS');
            
            $("#f_imprimir_excel").submit();
        });

        $('#b_asignar_unidad').on('click',function(){
            var idProducto=0;
            var producto='';
            if($('#i_id_producto').val()!=''){
                idProducto=$('#i_id_producto').val();
                producto=$('#i_concepto').val();
            }
            window.open("fr_productos_accesos.php?idProductoP="+idProducto+"&productoP="+producto,"_self");
        });
       
        $('#b_ver_equivalente_usado').click(function(){
            var idProductoEU = $(this).attr('alt');

            $('#dato_id_eu').text('');
            $('#dato_clave_eu').text('');
            $('#dato_familia_eu').text('');
            $('#dato_linea_eu').text('');
            $('#dato_concepto_eu').text('');

            $.ajax({
                type: 'POST',
                url: 'php/productos_buscar_id.php',
                dataType:"json", 
                data:{
                    'idProducto':idProductoEU
                },
                success: function(data) {
                  
                    $('#dato_id_eu').text(data[0].id);
                    $('#dato_clave_eu').text(data[0].clave);
                    $('#dato_familia_eu').text(data[0].familia);
                    $('#dato_linea_eu').text(data[0].linea);
                    $('#dato_concepto_eu').text(data[0].concepto);

                    $('#dialog_equivalente_usado').modal('show');
                   
                },
                error: function (xhr) {
                    console.log('php/productos_buscar_id.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontro información de producto');
                }
            });
        });
    });

</script>

</html>