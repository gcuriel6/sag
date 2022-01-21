<?php session_start(); ?>
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
    #div_contenedor{
        background-color: #ffffff;
    }
    #div_t_presupuesto{
        max-height:370px;
        min-height:370px;
        overflow:auto;
        border: 1px solid #ddd;
    }
    .titulo{
        background: #f8f8f8;
        border: 1px solid #ddd;
        padding: .15em;
        font-weight:bold;
    }
    .tablon {
        font-size: 10px;
    }
    #forma_editar{
        /*border: 1px solid #ddd;*/
        padding: 15px;
    }
    #i_total{
        text-align:right;
    }
    #campo_filtro_importe{
        width:15%;
    }
    #campo_boton{
        width:5%;
    }
    .negrita{
        font-weight:bold;
    }
    .renglon_presupuesto{
        color:grey;
    }
    .editar{
        color:black;
    }
    .botones_editar{
        width:5%;
    }

    /* Responsive Web Design */
    @media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_t_presupuesto{
            height:auto;
            overflow:auto;
        }
        #campo_boton,#campo_filtro_importe{
            width:100%;
        }
        .botones_editar{
            width:100%;
        }
    }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">
        <div class="row">
            <!--<div class="col-md-1"></div>-->
            <div class="col-md-offset-1 col-md-12" id="div_contenedor">
            <br>
                <div class="row form-group">
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Presupuesto de Egresos</div>
                    </div>
                    <div class="col-sm-12 col-md-9">
                        <form id="forma_consultar" name="forma_consultar">
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <label for="s_id_unidad" class="col-form-label requerido">Unidad de Negocio </label>
                                    <select id="s_id_unidad" name="s_id_unidad" class="form-control validate[required]" autocomplete="off" style="width:100%;"></select>
                                </div> 
                                
                                <div class="col-sm-12 col-md-2">
                                    <label for="i_anio" class="col-form-label requerido">Año </label>
                                    <input type="text" id="i_anio" name="i_anio" class="form-control form-control-sm validate[required,custom[integer,minSize[4],maxSize[4]]]" autocomplete="off"/>
                                </div>

                                <div class="col-sm-12 col-md-2">
                                    <label for="i_mes" class="col-form-label requerido">Mes </label>
                                    <select  id="i_mes" name="i_mes" class="form-control" autocomplete="off" style="width:100%;"></select>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <button type="button" class="btn btn-dark btn-sm form-control" id="b_consultar"><i class="fa fa-search" aria-hidden="true"></i> Consultar</button>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <button type="button" class="btn btn-success btn-sm form-control" id="b_excel" disabled><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <tbody>
                                <td><!--<select id="s_filtro_1" alt2="1" alt3="renglon_presupuesto" alt4="5" alt="filtro_unidad" name="s_id_unidad_filtro" class="filtrar_campos_renglones_C form-control form-control-sm" autocomplete="off" style="width:100%;"></select>--></td>
                                <td><select id="s_filtro_2" alt2="2" alt3="renglon_presupuesto" alt4="5" alt="filtro_sucursal" name="s_id_sucursal_filtro" class="filtrar_campos_renglones_C form-control form-control-sm" autocomplete="off" style="width:100%;"></select></td>
                                <td><select id="s_filtro_3" alt2="3" alt3="renglon_presupuesto" alt4="5" alt="filtro_familia" name="s_id_familia_filtro" class="filtrar_campos_renglones_C form-control form-control-sm" autocomplete="off" style="width:100%;"></select></td>
                                <td><select id="s_filtro_4" alt2="4" alt3="renglon_presupuesto" alt4="5" alt="filtro_clasificacion" name="s_id_clasificacion_filtro" class="filtrar_campos_renglones_C form-control form-control-sm" autocomplete="off" style="width:100%;" disabled></select></td>
                                <td><select  id="s_filtro_5" alt2="5" alt3="renglon_presupuesto" alt4="5" alt="filtro_mes" name="s_mes_filtro" class="filtrar_campos_renglones_C form-control form-control-sm" autocomplete="off"></select></td>
                                <td id="campo_filtro_importe"><input type="text" name="i_filtro_importe" id="i_filtro_1" alt2="1" alt3="renglon_presupuesto" alt4="1" alt="filtro_importe" class="filtrar_campos_renglones form-control form-control-sm" placeholder="Filtrar Importe..." autocomplete="off"></td>
                                <td class="botones_editar"></td>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row" id="div_presupuesto">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">UNIDAD DE NEGOCIO</th>
                                    <th scope="col">SUCURSAL</th>
                                    <th scope="col">FAMILIA</th>
                                    <th scope="col">CLASIFICACIÓN</th>
                                    <th scope="col">MES</th>
                                    <th scope="col">IMPORTE</th>
                                    <td class="botones_editar"></td>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_t_presupuesto">
                            <table class="tablon"  id="t_presupuesto">
                                <tbody>
                                    
                                </tbody>
                            </table>  
                        </div>  
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-9"></div>
                    <div class="col-sm-12 col-md-3">
                        <div class="row">
                            <label for="i_total" class="col-form-label col-md-3">Total</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" id="i_total" name="i_total" class="form-control form-control-sm" autocomplete="off" readonly>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!--div_contenedor-->
        </div>  

    </div> <!--div_principal-->

    <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
        <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
        <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
        <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
        <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
    </form>
    
