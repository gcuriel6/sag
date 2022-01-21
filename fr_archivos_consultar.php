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
        text-align:center;
    }
    #div_t_archivos_carpeta,
    #div_t_archivos_carpeta_raiz{
        max-height:180px;
        min-height:180px;
        overflow:auto;
        border: 1px solid #ddd;
    }
    .boton_ver{
        width:100px;
        font-size:8px;
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
        .boton_ver{
            width:100%;
            font-size:11px;
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
                        <div class="titulo_ban">Consultar Archivos</div>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group row">
                                    <label for="s_id_unidades" class="col-sm-12 col-md-12 col-form-label requerido">Unidad de Negocio </label>
                                    <div class="col-sm-12 col-md-12">
                                        <select id="s_id_unidades" name="s_id_unidades" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="s_id_area" class="col-sm-12 col-md-12 col-form-label requerido">Área </label>
                                    <div class="col-sm-12 col-md-12">
                                        <select id="s_id_area" name="s_id_area" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="i_carpeta" class="col-md-12 col-form-label">Carpeta</label>
                                    <div class="input-group col-sm-12 col-md-12">
                                        <input type="text" id="i_carpeta" name="i_carpeta" class="form-control form-control-sm" readonly autocomplete="off">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary" type="button" id="b_buscar_carpetas" style="margin:0px;" disabled>
                                                <i class="fa fa-search" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-12" id="div_contenedor_archivos_carpeta">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-12" id="div_contenedor_archivos_raiz">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>

            <br>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
</body>

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
                <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro" id="i_filtro" class="form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off"></div>
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
 
    var modulo='CONSULTAR_ARCHIVOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var matriz = <?php echo $_SESSION['sucursales']?>;

    $(function(){

        mostrarBotonAyuda(modulo);
        muestraSelectUnidades(matriz,'s_id_unidades',idUnidadActual);
        muestraAreasAcceso('s_id_area');

        $('#s_id_unidades').change(function(){
            $('#div_contenedor_archivos_carpeta').html('');
            $('#i_carpeta').val('').attr('alt','');

            muestraArchivosRaiz($('#s_id_unidades').val(),$('#s_id_area').val());
        });

        $('#s_id_area').change(function(){
            $('#div_contenedor_archivos_carpeta').html('');
            $('#i_carpeta').val('').attr('alt','');
            $('#b_buscar_carpetas').prop('disabled',false);

            muestraArchivosRaiz($('#s_id_unidades').val(),$(this).val());
        });

        $('#b_buscar_carpetas').click(function(){
            if($('#s_id_area').val() != null)
            {
                var idArea = $('#s_id_area').val();
                var idUnidadNegocio = $('#s_id_unidades').val();
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
        });

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
                                                    <th scope="col" style="text-align:left;">Descripción</th>\
                                                    <th scope="col" class="boton_ver"></th>\
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
                                        <td data-label="Descripción" style="text-align:left;">'+data[i].descripcion+'</td>\
                                        <td class="boton_ver"><button type="button" class="btn btn-info btn-sm form-control eliminar_archivo_raiz" id="b_ver_archivo_raiz" alt="'+data[i].id+'" carpeta="'+idArea+'" archivo="'+data[i].nombre+'"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Ver Archivo</button></td>\
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
                                                    <th scope="col" style="text-align:left;">Descripción</th>\
                                                    <th scope="col" class="boton_ver"></th>\
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

                            var html='<tr class="renglon_archivo_carpeta" alt="'+data[i].id+'">\
                                        <td data-label="Descripción" style="text-align:left;">'+data[i].descripcion+'</td>\
                                        <td class="boton_ver"><button type="button" class="btn btn-info btn-sm form-control" id="b_ver_archivo" alt="'+data[i].id+'" carpeta="'+carpeta+'" archivo="'+data[i].nombre+'"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Ver Archivo</button></td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_archivos_carpeta tbody').append(html);   
                        }

                    }else{
                        $('#div_contenedor_archivos_carpeta').html('');
                    }
                },
                error: function (xhr) {
                    console.log('php/archivos_buscar_idCarpeta.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar archivos de la carpeta.');
                }
            });
        }

        $(document).on('click','#b_ver_archivo',function(){
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

        $(document).on('click','#b_ver_archivo_raiz',function(){
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