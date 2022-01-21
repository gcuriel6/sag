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
    .titulo_tabla{
        width:100%;
        background: #f8f8f8;
        border: 1px solid #ddd;
        padding: .15em;
        font-weight:bold;
    }
    #div_t_archivos_carpeta,
    #div_t_archivos_carpeta_raiz{
        max-height:180px;
        min-height:180px;
        overflow:auto;
        border: 1px solid #ddd;
    }
    .boton_eliminar{
        width:100px;
    }
    #dialog_embebed > .modal-lg{
        min-width: 1000px;
        max-width: 1000px;
    }
    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_t_archivos_carpeta,
        #div_t_archivos_carpeta_raiz{
            height:auto;
            overflow:auto;
        }
        .boton_eliminar{
            width:100%;
        }
        #dialog_embebed > .modal-lg{
            max-width: 300px;
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
                        <div class="titulo_ban">Administración de Archivos</div>
                    </div>
                    <div class="col-sm-12 col-md-6"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_nuevo"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md-1">
                        <input id="i_id_sucursal" type="hidden"/>
                        <input id="i_dato_raiz" type="hidden"/>
                        <input id="i_dato_carpeta" type="hidden"/>
                        <input id="i_dato_archivo" type="hidden"/>
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <form id="forma" name="forma">
                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group row">
                                                <label for="s_id_unidades" class="col-sm-12 col-md-12 col-form-label requerido">Unidad de Negocio </label>
                                                <div class="col-sm-12 col-md-10">
                                                    <select id="s_id_unidades" name="s_id_unidades" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group row">
                                                <label for="s_id_area" class="col-sm-12 col-md-12 col-form-label requerido">Área </label>
                                                <div class="col-sm-12 col-md-10">
                                                    <select id="s_id_area" name="s_id_area" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row" style="border:1px solid #EEEEEE; padding:8px;">
                                        <label for="i_carpeta" class="col-md-2 col-form-label">Carpeta</label>
                                        <div class="input-group col-sm-12 col-md-6">
                                            <input type="text" id="i_carpeta" name="i_carpeta" class="form-control form-control-sm" readonly autocomplete="off">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary" type="button" id="b_buscar_carpetas" style="margin:0px;">
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-1">
                                            <button type="button" class="btn btn-success btn-sm form-control" id="b_crear_carpeta"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                        </div>
                                        <div class="col-sm-12 col-md-1">
                                            <button type="button" class="btn btn-danger btn-sm form-control verificar_permiso" alt="ELIMINAR_CARPETAS_ARCHIVOS" id="b_eliminar_carpeta" disabled><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </div>
                                        <div class="col-sm-12 col-md-1">
                                            <button type="button" class="btn btn-dark btn-sm form-control" id="b_nuevo_carpeta"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                    <div class="form-group row" style="border:1px solid #EEEEEE; padding:8px;">
                                        <label for="i_descripcion_archivo" class="col-sm-2 col-md-2 col-form-label requerido">Descripción de archivo</label>
                                        <div class="col-sm-12 col-md-5">
                                            <input type="text" class="form-control validate[required]" id="i_descripcion_archivo" name="i_descripcion_archivo" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-3">
                                            <input type="file" class="form-control validate[required]" id="i_archivo" name="i_archivo" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-1">
                                            <button type="button" class="btn btn-success btn-sm form-control" id="b_crear_archivo" disabled><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                        </div>
                                        <div class="col-sm-12 col-md-1">
                                            <button type="button" class="btn btn-dark btn-sm form-control" id="b_nuevo_archivo" disabled><i class="fa fa-times-circle" aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-6" id="div_contenedor_archivos_carpeta">
                                        </div>
                                        <div class="col-sm-12 col-md-6" id="div_contenedor_archivos_raiz">
                                        </div>
                                    </div>
                                    <!--<div class="form-group row">
                                        <div class="col-sm-12 col-md-12" id="div_contenedor_archivos_raiz">
                                        </div>
                                    </div>-->
                                </form>
                            </div>
                        </div>
                    </div>  
                </div>

            <br>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
