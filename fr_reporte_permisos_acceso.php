<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="utf-8" />
    <meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
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
        /*margin-left:4%;*/
    }
    #div_contenedor{
        background-color: #ffffff;
    }
    #div_tabla{
        min-height:320px;
        max-height:60vh;
        overflow-y:auto;
        overflow-x:hidden;
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
    #fondo_cargando
    {
        position: absolute;
        top: 1%;
        background-image:url('imagenes/3.svg');
        background-repeat:no-repeat;
        background-size: 500px 500px; 
        background-position:center;
        left: 1%;
        width: 98%;
        bottom:3%;
        border-radius: 5px;
        z-index:2000;
        display:none; 
    }


    /* Responsive Web Design */
    @media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_tabla{
            height:auto;
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
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Reporte de Permisos</div>
                    </div>
                    <div class="col-sm-12 col-md-7"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel" disabled><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label for="i_menu">Menú </label>
                            <div class="input-group">
                                <input type="text" id="i_menu" name="i_menu" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="b_buscar_menu">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label for="i_restriccion">Permiso/Restricción</label>                            
                            <div class="input-group">
                                <input type="text" id="i_restriccion" name="i_restriccion" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="b_buscar_restriccion" disabled>
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>                                
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <button type="button" class="btn btn-dark" id="b_buscar"><i class="fa fa-search"></i> Buscar</button>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label for="i_filtrar_usuario">Por Usuario</label>                            
                            <div class="input-group">
                                <input type="text" id="i_filtrar_usuario" name="i_filtrar_usuario" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="b_buscar_filtrar_usuario">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>                                
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-12 col-md-5">
                        <div class="row">
                            <label for="s_id_unidades" class="col-sm-12 col-md-5 col-form-label">Unidad de Negocio </label>
                            <div class="col-sm-12 col-md-7">
                                <select id="s_id_unidades" name="s_id_unidades" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="row">
                            <label for="s_id_sucursales" class="col-sm-12 col-md-3 col-form-label">Sucursal</label>
                            <div class="col-sm-12 col-md-9">
                                <select id="s_id_sucursales" name="s_id_sucursales" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <input type="text" id="i_filtro" name="i_filtro" class="form-control form-control-sm filtrar_renglones" alt="renglon" autocomplete="off" placeholder="Filtrar...">
                    </div>
                </div>   

                <hr><!--linea gris-->

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon_encabezado">
                                    <th scope="col">USUARIO</th>
                                    <th scope="col">NO. EMPLEADO</th>
                                    <th scope="col">NOMBRE</th>
                                    <th scope="col">ESTATUS</th>
                                    <th scope="col">UNIDAD DE NEGOCIO</th>
                                    <th scope="col">SUCURSAL</th>
                                    <th scope="col">MENU</th>
                                    <th scope="col">PERMISO RESTRICCION</th>
                                    <!--<th scope="col">Tipo</th>-->
                                </tr>
                            </thead>
                        </table>
                        <div id="div_tabla">
                            <table class="tablon"  id="t_registros">
                                <tbody>
                                    
                                </tbody>
                            </table>  
                        </div>  
                    </div>
                </div>

                <form id="f_imprimir_excel" action="php/excel_genera_datos.php" method="POST" target="_blank">
                    <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
                    <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
                    <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
                    <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
                </form>

            <br>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
</body>

<div id="dialog_menu" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Búsqueda de Menú</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_menu" id="i_filtro_menu" alt="renglon_menu" class="filtrar_renglones form-control" placeholder="Filtrar" autocomplete="off"></div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_menu">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Nombre</th>
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

<div id="dialog_restriccion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Búsqueda de Permiso/Restricción</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_restriccion" id="i_filtro_restriccion" alt="renglon_restriccion" class="filtrar_renglones form-control" placeholder="Filtrar" autocomplete="off"></div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_restriccion">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Nombre</th>
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

<div id="dialog_usuarios" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Búsqueda de Usuarios</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12"><input type="text" name="i_filtro_usuarios" id="i_filtro_usuarios" alt="renglon_usuario" class="filtrar_renglones form-control" placeholder="Filtrar" autocomplete="off"></div>
                </div>    
                <div class="row">
                    <div class="col-12">
                        <table class="tablon" id="t_usuarios">
                            <thead>
                                <tr class="renglon">
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
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="fondo_cargando"></div>

<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
  
    var modulo='REPORTES_DE_PERMISOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var matriz = <?php echo $_SESSION['sucursales']?>;
    
    $(function(){

        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        muestraSucursalesAcceso('s_id_sucursales',idUnidadActual,idUsuario);

        $('#b_buscar_menu').click(function(){
            $('#i_filtro_menu').val('');
            muestraModalOpcionesMenuPadres('renglon_menu','t_menu tbody','dialog_menu');
        });

        $('#t_menu').on('click', '.renglon_menu', function() {
            var opcion = $(this).attr('alt');
            $('#i_menu').val(opcion);
            $('#i_restriccion').val('');
            $('#b_buscar_restriccion').prop('disabled',false);
            $('#dialog_menu').modal('hide');
        });

        $('#b_buscar_restriccion').click(function(){
            $('#i_filtro_restriccion').val('');
            muestraModalOpcionesMenuHijos('renglon_restriccion','t_restriccion tbody','dialog_restriccion',$('#i_menu').val());
        });

        $('#t_restriccion').on('click', '.renglon_restriccion', function() {
            var opcion = $(this).attr('alt');
            $('#i_restriccion').val(opcion);
            $('#dialog_restriccion').modal('hide');
        });

        $('#b_buscar_filtrar_usuario').click(function(){
            muestraModalOpcionesUsuarios('renglon_usuario','t_usuarios tbody','dialog_usuarios');
        });

        $('#s_id_unidades').change(function(){
            muestraSucursalesAcceso('s_id_sucursales',$('#s_id_unidades').val(),idUsuario);
        });

        $('#b_buscar').click(function(){
            $('#fondo_cargando').show();
            muestraReporte(); 
        });

        function muestraReporte(){
            if($('#i_menu').val() != '' || $('#s_id_unidades').val() != null)
            {
                $('#t_registros tbody').empty();

                if($('#s_id_unidades').val() != null)
                    var idUnidadNegocio = $('#s_id_unidades').val();
                else
                    var idUnidadNegocio =  '';

                if($('#s_id_sucursales').val() != null)
                    var idSucursal = $('#s_id_sucursales').val();
                else
                    var idSucursal =  '';

                var datos = {
                    'sistema' : $('#i_menu').val(),
                    'menuid' : $('#i_restriccion').val(),
                    'idUnidadNegocio' : idUnidadNegocio,
                    'idSucursal' : idSucursal
                }; 

                $.ajax({
                    type: 'POST',
                    url: 'php/permisos_usuarios_reporte_buscar.php',
                    dataType:"json", 
                    data:{'datos':datos},
                    success: function(data) {
                        //console.log('data: '+JSON.stringify(data));
                        $('#b_excel').attr('registros',JSON.stringify(data));
                        if(data.length != 0){

                            for(var i=0;data.length>i;i++){
                                var html='<tr class="renglon">';
                                html +='<td data-label="Usuario">'+data[i].usuario+'</td>';
                                html +='<td data-label="No. Empleado">'+data[i].cve_nom+'</td>';
                                html +='<td data-label="Nombre">'+data[i].nombre+'</td>';
                                html +='<td data-label="Estatus">'+data[i].estatus+'</td>';
                                html +='<td data-label="Unidad de Negocio">'+data[i].unidad_negocio+'</td>';
                                html +='<td data-label="Sucursal">'+data[i].sucursal+'</td>';
                                html +='<td data-label="Menú">'+data[i].padre+'</td>';
                                html +='<td data-label="Permiso Restricción">'+data[i].hijo+'</td>';
                                //html +='<td data-label="Tipo">'+data[i].descripcion+'</td>'; //para si se agrega opcion alguna descipcion o el tipo de opcion, ej.: Boton Solicitar Viatico
                                html +='</tr>';
                                
                                $('#t_registros tbody').append(html);    
                            }

                            $('#b_excel').prop('disabled',false);
                            $('#fondo_cargando').hide();

                        }else{
                            $('#b_excel').prop('disabled',true);

                            var html='<tr class="renglon">\
                                            <td colspan="8">No se encontró información</td>\
                                        </tr>';

                            $('#t_registros tbody').append(html);
                            $('#fondo_cargando').hide();
                        }

                    },
                    error: function (xhr) 
                    {
                        console.log('php/permisos_usuarios_reporte_buscar.php --> '+JSON.stringify(xhr));
                        mandarMensaje('* No se encontró información al buscar registros');
                        $('#fondo_cargando').hide();
                    }
                });
            }else{
                mandarMensaje('Es necesario seleccionar una opción en menú y/o unidad de negocio para buscar registros');
                $('#fondo_cargando').hide();
            }
        }

        $('#b_excel').click(function(){
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();

            var registros = $('#b_excel').attr('registros');

            $("#i_nombre_excel").val('Reporte de permisos');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(registros));
            
            $("#f_imprimir_excel").submit();

        });

        function muestraModalOpcionesUsuarios(renglon, tabla, modal){
            $('.'+renglon).remove();

            $.ajax({
                type: 'POST',
                url: 'php/permisos_menu_usuarios_buscar.php',
                dataType:"json",
                success: function(data)
                {
                    if(data.length != 0)
                    {
                        $('.'+renglon).remove();
                
                        for(var i=0;data.length>i;i++)
                        {
                            ///llena la tabla con renglones de registros
                            var html='<tr class="'+renglon+'" alt="'+data[i].id_usuario+'" alt2="'+data[i].usuario+'">\
                                        <td data-label="Nombre">' + data[i].usuario+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#'+tabla).append(html);   
                        }
                         
                        $('#'+modal).modal('show');  

                    }else{
                        mandarMensaje('No se encontró información');
                    }
                },
                error: function (xhr) {
                    console.log('php/permisos_menu_usuarios_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar las opciones de Menú');
                }
            });
        };

        $('#t_usuarios').on('click', '.renglon_usuario', function() {
            var idUsuario = $(this).attr('alt');
            let usuario = $(this).attr('alt2');
            $('#i_filtrar_usuario').val(usuario);
            muestraReporteUsuarios(idUsuario);
            $('#dialog_usuarios').modal('hide');
        });

        function muestraReporteUsuarios(idUsuario){
            $('#fondo_cargando').show();

            if(idUsuario > 0 && idUsuario != undefined){
                $('#t_registros tbody').empty();                

                var datos = {
                    'idUsuario' : idUsuario
                }; 

                $.ajax({
                    type: 'POST',
                    url: 'php/permisos_usuarios_reporte_buscar_usuario.php',
                    dataType:"json", 
                    data:{'datos':datos},
                    success: function(data) {
                        //console.log('data: '+JSON.stringify(data));
                        $('#b_excel').attr('registros',JSON.stringify(data));
                        if(data.length != 0){

                            for(var i=0;data.length>i;i++){
                                var html='<tr class="renglon">';
                                html +='<td data-label="Usuario">'+data[i].usuario+'</td>';
                                html +='<td data-label="No. Empleado">'+data[i].cve_nom+'</td>';
                                html +='<td data-label="Nombre">'+data[i].nombre+'</td>';
                                html +='<td data-label="Estatus">'+data[i].estatus+'</td>';
                                html +='<td data-label="Unidad de Negocio">'+data[i].unidad_negocio+'</td>';
                                html +='<td data-label="Sucursal">'+data[i].sucursal+'</td>';
                                html +='<td data-label="Menú">'+data[i].padre+'</td>';
                                html +='<td data-label="Permiso Restricción">'+data[i].hijo+'</td>';
                                //html +='<td data-label="Tipo">'+data[i].descripcion+'</td>'; //para si se agrega opcion alguna descipcion o el tipo de opcion, ej.: Boton Solicitar Viatico
                                html +='</tr>';
                                
                                $('#t_registros tbody').append(html);    
                            }

                            $('#b_excel').prop('disabled',false);
                            $('#fondo_cargando').hide();

                        }else{
                            $('#b_excel').prop('disabled',true);

                            var html='<tr class="renglon">\
                                            <td colspan="8">No se encontró información</td>\
                                        </tr>';

                            $('#t_registros tbody').append(html);
                            $('#fondo_cargando').hide();
                        }

                    },
                    error: function (xhr) 
                    {
                        console.log('php/permisos_usuarios_reporte_buscar.php --> '+JSON.stringify(xhr));
                        mandarMensaje('* No se encontró información al buscar registros');
                        $('#fondo_cargando').hide();
                    }
                });
            }else{
                mandarMensaje('Es necesario seleccionar un usuario para buscar registros');
                $('#fondo_cargando').hide();
            }
        }
        
    });

</script>

</html>