</body>

<div id="dialog_detalles" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Relación factor prorrateo: <span id="dato_importe"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_factor_prorrateo">
                            <thead>
                                <tr class="renglon">                                
                                    <th scope="col">UNIDAD DE NEGOCIO</th> 
                                    <th scope="col">SUCURSAL</th>
                                    <th scope="col">FACTOR PRORRATEO</th>
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

<div id="dialog_editar" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Presupuesto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="forma_editar" name="forma_editar" class="form-group">

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- DIALOGS -->

<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="vendor/select2/js/select2.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>

<script>

    var idUnidadActual = <?php echo $_SESSION['id_unidad_actual']; ?>;
    var idUsuario = <?php echo $_SESSION['id_usuario']; ?>;
    var matriz = <?php echo $_SESSION['sucursales']; ?>;
    var modulo = 'EDITAR_PRESUPUESTO';

    var idPresupuestoEgreso = 0;
    var importeAnterior = 0;
    $(function()
    {
        mostrarBotonAyuda(modulo);
        //-->NJES December/07/2020 obtiene en lista los id de las unidades a las que tiene acceso el usuario
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

        //-->NJES December/07/2020 busca las unidades de negocio que meinimo tenga una sucursal con permiso por usuario y modulo
        buscarUnidadesSucursalPermisoUsuario('s_id_unidad',modulo,idUsuario,listaUnidadesNegocioId(matriz));
        
        muestraSucursalesPermiso('s_filtro_2', idUnidadActual, modulo,idUsuario); 

        $('#s_id_unidad').change(function(){
            var idUnidadNegocio = $('#s_id_unidad').val();
            $('.img-flag').css({'width':'50px','height':'20px'});
            $('#s_filtro_2').prop('disabled',false);
            muestraSucursalesPermiso('s_filtro_2', idUnidadNegocio, modulo,idUsuario); 
        });

        //muestraSelectUnidades(matriz, 's_id_unidad', idUnidadActual);
        //muestraSucursalesPermiso('s_id_sucursal', idUnidadNegocio, modulo,idUsuario); 
        generaFecha('i_mes');
        generaFecha('s_filtro_5');
        //muestraAreasAcceso('s_filtro_1');
        muestraSelectFamiliaGastos('s_filtro_3');

        muestraUnidadesValor(matriz,'s_filtro_1',0);
        //-->NJES July/15/2020 se quita area y departamento ya que no se usan para la carga y consumo de presupuesto egresos
        //muestraSucursalesAcceso('s_filtro_7', idUnidadActual, idUsuario); 

        $('#i_anio').val(anio);
                
        /*$('#s_id_unidad').change(function(){
            var idUnidadNegocio = $('#s_id_unidad').val();
            $('.img-flag').css({'width':'50px','height':'20px'});
            muestraSucursalesAcceso('s_id_sucursal', idUnidadNegocio, idUsuario);
        });

        $('#s_id_sucursal').change(function(){
            muestraAreasAcceso('s_filtro_1');
            muestraSelectFamiliaGastos('s_filtro_3');
            generaFecha('s_filtro_5');
            $("#s_filtro_2,#s_filtro_4").empty().prop("disabled", true);
            $('#t_presupuesto >tbody tr').remove();
            $('#i_total').val('');
        });*/

        $('#b_consultar').click(function(){
            muestraSelectFamiliaGastos('s_filtro_3');
            muestraUnidadesValor(matriz,'s_filtro_1',0);
            generaFecha('s_filtro_5');
            $('#s_filtro_4').prop('disabled',true);
            //$('#i_filtro_1').val('');

            $('#b_consultar').prop('disabled',true);
            if($('#forma_consultar').validationEngine('validate'))
            {
                muestraRegistros();
            }else{
                $('#b_consultar').prop('disabled',false);
            }
        });

        /*$('#s_filtro_1').change(function(){
            var idUnidadNegocio = $('#s_filtro_1').val();
            
            $('#s_filtro_2').prop('disabled',false);
            muestraSucursalesPermiso('s_filtro_2', idUnidadNegocio, modulo,idUsuario); 
        });*/

        $('#s_filtro_2').change(function(){
            //muestraAreasAcceso('s_filtro_1');
            muestraSelectFamiliaGastos('s_filtro_3');
            generaFecha('s_filtro_5');
            $("#s_filtro_4").empty().prop("disabled", true);
        });

        //-->NJES July/15/2020 se quita area y departamento ya que no se usan para la carga y consumo de presupuesto egresos
        /*$('#s_filtro_1').change(function(){
            var idSucursal = $('#s_filtro_7').val();
            //var idArea = $('#s_filtro_1').val();
            //$("#s_filtro_2").empty();
            if(idSucursal > 0)
            {
                $('#i_total').val(formatearNumero(0));
                //muestraDepartamentoAreaInternos('s_filtro_2', idSucursal, idArea);
                //$("#s_filtro_2").prop("disabled", false);
            }
        });*/

        $('#s_filtro_3').change(function(){
            $('#i_total').val(formatearNumero(0));
            var idFamilia = $('#s_filtro_3').val();
            muestraSelectClasificacionGastos('s_filtro_4',idFamilia);
            $("#s_filtro_4").prop("disabled", false);
        });

        $('#s_filtro_4,#s_filtro_5').change(function(){
            $('#i_total').val(formatearNumero(0));
        });

        $('#i_filtro_1').keyup(function(){
            $('#i_total').val(formatearNumero(0));
            sumaTotal();
        });

        function muestraRegistros(){
            $('#i_filtro_1').val('');

            $('#t_presupuesto >tbody tr').remove();
            //var idUnidad =  $('#s_id_unidad').val();
            //var idSucursal = $('#s_id_sucursal').val();

            var id_unidad = $('#s_id_unidad').val();
            var anio = $('#i_anio').val();
            var mes = $('#i_mes').val();

            $.ajax({

                type: 'POST',
                url: 'php/presupuesto_egresos_buscar.php',
                dataType:"json", 
                data:
                {
                    //'id_unidad': idUnidad,
                    //'id_sucursal': idSucursal,
                    //-->NJES December/07/2020 buscar por la unidad seleccionada y de acuerdo a la unidad origen
                    'id_unidad_negocio' : id_unidad,
                    'anio': anio,
                    'mes' : mes
                },
                success: function(data)
                {
                    if(data.length > 0)
                    {
                        for(var i=0; data.length > i; i++)
                        {
                            var presupuesto = data[i];                        

                            var pm = parseFloat(presupuesto.monto);     

                            if(presupuesto.nombre_clasificacion == null)
                            {
                                var nombre_clasificacion = '';
                            }else{
                                var nombre_clasificacion = presupuesto.nombre_clasificacion;
                            }

                            /*if(presupuesto.editar ==1 )
                            {
                                var clase='editar';
                            }else{
                                var clase='';
                            }*/

                            if(presupuesto.editar == 1)
                            {
                                if(presupuesto.prorrateo > 0)
                                {
                                    var botonEditar = "<td class='botones_editar'><button type='button' class='btn btn-info btn-sm b_editar_prorrateo' alt="+presupuesto.id+" alt2="+presupuesto.monto+">\
                                            <i class='fa fa-pencil' aria-hidden='true'></i>\
                                        </button></td>";
                                }else{
                                    var botonEditar = "<td class='botones_editar'><button type='button' class='btn btn-info btn-sm b_editar_monto' alt="+presupuesto.id+" alt2="+presupuesto.monto+" id_unidad="+presupuesto.id_unidad+" id_sucursal="+presupuesto.id_sucursal+">\
                                            <i class='fa fa-pencil' aria-hidden='true'></i>\
                                        </button></td>";
                                }
                            }else{
                                if(presupuesto.prorrateo > 0)
                                {
                                    var botonEditar = "<td class='botones_editar'><button type='button' class='btn btn-secondary btn-sm b_relacion' alt="+presupuesto.id+" alt2="+presupuesto.monto+">\
                                            <i class='fa fa-eye' aria-hidden='true'></i>\
                                        </button></td>";
                                }else{
                                    var botonEditar = "";
                                }
                            }
                            
                            var html = "<tr class='renglon_presupuesto' alt='"+presupuesto.id+"' familia='"+presupuesto.nombre_familia+"' clasificacion='"+nombre_clasificacion+"' mes='"+nombreMes(presupuesto.mes)+"' importe='"+presupuesto.monto+"'>";
                            html += "<td class='filtro_unidad'>" + presupuesto.nombre_unidad + "</td>";
                            html += "<td class='filtro_sucursal'>" + presupuesto.nombre_sucursal + "</td>";
                            //-->NJES July/15/2020 se quita area y departamento ya que no se usan para la carga y consumo de presupuesto egresos
                            //html += "<td class='filtro_area'>" + presupuesto.nombre_area + "</td>";
                            //html += "<td class='filtro_departamento'>" + presupuesto.nombre_depto + "</td>";
                            html += "<td class='filtro_familia'>" + presupuesto.nombre_familia + "</td>";
                            html += "<td class='filtro_clasificacion'>" + nombre_clasificacion + "</td>";
                            html += "<td class='filtro_mes' alt='"+presupuesto.mes+"'>" + nombreMes(presupuesto.mes) + "</td>";
                            html += "<td align='right' class='importe filtro_importe' alt='"+presupuesto.monto+"'>" + formatearNumeroCSS(pm.toFixed(2) + '') +  "</td>";                                
                            html += botonEditar;
                            html += "</tr>";

                            $('#t_presupuesto tbody').append(html);
                        
                        }
                    }else{
                        var html = '<tr><td colspan="6" align="center">No se encontró información</td></tr>';
                        $('#t_presupuesto tbody').append(html);
                    }

                    sumaTotal();
                    $('#b_excel').prop('disabled',false);
                    $('#b_consultar').prop('disabled',false);
                },
                error: function (xhr) 
                {
                    console.log('php/familias_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        /*$('#t_presupuesto').on('dblclick', '.editar', function() {
            idPresupuestoEgreso = $(this).attr('alt');
            $('#label_area').text($(this).attr('area'));
            $('#label_departamento').text($(this).attr('departamento'));
            $('#label_familia').text($(this).attr('familia'));
            $('#label_clasificacion').text($(this).attr('clasificacion'));
            $('#label_mes').text($(this).attr('mes'));
            importeAnterior = $(this).attr('importe');
            $('#i_importe').val(formatearNumero($(this).attr('importe')));

            $(this).remove();
            $('#b_guardar').prop('disabled',false);
            sumaTotal();
        });*/

        $('#t_presupuesto').on('click', '.b_editar_prorrateo', function() {
            var id = $(this).attr('alt');
            var importe = $(this).attr('alt2');

            //var registro='';

            var html='';
            html += '<div class="row form-group"><div class="col-md-3">Monto: $ </div><div class="col-md-5"><input type="text" name="i_monto_'+id+'" id="i_monto_'+id+'" alt="'+id+'" class="form-control form-control-sm validate[required,custom[number,min[0.1]]]" autocomplete="off" value="'+formatearNumero(importe)+'"></div></div>';
            html += '<div class="row form-group">';
            html += '<div class="col-sm-12 col-md-12">';
            html += '<table class="tablon"  id="t_factor_prorrateo_editar">';
            html += '<thead><tr class="renglon">';
            html += '<th scope="col">UNIDAD DE NEGOCIO</th>';
            html += '<th scope="col">SUCURSAL</th>';
            html += '<th scope="col">% FACTOR PRORRATEO</th>';
            html += '</tr></thead>';
            html += '<tbody></tbody>';
            html += '</table>';
            html += '</div>';
            html += '</div>';
            html += '<div class="row"><div class="col-md-8"></div>';
            html += '<div class="col-md-4">';
            html += '<button type="button" class="btn btn-success btn-sm form-control" id="b_guardar_factorP" alt="'+id+'"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>';
            html += '</div></div>';
            $('#forma_editar').html('').append(html);

            $.ajax({
                type: 'POST',
                url: 'php/presupuesto_egresos_buscar_relacion.php',
                dataType:"json", 
                data:{'idPresupuesto':id},
                success: function(data)
                {
                    for(var i=0; data.length > i; i++)
                    {
                        var dato = data[i];

                        var registro='<tr alt="'+dato.id+'">\
                                <td>'+dato.unidad_negocio+'</td>\
                                <td>'+dato.sucursal+'</td>\
                                <td><input type="text" name="i_factor_'+dato.id+'" id="i_factor_'+dato.id+'" alt="'+dato.id+'" alt2="'+id+'" alt3="'+importe+'" class="i_factor form-control form-control-sm validate[required,custom[number,max[100]]]" autocomplete="off" value="'+formatearNumero(dato.factor_prorrateo)+'"></td>\
                            </tr>';

                        $('#t_factor_prorrateo_editar tbody').append(registro);
                    }
                },
                error: function (xhr) 
                {
                    console.log('php/presupuesto_egresos_buscar_relacion.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontro información al buscar la relación del presupuesto.');
                }
            });

            $('#dialog_editar').modal('show');
        });

        $('#t_presupuesto').on('click', '.b_editar_monto', function() {
            
            var id = $(this).attr('alt');
            var importe = $(this).attr('alt2');
            var importeAnterior = $(this).attr('alt2');
            var idUnidad = $(this).attr('id_unidad');
            var idSucursal = $(this).attr('id_sucursal');
            
            var html = '<div class="row">\
                            <label for="s_id_familia" class="col-sm-12 col-md-3 col-form-label requerido">Importe </label>\
                            <div class="col-md-5">\
                                <input type="text" name="i_importe" id="i_importe" class="form-control form-control-sm validate[required,custom[number,min[0.1]]]" autocomplete="off" value="'+formatearNumero(importe)+'">\
                            </div>\
                            <div class="col-md-1"></div>\
                            <div class="col-sm-12 col-md-3">\
                                <button type="button" class="btn btn-success btn-sm form-control" id="b_guardar" alt="'+id+'" importeAnt="'+importeAnterior+'" id_unidad="'+idUnidad+'" id_sucursal="'+idSucursal+'"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>\
                            </div>\
                        </div>';
            $('#forma_editar').html('').append(html);

            $('#dialog_editar').modal('show');
        });

        $(document).on('click','#t_presupuesto .b_relacion',function(){
            var id = $(this).attr('alt');
            var monto = $(this).attr('alt2');
            $('#t_factor_prorrateo tbody').html('');
            $('#dato_importe').text('');

            $.ajax({
                type: 'POST',
                url: 'php/presupuesto_egresos_buscar_relacion.php',
                dataType:"json", 
                data:{'idPresupuesto':id},
                success: function(data)
                {
                    $('#dato_importe').text(' $'+formatearNumero(monto));

                    for(var i=0; data.length > i; i++)
                    {
                        var dato = data[i];

                        var html='<tr alt="'+data.id+'" id="porcentaje_prorrateo_'+id+'">\
                                <td>'+dato.unidad_negocio+'</td>\
                                <td>'+dato.sucursal+'</td>\
                                <td>'+formatearNumero(dato.factor_prorrateo)+'%</td>\
                            </tr>';

                        $('#t_factor_prorrateo tbody').append(html);
                    }

                    $('#dialog_detalles').modal('show');
                },
                error: function (xhr) 
                {
                    console.log('php/presupuesto_egresos_buscar_relacion.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* No se encontro información al buscar la relación del presupuesto.');
                }
            });
        });

        /*$('#b_guardar').click(function(){
            $('#b_guardar').prop('disabled',true);
            if($('#forma_editar').validationEngine('validate'))
            {
               guardar();
            }else{
                $('#b_guardar').prop('disabled',false);
            }
        });*/

        $(document).on('change','.i_factor',function(){
            
            if($(this).validationEngine('validate')==false) {
                var id = $(this).attr('alt');
                var idPresupuesto = $(this).attr('alt2');

                var total = 0;
                $('.i_factor').each(function(index){
                    if(index == (totalEle()-1))
                    {
                        $(this).val(0);
                    }

                    total = total + parseFloat($(this).val());
                    
                    if(totalEle() > 1)
                    {
                        if(index == (totalEle()-1))
                        {
                            if(total < 100)
                            {
                                var restante = 100-total;
                                $(this).val(restante);
                            }else{
                                if(total > 100)
                                {
                                    var restante = 100-(total-100);
                                    $(this).val(restante);
                                }else{
                                    $(this).val(0);
                                }
                            }
                        }
                    }else{
                        $(this).val(100);
                    }
                    
                });

            }else{
                $(this).val('');
            }

        });

        function totalEle(){
            var cont = 0;
            $('.i_factor').each(function(){
                cont++;
            });

            return cont;
        }

        $(document).on('click','#b_guardar_factorP',function(){
            $(this).prop('disabled',true);
            var id = $(this).attr('alt');

            if($('#forma_editar').validationEngine('validate'))
            {
                guardarFactorProrrateo(id,obtieneDatosFP());
            }else{
                $(this).prop('disabled',false);
            }
        });

        function obtieneDatosFP(){
            var j = 0;
            var arreglo = [];

            $(".i_factor").each(function(){
                
                var id = $(this).attr('alt');
                var monto = quitaComa($(this).val());

                arreglo[j] = {
                    'id' : id,
                    'monto' : monto
                };  

                j++;
                
            });

            return arreglo;
        }

        $(document).on('click','#b_guardar',function(){
            $(this).prop('disabled',true);

            var id = $(this).attr('alt');
            var importeAnterior = $(this).attr('importeAnt');
            var idUnidad = $(this).attr('id_unidad');
            var idSucursal = $(this).attr('id_sucursal');

            if($('#forma_editar').validationEngine('validate'))
            {
                guardar(id,importeAnterior,idUnidad,idSucursal);
            }else{
                $(this).prop('disabled',false);
            }
        });

        function guardarFactorProrrateo(idProrrateo,montos){
            var montoP = quitaComa($('#i_monto_'+idProrrateo).val());

            $.ajax({
                type: 'POST',
                url: 'php/presupuesto_egresos_prorrateo_actualizar.php',
                data:  {'idProrrateo':idProrrateo,
                        'montoP':montoP,
                        'montos':montos},
                success: function(data) {
                    console.log(data);
                    if(data > 0 )
                    {
                        mandarMensaje('El factor de prorrateo se actualizó correctamente.');
                        muestraRegistros();
                        limpiar();

                        $('#dialog_editar').modal('hide');
                    }else{ 
                        mandarMensaje('Error al actualizar factor de prorrateo.');
                    }

                    $('#b_guardar_factorP').prop('disabled',false);
                },
                error: function (xhr) 
                {
                    console.log('php/presupuesto_egresos_prorrateo_actualizar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al actualizar factor de prorrateo.');
                    $('#b_guardar_factorP').prop('disabled',false);
                }
            });
        }

        function guardar(idPresupuestoEgreso,importeAnterior,idUnidad,idSucursal){
            var info = {
                'idPresupuestoEgreso':idPresupuestoEgreso,
                'importe': parseFloat(quitaComa($('#i_importe').val())),
                'camposModificados':'IMPORTE: '+importeAnterior+' <br>',
                'idUsuario':idUsuario,
                'modulo':'PRESUPUESTO_EGRESOS',
                'idUnidadNegocio':idUnidad,
                'idSucursal':idSucursal
            };
            $.ajax({
                type: 'POST',
                url: 'php/presupuesto_egresos_actualizar.php',
                data:  {'datos':info},
                success: function(data) {
                    if(data > 0 )
                    {
                        mandarMensaje('El registro se actualizó correctamente.');
                        muestraRegistros();
                        limpiar();

                        $('#dialog_editar').modal('hide');
                    }else{ 
                        mandarMensaje('Error al actualizar.');
                    }

                    $('#b_guardar').prop('disabled',false);
                },
                error: function (xhr) 
                {
                    console.log('php/presupuesto_egresos_actualizar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* Error al actualizar.');
                    $('#b_guardar').prop('disabled',false);
                }
            });
        }

        function limpiar(){
            $('.negrita').text('');
            $('#i_importe').val('');
        }

        function sumaTotal(){
            var total=0;
            
            $('.importe').each(function(){
                if($(this).parent().css('display')!='none')
                {
                    var valor= parseFloat($(this).attr('alt'));

                    total=total+valor;
                }
            });

            $('#i_total').val(formatearNumero(total));
        }

        $('#b_excel').click(function(){
            var datos = {
                'idUnidadNegocio':$('#s_id_unidad').val(),
                'anio' : $('#i_anio').val(),
                'mes' :$('#i_mes').val()
            };

            $("#i_nombre_excel").val('Reporte Presupuesto egresos');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(datos));

            $("#f_imprimir_excel").submit();
        });

        /*
        Funcion para filtrar por campos de renglones
        */
        $(document).on('change','.filtrar_campos_renglones_C',function(){
            
            var id=$(this).prop('id');   //id del input filtro
            var campo=$(this).attr('alt');  //clase del campo en el que se va a buscar
            var visibleid=$(this).attr('alt2');  
            var padre = $(this).attr('alt3');  //nombre del renglon padre
            var valor = $(this).attr('alt4');  //numero de campos
        //$('#my-select option:selected').html()
            var aux = $('#'+id+' option:selected').html();
            
            if(aux == '')
            {
                $('.'+campo).parent().removeClass('v'+visibleid);
                $('.'+campo).parent().show();
            }else{
                $('.'+campo).parent().removeClass('v'+visibleid);
                $('.'+campo+':contains(' + aux + ')').parent().addClass('v'+visibleid).show();
                aux = aux.toLowerCase();
                $('.'+campo+':contains(' + aux + ')').parent().addClass('v'+visibleid).show();
                aux = aux.toUpperCase();
                $('.'+campo+':contains(' + aux + ')').parent().addClass('v'+visibleid).show();
            }

            filtros_comb(valor,padre,id,visibleid);
        });

        function filtros_comb(valor,padre,id,visibleid){

            var parametro_g=valor; // cantidad de input que actuan en el filtrado
            
            $("."+padre).each(function () {  //recorre los renglones pero el cambio es por combo
                var count=0;
            
                if ($('#'+id+' option:selected').html()=='')
                {
                    count=count+0;
                }else{ 
                    if($(this).hasClass('v'+visibleid)==false)
                    {
                        count=count+1;
                    }else{
                        count=count+0;
                    }
                }
                
                if (count==0){
                    $(this).show();
                }else{
                    $(this).hide();
                }  
                
            });

            sumaTotal();
            
        }	

    });
</script>

</html>