</body>

<div id="dialog_crear_carpeta" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Agregar Carpeta</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="forma_carpeta" name="forma_carpeta"> 
                <div class="row">
                    <label for="i_nombre_carpeta" class="col-sm-2 col-md-2 col-form-label requerido">Nombre</label>
                    <div class="col-sm-12 col-md-10">
                        <input type="text" class="form-control validate[required]" id="i_nombre_carpeta" name="i_nombre_carpeta" autocomplete="off">
                    </div>
                </div> 
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success btn-sm" id="b_guardar_carpeta"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
        </div>
        </div>
    </div>
</div>

<div id="dialog_carpetas" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Carpetas de Área</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro" id="i_filtro" alt="renglon_carpetas" class="form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_carpetas">
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

<div class="modal fade" id="dialog_embebed" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Viewer</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div style="width:100%" id="viewer_doc">
				</div>
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
 
    var modulo='ADMINISTRAR_ARCHIVOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var matriz = <?php echo $_SESSION['sucursales']?>;
    var numCarpetas = 0 ;

    $(function(){

        mostrarBotonAyuda(modulo);
        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        muestraAreasAcceso('s_id_area');

        function verificaPermisoEliminar(idUnidadNegocio,idUsuario,boton,idBoton){
            $.ajax({
                type: 'POST',
                url: 'php/permisos_boton_administrador_archivos.php', 
                data:{
                    'idUsuario' : idUsuario,
                    'boton':boton,
                    'idBoton':idBoton,
                    'idUnidadNegocio':idUnidadNegocio
                },
                success: function(data) {
                    
                    if(data==1){
                        $('#'+idBoton).prop('disabled',false);
                    
                    }else{
                        $('#'+idBoton).prop('disabled',true);
                    }

                },
                error: function (xhr) {
                    console.log("php/permisos_boton_administrador_archivos.php--> "+JSON.stringify(xhr)); 
                    mandarMensaje('* No se encontró información al verificar permisos Aadministrar Archivos.');
                }
            });
        }

        $('#s_id_unidades').change(function(){
            $('#b_crear_archivo,#b_nuevo_archivo').prop('disabled',false);
            $('#div_contenedor_archivos_carpeta').html('');
            $('#i_carpeta').val('').attr('alt','');

            $('#i_dato_raiz').val($(this).val());
            $('#i_dato_carpeta').val('');
            $('#i_dato_archivo').val('');

            muestraArchivosRaiz($('#s_id_unidades').val(),$('#s_id_area').val());
        });

        $('#s_id_area').change(function(){
            $('#b_crear_archivo,#b_nuevo_archivo').prop('disabled',false);
            $('#div_contenedor_archivos_carpeta').html('');
            $('#i_carpeta').val('').attr('alt','');

            $('#i_dato_raiz').val($(this).val());
            $('#i_dato_carpeta').val('');
            $('#i_dato_archivo').val('');
            var idUnidadNegocio = $('#s_id_unidades').val();

            muestraArchivosRaiz(idUnidadNegocio,$(this).val());
        });

        $('#b_nuevo_archivo').click(function(){
            $('#i_descripcion_archivo').val('');
            $('#i_archivo').val('');
        });

        $('#b_nuevo_carpeta').click(function(){
            $('#i_carpeta').val('').attr('alt','');
            $('#b_eliminar_carpeta').prop('disabled',true);
            $('#div_contenedor_archivos_carpeta').html('');
        });
        
        $('#b_buscar_carpetas').click(function(){
            if($('#s_id_area').val() != null)
            {
                var idUnidadNegocio = $('#s_id_unidades').val();
                var idArea = $('#s_id_area').val();
                console.log(idUnidadNegocio + ' ** ' + idArea);
                muestraCarpetasArea(idUnidadNegocio,idArea,'renglon_carpetas','t_carpetas tbody','dialog_carpetas');
            }else{
                mandarMensaje('Debes seleccionar un Área');
            }
        });

        $('#t_carpetas').on('click', '.renglon_carpetas', function() {
            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            $('#i_carpeta').attr('alt',id).val(nombre);
            $('#dialog_carpetas').modal('hide');
            muestraArchivosCarpeta(id,nombre);
            $('#i_dato_carpeta').val(nombre);
        });

        $('#b_crear_carpeta').click(function(){
            if($('#s_id_area').val() != null)
            {
                var idArea = $('#s_id_area').val();
                $('#b_guardar_carpeta').attr('alt',idArea);
                $('#dialog_crear_carpeta').modal('show');
            }else{
                mandarMensaje('Debes seleccionar un Área');
            }
        });

        $('#b_guardar_carpeta').click(function(){
            var idArea = $('#b_guardar_carpeta').attr('alt');
            $('#b_guardar_carpeta').prop('disabled',true);

            if($('#forma_carpeta').validationEngine('validate'))
            {
                verificaCarpeta($('#s_id_unidades').val(),idArea);
            }else{
                $('#b_guardar_carpeta').prop('disabled',false);
            }
        });

        function verificaCarpeta(idUnidadNegocio,idArea){
            var info = {'nombre':$('#i_nombre_carpeta').val(),
                        'idArea':idArea,
                        'tipo':'carpeta',
                        'idUnidadNegocio':idUnidadNegocio};
            $.ajax({
                type: 'POST',
                url: 'php/archivos_carpetas_verificar.php',
                dataType:"json", 
                data:  {'datos':info},
                success: function(data) 
                {   
                    if(data == 1){
                        mandarMensaje('Ya existe una carpeta con el nombre: '+ $('#i_nombre_carpeta').val()+'. para el área. Intenta con otro nombre.');
                        $('#b_guardar_carpeta').prop('disabled',false);
                    } else {
                        guardarCarpeta();
                    }
                },
                error: function (xhr) {
                    console.log("php/archivos_carpetas_verificar.php--> "+JSON.stringify(xhr));    
                    mandarMensaje('* No se encontró información al verificar carpeta');
                    $('#b_guardar_carpeta').prop('disabled',false);
                }
            });
        }

        function guardarCarpeta(){
            var nombreCarpeta = $('#i_nombre_carpeta').val();
            var info = {'nombre':nombreCarpeta,
                        'idArea':$('#s_id_area').val(),
                        'idUnidadNegocio':$('#s_id_unidades').val(),
                        'tipo':'carpeta'};


                console.log('carpeta' + nombreCarpeta);
                console.log('area' + $('#s_id_area').val());
                console.log('unidad de negocio' + $('#s_id_unidades').val());
            $.ajax({
                type: 'POST',
                url: 'php/archivos_carpetas_guardar.php',
                dataType:"json", 
                data:  {'datos':info},
                success: function(data) 
                {   
                    if(data > 0)
                    {
                        mandarMensaje('Se creo correctamente la carpeta');
                        $('#b_guardar_carpeta').prop('disabled',false);
                        $('#i_carpeta').attr('alt',data).val(nombreCarpeta);
                        $('#dialog_crear_carpeta').modal('hide');
                        $('#i_nombre_carpeta').val('');
                        muestraArchivosCarpeta(data,nombreCarpeta);
                    }else{
                        mandarMensaje('Error al crear carpeta.');
                        $('#b_guardar_carpeta').prop('disabled',false);
                    } 
                },
                error: function (xhr) {
                    console.log("php/archivos_carpetas_guardar.php--> "+JSON.stringify(xhr));    
                    mandarMensaje('* Error al crear carpeta');
                    $('#b_guardar_carpeta').prop('disabled',false);
                }
            });
        }

        $('#b_crear_archivo').click(function(){
            $('#b_crear_archivo').prop('disabled',true);

            if($('#forma').validationEngine('validate'))
            {
                verificaArchivo();
            }else{
                $('#b_crear_archivo').prop('disabled',false);
            }
        });

        function verificaArchivo(){
            if($('#i_carpeta').val() != '')
                var idCarpeta = $('#i_carpeta').attr('alt');
            else
                var idCarpeta = 0;

            var info = {
                        'idUnidadNegocio':$('#s_id_unidades').val(),
                        'descripcion':$('#i_descripcion_archivo').val(),
                        'idArea':$('#s_id_area').val(),
                        'tipo':'archivo',
                        'idCarpeta':idCarpeta
                    };   

            $.ajax({
                type: 'POST',
                url: 'php/archivos_carpetas_verificar.php',
                dataType:"json", 
                data:  {'datos':info},
                success: function(data) 
                {   
                    if(data == 1){
                        mandarMensaje('Ya existe un archivo con la descripción: '+ $('#i_descripcion_archivo').val()+'. Intenta con otra.');
                        $('#b_crear_archivo').prop('disabled',false);
                    }else{
                        guardarArchivo();
                    }
                },
                error: function (xhr) {
                    console.log("php/archivos_carpetas_verificar.php--> "+JSON.stringify(xhr));    
                    mandarMensaje('* No se encontró información al verificar descripción archivo');
                    $('#b_crear_archivo').prop('disabled',false);
                }
            });
        }

        function guardarArchivo(){
            if($('#i_carpeta').val() != '')
                var idCarpeta = $('#i_carpeta').attr('alt');
            else
                var idCarpeta = 0;

            //Damos el valor del input tipo_mov file
            var archivos = document.getElementById("i_archivo");

            //Obtenemos el valor del input (los archivos) en modo de arreglo
            var i_archivo = archivos.files; 

            var datos = new FormData();

            datos.append('idArea',$('#s_id_area').val());
            datos.append('idUnidadNegocio',$('#s_id_unidades').val());
            datos.append('tipo','archivo');
            datos.append('descripcion',$('#i_descripcion_archivo').val());
            datos.append('idCarpeta',idCarpeta);
            datos.append('nombreCarpeta',$('#i_carpeta').val())
            datos.append('archivo',i_archivo[0]);

            var tamanoArchivo = (i_archivo[0].size)/1048576;
            var fichero = $('#i_archivo').val();  

            var nombreA = archivos.files[0].name;
            var pos = nombreA.indexOf('.');
            var res = nombreA.substring(0,pos);
            
            var validar = /^[a-zA-Z0-9_]+$/;
            
            var ext = fichero.split('.');
            ext = ext[ext.length -1];

            if(esPDF(ext))
            { //valida la extension del archivo
                if(validar.test(res))
                {
                    if(tamanoArchivo <= 5)
                    {
                        $.ajax({
                            type: 'POST',
                            url: 'php/archivos_guardar.php',  
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: datos,
                            //mientras enviamos el archivo
                            //mensaje de que el archivo se esta subiendo
                            beforeSend: function(){
                                if($("#i_archivo").val()!=''){ 
                                    mandarMensaje("Subiendo el archivo, por favor espere...");     
                                }else{
                                    mandarMensaje("Generando registro, por favor espere...");
                                }   
                            },
                            //una vez finalizado correctamente
                            success: function(data) 
                            {   
                                if(data > 0)
                                {
                                    mandarMensaje('Se subio correctamente el archivo.');
                                    $('#b_crear_archivo').prop('disabled',false);
                                    $('#i_descripcion_archivo').val('');
                                    $('#i_archivo').val('');
                                    muestraArchivosRaiz($('#s_id_unidades').val(),$('#s_id_area').val());
                                    muestraArchivosCarpeta(idCarpeta,$('#i_carpeta').val());
                                }else{
                                    mandarMensaje('Error al subir el archivo.');
                                    $('#b_crear_archivo').prop('disabled',false);
                                } 
                            },
                            error: function (xhr) {
                                console.log("php/archivos_guardar.php--> "+JSON.stringify(xhr));    
                                mandarMensaje('* Error al crear carpeta');
                                $('#b_crear_archivo').prop('disabled',false);
                            }
                        });
                    }else{
                        mandarMensaje('El archivo no sebe sobrepasar los 5 MB.');
                        $('#b_crear_archivo').prop('disabled',false);
                    }
                }else{
                    mandarMensaje('El nombre del archivo no es valido, no debe contener espacios ni caracteres especiales.');
                    $('#b_crear_archivo').prop('disabled',false);
                }
            }else{
                mandarMensaje('Verifica la extensión del archivo. Debe ser PDF');
                $('#b_crear_archivo').prop('disabled',false);
            }
        }

        function esPDF(extension){
            if(extension!=''){
							
                switch(extension.toLowerCase()) 
                {
                    case 'pdf':
                    return true;
                    break;
                    default:
                    return false;
                    break;
                }
            }else{
                return true;	
            }
        }

        function muestraArchivosRaiz(idUnidadNegocio,idArea){
            $('#div_contenedor_archivos_raiz').html('');

            $.ajax({
                type: 'POST',
                url: 'php/archivos_buscar_raiz.php',
                dataType:"json", 
                data : {'idUnidadNegocio':idUnidadNegocio,'idArea':idArea},
                success: function(data) {
                    if(data.length != 0){
                        var tabla = '<div class="row">\
                                    <div class="col-sm-12 col-md-12"><div class="titulo_tabla">Archivos Carpeta Raíz</div></div>\
                                    </div>\
                                    <div class="row"><div class="col-sm-12 col-md-12">\
                                        <table class="tablon">\
                                            <thead>\
                                                <tr class="renglon">\
                                                    <th scope="col">Archivo</th>\
                                                    <th scope="col">Descripción</th>\
                                                    <th scope="col" class="boton_eliminar"></th>\
                                                </tr>\
                                            </thead>\
                                        </table>\
                                        <div id="div_t_archivos_carpeta_raiz">\
                                            <table class="tablon"  id="t_archivos_carpeta_raiz">\
                                                <tbody>\
                                                </tbody>\
                                            </table>\
                                        </div></div></div>';

                        $('#div_contenedor_archivos_raiz').append(tabla);

                        for(var i=0;data.length>i;i++){

                            var html='<tr class="renglon_archivo_carpeta_raiz" alt="'+data[i].id+'">\
                                        <td data-label="Archivo">'+data[i].nombre_original+'</td>\
                                        <td data-label="Descripción">'+data[i].descripcion+'</td>\
                                        <td class="boton_eliminar">\
                                        <button type="button" class="btn btn-info btn-sm ver_archivo_raiz" alt="'+data[i].id+'" carpeta="'+idArea+'" archivo="'+data[i].nombre+'"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>\
                                        <button type="button" class="btn btn-danger btn-sm eliminar_archivo_raiz" id="b_eliminar_archivo_raiz" alt="'+data[i].id+'" carpeta="'+idArea+'" archivo="'+data[i].nombre+'"><i class="fa fa-trash" aria-hidden="true"></i></button></td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_archivos_carpeta_raiz tbody').append(html);   
                        }
                    }else{
                        $('#div_contenedor_archivos_raiz').html('');
                    }
                },
                error: function (xhr) {
                    console.log('php/archivos_buscar_raiz.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar archivos de la carpeta.');
                }
            });
        }

        $(document).on('click','#b_eliminar_archivo_raiz',function(){
            var id = $(this).attr('alt');
            var carpeta = $(this).attr('carpeta');
            var archivo = $(this).attr('archivo');

            $('#i_dato_archivo').val(archivo);

            mandarMensajeConfimacion('Se eliminará el archivo, ¿Deseas continuar?',id,'borrar_archivo_raiz');
        });

        $(document).on('click','#b_borrar_archivo_raiz',function(){ 
            var idArchivo = $(this).attr('alt');

            var info = {
                'idUnidadNegocio':$('#s_id_unidades').val(),
                'idArchivo':idArchivo,
                'archivo':$('#i_dato_archivo').val(),
                'carpetaRaiz':$('#i_dato_raiz').val(),
                'tipo':'raiz'   
            };

            $.ajax({
                type: 'POST',
                url: 'php/archivos_eliminar.php',
                dataType:"json", 
                data:  {'datos':info},
                success: function(data) {
                    if(data == 0 ){
                        mandarMensaje('Error al eliminar archivo.');
                    }else{
                        mandarMensaje('Se eliminó el archivo correctamente.');
                        muestraArchivosRaiz($('#s_id_unidades').val(),$('#s_id_area').val());
                    }
                },
                error: function (xhr) {
                    console.log('php/archivos_eliminar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al eliminar archivo.');
                }
            });
        });

        function muestraArchivosCarpeta(idCarpeta,carpeta){
            $('#div_contenedor_archivos_carpeta').html('');

            $.ajax({
                type: 'POST',
                url: 'php/archivos_buscar_idCarpeta.php',
                dataType:"json", 
                data : {'idCarpeta':idCarpeta,
                        'carpeta':carpeta},
                success: function(data) {
                    if(data.length != 0){
                        var tabla = '<div class="row">\
                                    <div class="col-sm-12 col-md-12"><div class="titulo_tabla">Archivos Carpeta</div></div>\
                                    </div>\
                                    <div class="row"><div class="col-sm-12 col-md-12">\
                                        <table class="tablon">\
                                            <thead>\
                                                <tr class="renglon">\
                                                    <th scope="col">Archivo</th>\
                                                    <th scope="col">Descripción</th>\
                                                    <th scope="col" class="boton_eliminar"></th>\
                                                </tr>\
                                            </thead>\
                                        </table>\
                                        <div id="div_t_archivos_carpeta">\
                                            <table class="tablon"  id="t_archivos_carpeta">\
                                                <tbody>\
                                                </tbody>\
                                            </table>\
                                        </div></div></div>';

                        $('#div_contenedor_archivos_carpeta').append(tabla);

                        for(var i=0;data.length>i;i++){
                            numCarpetas++;

                            var html='<tr class="renglon_archivo_carpeta" alt="'+data[i].id+'">\
                                        <td data-label="Archivo">'+data[i].nombre_original+'</td>\
                                        <td data-label="Descripción">'+data[i].descripcion+'</td>\
                                        <td class="boton_eliminar">\
                                        <button type="button" class="btn btn-info btn-sm ver_archivo_carpeta" alt="'+data[i].id+'" carpeta="'+carpeta+'" archivo="'+data[i].nombre+'"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>\
                                        <button type="button" class="btn btn-danger btn-sm eliminar_archivo" id="b_eliminar_archivo" alt="'+data[i].id+'" carpeta="'+carpeta+'" archivo="'+data[i].nombre+'"><i class="fa fa-trash" aria-hidden="true"></i></button></td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_archivos_carpeta tbody').append(html);   
                        }

                        verificaPermisoEliminar($('#s_id_unidades').val(),idUsuario,'ELIMINAR_CARPETAS_ARCHIVOS','b_eliminar_carpeta');
                    }else{
                        $('#div_contenedor_archivos_carpeta').html('');
                        $('#b_eliminar_carpeta').prop('disabled',false); 
                        numCarpetas = 0;
                    }
                },
                error: function (xhr) {
                    console.log('php/archivos_buscar_idCarpeta.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar archivos de la carpeta.');
                }
            });
        }

        $(document).on('click','#b_eliminar_archivo',function(){
            var id = $(this).attr('alt');
            var carpeta = $(this).attr('carpeta');
            var archivo = $(this).attr('archivo');

            $('#i_dato_carpeta').val(carpeta);
            $('#i_dato_archivo').val(archivo);

            mandarMensajeConfimacion('Se eliminará el archivo, ¿Deseas continuar?',id,'borrar_archivo');
        });

        $(document).on('click','#b_borrar_archivo',function(){ 
            var idArchivo = $(this).attr('alt');

            var info = {
                'idUnidadNegocio':$('#s_id_unidades').val(),
                'idArchivo':idArchivo,
                'archivo':$('#i_dato_archivo').val(),
                'carpeta':$('#i_dato_carpeta').val(),
                'carpetaRaiz':$('#i_dato_raiz').val(),
                'tipo':'carpeta'   
            };

            $.ajax({
                type: 'POST',
                url: 'php/archivos_eliminar.php',
                dataType:"json", 
                data:  {'datos':info},
                success: function(data) {
                    if(data == 0 ){
                        mandarMensaje('Error al eliminar archivo.');
                    }else{
                        mandarMensaje('Se eliminó el archivo correctamente.');

                        if($('#i_carpeta').val() != '')
                            muestraArchivosCarpeta($('#i_carpeta').attr('alt'),$('#i_carpeta').val());
                        else
                            $('#div_contenedor_archivos_carpeta').html('');
                    }
                },
                error: function (xhr) {
                    console.log('php/archivos_eliminar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al eliminar archivo.');
                }
            });
        });

        $('#b_eliminar_carpeta').click(function(){
            mandarMensajeConfimacion('Se eliminará la carpeta con su contenido, ¿Deseas continuar?',0,'borrar_carpeta');
        });

        $(document).on('click','#b_borrar_carpeta',function(){ 
            var info = {
                'idUnidadNegocio':$('#s_id_unidades').val(),
                'idCarpeta':$('#i_carpeta').attr('alt'),
                'carpeta':$('#i_dato_carpeta').val(),
                'carpetaRaiz':$('#i_dato_raiz').val(),
                'archivos':numCarpetas
            };

            $.ajax({
                type: 'POST',
                url: 'php/archivos_carpeta_eliminar.php',
                dataType:"json", 
                data:  {'datos':info},
                success: function(data) {
                    if(data == 0 ){
                        mandarMensaje('Error al eliminar carpeta.');
                    }else{
                        mandarMensaje('Se eliminó la carpeta correctamente.');

                        $('#i_carpeta').val('').attr('alt');
                        $('#div_contenedor_archivos_carpeta').html('');
                        $('#b_eliminar_carpeta').prop('disabled',true);
                    }
                },
                error: function (xhr) {
                    console.log('php/archivos_carpeta_eliminar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al eliminar carpeta.');
                }
            });
        });

        $('#b_nuevo').click(function(){
            muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
            muestraAreasAcceso('s_id_area');

            $('#forma input').val('');
            $('#forma').validationEngine('hide');
            $('#b_guardar').prop('disabled',false);
            $('#div_contenedor_archivos_carpeta').html('');
            $('#div_contenedor_archivos_raiz').html('');

            $('#i_dato_raiz').val('');
            $('#i_dato_carpeta').val('');
            $('#i_dato_archivo').val('');
            $('#b_eliminar_carpeta').prop('disabled',true);
            numCarpetas = 0;
        });

        $(document).on('click','.ver_archivo_carpeta',function(){
            var id = $(this).attr('alt');
            var carpeta = $(this).attr('carpeta');
            var archivo = $(this).attr('archivo');
            var carpetaRaiz = $('#s_id_area').val();
            var idUnidadNegocio = $('#s_id_unidades').val();
            
            $("#viewer_doc").empty();    //limpio lo que haya en el div viewer_doc
            
            var fil="<embed width='100%' height='500px' src='administracion_archivos/"+idUnidadNegocio+"/"+carpetaRaiz+"/"+carpeta+"/"+archivo+"'>";
            $("#viewer_doc").append(fil);
            $("#dialog_embebed").modal("show")
            
        });

        $(document).on('click','.ver_archivo_raiz',function(){
            var id = $(this).attr('alt');
            var carpeta = $(this).attr('carpeta');
            var archivo = $(this).attr('archivo');
            var idUnidadNegocio = $('#s_id_unidades').val();

            $("#viewer_doc").empty();    //limpio lo que haya en el div viewer_doc
            
            var fil="<embed width='100%' height='500px' src='administracion_archivos/"+idUnidadNegocio+"/"+carpeta+"/"+archivo+"'>";
            $("#viewer_doc").append(fil);
            $("#dialog_embebed").modal("show")
        });

    });

</script>

</html>