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
    #div_presupuesto{
        max-height:300px;
        min-height:300px;
        overflow:auto;
        border: 1px solid #ddd;
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
    #forma{
        border: 1px solid #ddd;
        padding:0px 5px 20px 5px;
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

    /* Responsive Web Design */
    @media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_presupuesto{
            height:auto;
            overflow:auto;
        }
        #campo_boton,#campo_filtro_importe{
            width:100%;
        }
    }
    .Familia,.Presupuesto,.Ejercido,.Porcentaje{
        width:300px;
    }

    th[class^='D']{
        width:100px;
    }
    .renglon_presupuesto{
        font-size:14px;
    }
   
    .trP > td{
        background-color:#ffdd99;
    }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">
  
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor">
            <br>
                <div class="row form-group">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Seguimiento Presupuesto de Egresos</div>
                    </div>

                    <div class="col-sm-12 col-md-5">
                        <div class="row">

                            <div class="col-sm-12 col-md-3">
                                Familia <input type="radio" name="radio_tipo" id="r_familia" checked value="1"> 
                            </div>

                            <div class="col-sm-12 col-md-4">
                                Clasificación <input type="radio" name="radio_tipo" id="r_clasificacion" value="2"> 
                            </div>

                            <div class="col-sm-12 col-md-3">
                                Diario <input type="radio" name="radio_tipo" id="r_diario" value="3"> 
                            </div>
                            
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                    </div>
                    
                    <div class="col-sm-12 col-md-1"></div>

                </div>

                <form id="forma_consultar" name="forma_consultar">
                    <div class="row">

                        <div class="col-sm-12 col-md-4">
                            <label for="s_id_unidad" class="col-sm-2 col-md-12 col-form-label requerido">Unidad de Negocio </label>
                            <div class="col-sm-12 col-md-12">
                                <select id="s_id_unidad" name="s_id_unidad" class="form-control validate[required]" autocomplete="off"></select>
                            </div>
                        </div>
                        
                        <div class="col-sm-12 col-md-4">
                            <label for="s_id_sucursal" class="col-sm-2 col-md-6 col-form-label ">Sucursal </label>
                            <div class="col-sm-12 col-md-12">
                                <select id="s_id_sucursal" name="s_id_sucursal" class="form-control validate[required]" autocomplete="off"></select>
                            </div>
                        </div>

                        <!--<div class="col-sm-12 col-md-3">
                            <label for="s_id_area" class="col-sm-2 col-md-6 col-form-label ">Area </label>
                            <div class="col-sm-12 col-md-12">
                                <select id="s_id_area" name="s_id_area" class="form-control validate[required]" autocomplete="off"></select>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-3">
                            <label for="s_id_departamento" class="col-sm-2 col-md-12 col-form-label ">Departamento Interno </label>
                            <div class="col-sm-12 col-md-12">
                                <select id="s_id_departamento" name="s_id_departamento" class="form-control validate[required]" autocomplete="off"></select>
                            </div>
                        </div>-->
                    </div>
                </form>
                <br>

                <div class="row form-group">
                    <div class="col-sm-12 col-md-2">
                        <label for="i_anio" class="col-sm-2 col-md-6 col-form-label">Año </label>
                        <div class="col-sm-12 col-md-12">
                            <input type="text" id="i_anio" name="i_anio" class="form-control izquierda validate[required,custom[integer],minSize[4],maxSize[4]]" autocomplete="off"/>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <label for="s_mes_inicial" class="col-sm-6 col-md-8 col-form-label">Mes Inicial</label>
                        <div class="col-sm-12 col-md-12">
                            <select  id="s_mes_inicial" name="s_mes_inicial" class="form-control validate[required]" autocomplete="off"/></select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <label for="s_mes_final" class="col-sm-6 col-md-8 col-form-label">Mes Final</label>
                        <div class="col-sm-12 col-md-12">
                            <select  id="s_mes_final" name="s_mes_final" class="form-control validate[required]" autocomplete="off"/></select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <br>
                        <input type="text" name="i_filtro" id="i_filtro" class="form-control filtrar_renglones" alt="renglon_presupuesto" placeholder="Filtrar..." autocomplete="off">
                    </div>
                </div>

                <div class="row" id="div_presupuesto">
                   
                </div>

                <br>

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
    var modulo='SEGUIMIENTO_EGRESOS';
    var reporte='';

    $(function()
    {
        mostrarBotonAyuda(modulo);
        generaFecha('s_mes_inicial');
        generaFecha('s_mes_final');
        $("#i_anio").val(new Date().getFullYear());

        muestraSelectUnidades(matriz, 's_id_unidad', idUnidadActual);
        //muestraSucursalesAcceso('s_id_sucursal', idUnidadActual, idUsuario); 
        muestraSucursalesPermiso('s_id_sucursal', idUnidadActual, modulo,idUsuario); 
        //muestraAreasAcceso('s_id_area');
      
        muestraReporte();

        $('#s_id_unidad').change(function(){
            //muestraSucursalesAcceso('s_id_sucursal',$('#s_id_unidad').val(),idUsuario);
            muestraSucursalesPermiso('s_id_sucursal', $('#s_id_unidad').val(), modulo,idUsuario); 
            //$('#s_id_area').val('').select2({placeholder: ''}).prop('disabled',true);
            //$('#s_id_departamento').val('').select2({placeholder: ''}).prop('disabled',true);
            $('.img-flag').css({'width':'50px','height':'20px'});
            $('#i_filtro').val('');
            muestraReporte();
        });

        /*$('#s_id_departamento').change(function()
        {

            //
            muestraReporte();

        });*/

                
        $('#s_id_sucursal').change(function(){
            
            var idSucursal = $('#s_id_sucursal').val();
            //var idAreaFiltro = $('#s_id_area').val();
            //$("#s_id_departamento").empty();
            if(idSucursal > 0)
                //console
            {
              /*if(idAreaFiltro > 0)
              {
                //alert('AAAA --> ' + idSucursal + ' ** ' + idArea);
                muestraDepartamentoAreaInternos('s_id_departamento', idSucursal, idAreaFiltro);
                $("#s_id_departamento").prop("disabled", false);
                muestraReporte();
              }else{*/
                muestraReporte();
              //}
               
               //-->NJES July/19/2020 agregar opción Mostrar Todas en las sucursales
                $('#s_id_sucursal').find('option[value="0"]').remove();
                $('#s_id_sucursal').append('<option value="0">Mostrar Todas</option>');
            }else{
                $('#s_id_sucursal').find('option[value="0"]').remove();
                $('#s_id_sucursal').append('<option value="0" selected>Mostrar Todas</option>');

                muestraReporte();
            }
        });

        /*$('#s_id_area').change(function(){
            var idSucursal = $('#s_id_sucursal').val();
            var idArea = $('#s_id_area').val();
            $("#s_id_departamento").empty();
            if(idSucursal > 0 && idArea > 0)
            {
                //alert('IIII --> ' + idSucursal + ' ** ' + idArea);
                muestraDepartamentoAreaInternos('s_id_departamento', idSucursal, idArea);
                $("#s_id_departamento").prop("disabled", false);
                muestraReporte();
            }
        });*/


        $('#s_mes_inicial').on('change',function(){
             var valor=$(this).val();
             if(parseInt($('input[name=radio_tipo]:checked').val())==3){
                generaFecha('s_mes_final');
                $('#s_mes_final').val(valor);
                muestraReporte();
             }
        });

        $('#s_mes_final').on('change',function(){
             muestraReporte(); 
        });

        $('#i_anio').on('change',function(){
             muestraReporte(); 
        });

        function generaFechaInicial()
        {

            var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

            $('#s_mes_inicial').select2();
            $('#s_mes_inicial').html('');
            var html = '<option selected disabled>Selecciona</option>';
            $('#s_mes_inicial').append(html);

            var d = new Date();
            var monthC = d.getMonth() + 1;

            for(var i = monthC; i < meses.length; i++)
            {
                var actual = meses[i];
                   
                var html = "<option value=" + (i + 1) + ">" + actual + "</option>";
                $('#s_mes_inicial').append(html);

            }

        }

        $('input[name=radio_tipo]').on('click',function(){
            generaFecha('s_mes_inicial');
            generaFecha('s_mes_final');
            var valor=$('input[name=radio_tipo]:checked').val();
        
            if(parseInt(valor)==3){

                $('#s_mes_final').val($('#s_mes_inicial').val());
                $('#s_mes_final').prop('disabled',true);

                if($('#s_mes_inicial').val()>0){
                    muestraReporte();
                }else{
                    mandarMensaje('Para mostrar el reporte de diario se debe selecionar un mes');
                }
               

            }else{
               
                $('#s_mes_final').prop('disabled',false);
                muestraReporte();
            }
          
               
        });


        function muestraReporte(){

            var tipo=$('input[name=radio_tipo]:checked').val();
            
            if(tipo==1)
                reporte='familia';
            else if(tipo==2)
                reporte='clasificacion';
            else
                reporte='diario';

            $('#div_presupuesto').empty();
            var idUnidad =  $('#s_id_unidad').val();

            //-->NJES July/19/2020 enviar la lista de sucursales permisos de la unidad, modulo y usuario
            //si no hay una sucursal seleccionada o si es la opción Mostrar Todas
            if($('#s_id_sucursal').val() >= 1)
                var idSucursal = $('#s_id_sucursal').val();
            else
                var idSucursal = muestraSucursalesPermisoListaId($('#s_id_unidad').val(),modulo,idUsuario);

            //var idArea = $('#s_id_area').val();
            //var idDepartamento = $('#s_id_departamento').val();
            var mesInicial = $('#s_mes_inicial').val();
            var mesFinal = $('#s_mes_final').val();
            var anio = $('#i_anio').val();

            var datos={
                'idUnidad': idUnidad,
                'idSucursal': idSucursal,
                //'idArea': idArea,
                //'idDepartamento': idDepartamento,
                'mesInicial': mesInicial,
                'mesFinal': mesFinal,
                'anio': anio
            };

            console.log(JSON.stringify(datos));
            $.ajax({

                type: 'POST',
                url: 'php/presupuesto_egresos_seguimiento_cargar.php',
                data:
                {   
                    'reporte':reporte,
                    'datos':datos
                    
                },
                success: function(data)
                {
                    //console.log(data);
                    $('#div_presupuesto').append(data); 

                    //NJES Jan/14/2020 SEGUIMIENTO PRESUPUESTO EGRESOS (2) (DEN18-2427) 
                    //Marcar con otro color, las partidas no presupuestados en las que sí ha habido egresos.
                    $(document).find('.sin_presupuesto').each(function(){
                        $(this).parent().addClass('trP');
                    });

                    $(document).find('.sin_gasto').each(function(){
                        $(this).parent().removeClass('trP');
                    });
                    
                },
                error: function (xhr) 
                {
                    console.log('php/presupuesto_egresos_segumiento_cargar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('*Error en el sistema');
                }
            });

            
        }

        $('#b_excel').click(function(){
            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();

            //-->NJES July/19/2020 enviar la lista de sucursales permisos de la unidad, modulo y usuario
            //si no hay una sucursal seleccionada o si es la opción Mostrar Todas
            if($('#s_id_sucursal').val() >= 1)
                var idSucursal = $('#s_id_sucursal').val();
            else
                var idSucursal = muestraSucursalesPermisoListaId($('#s_id_unidad').val(),modulo,idUsuario);

            var datos = {
                'mesInicio':$('#s_mes_inicial').val(),
                'mesFin':$('#s_mes_final').val(),
                'idUnidadNegocio':$('#s_id_unidad').val(),
                'idSucursal':idSucursal,
                //'idArea':$('#s_id_area').val(),
                //'idDepartamento':$('#s_id_departamento').val(),
                'anio':$('#i_anio').val(),
                'reporte':reporte
            };

            console.log(JSON.stringify(datos));

            if(reporte == 'familia')
            {
                var nombre = 'Seguimiento_egresos_porFamilia';
            }else if(reporte == 'clasificacion')
            {
                var nombre = 'Seguimiento_egresos_porClasificación';
            }else{
                var nombre = 'Seguimiento_egresos_Diario_'+$('#s_mes_inicial').val();
            }
            
            $("#i_nombre_excel").val(nombre);
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(datos));
            
            $("#f_imprimir_excel").submit();
        });

    });
</script>

</html>