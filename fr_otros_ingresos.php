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
    .div_contenedor{
        background-color: #ffffff;
    }
    #div_t_registros{
        min-height:250px;
        max-height:250px;
        overflow:auto;
    }
    #pantalla_deudores_diversos,
    #pantalla_pago_deudores{
        position: absolute;
        top:10px;
        left:0px;
        height: 95%;
    }
    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_t_registros{
            height:auto;
            overflow:auto;
        }
    }
    
</style>

<body>
       <div class="container-fluid" >
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="titulo_ban">Otros Ingresos</div>
                    </div>
                    <div class="col-sm-12 col-md-5"></div>
                    <div class="col-sm-12 col-md-2">
                       <!-- <button type="button" class="btn btn-dark btn-sm form-control" id="b_regresar"><i class="fa fa-reply" aria-hidden="true"></i> Regresar</button>-->
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <form id="f_p" name="f_p">

                                    <div class="form-group row">
                                    <div class="col-sm-12 col-md-3"></div>
                                    <div class="col-sm-12 col-md-2">
                                        <label for="i_anio" class="col-sm-2 col-md-6 col-form-label">Año </label>
                                        <div class="col-sm-12 col-md-12">
                                        <select  id="i_anio" name="i_anio" class="form-control validate[required] busca" autocomplete="off"></select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-3">
                                        <label for="i_mes" class="col-sm-2 col-md-6 col-form-label requerido">Mes </label>
                                        <div class="col-sm-12 col-md-12">
                                            <select  id="i_mes" name="i_mes" class="form-control validate[required] busca" autocomplete="off"></select>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="s_id_unidad" class="col-sm-12 col-md-3 col-form-label requerido">Unidad de Negocio</label>
                                        <div class="col-sm-12 col-md-5">
                                        <select id="s_id_unidad" name="s_id_unidad" class="form-control validate[required] busca"  autocomplete="off"></select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="s_id_sucursal" class="col-sm-12 col-md-3 col-form-label requerido">Sucursal</label>
                                        <div class="col-sm-12 col-md-5">
                                        <select id="s_id_sucursal" name="s_id_sucursal" class="form-control validate[required] busca" autocomplete="off"></select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="s_id_area" class="col-sm-12 col-md-3 col-form-label requerido">Area</label>
                                        <div class="col-sm-12 col-md-5">
                                        <select id="s_id_area" name="s_id_area"  class="form-control form-control-sm validate[required] busca" autocomplete="off"></select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="s_id_departamento" class="col-sm-12 col-md-3 col-form-label requerido">Departamento</label>
                                        <div class="col-sm-12 col-md-5">
                                        <select id="s_id_departamento" name="s_id_departamento" disabled class="form-control form-control-sm validate[required] busca" autocomplete="off"></select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_importe" class="col-sm-12 col-md-3 col-form-label">Importe</label>
                                        <div class="col-sm-12 col-md-5">
                                            <input type="text" class="form-control validate[custom[number]]" id="i_importe" name="i_importe" disabled autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_otros_ingresos" class="col-sm-12 col-md-3 col-form-label requerido">Otros Ingresos</label>
                                        <div class="col-sm-12 col-md-5">
                                            <input type="text" class="form-control validate[required,custom[number]] numeroMoneda" id="i_otros_ingresos" name="i_otros_ingresos" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="ta_observaciones" class="col-sm-12 col-md-3 col-form-label requerido">Observaciones</label>
                                        <div class="col-sm-12 col-md-5">
                                        <textarea class="form-control validate[required]" name="ta_observaciones" id="ta_observaciones" rows="2" autocomplete="off"></textarea>
                                        </div>
                                    </div>
                                    
                                </form>
                            </div>
                        </div>
                    </div>  
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-8"></div>
                    <div class="col-sm-12 col-md-2">
                    <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>
                </div>
            <br>
            </div> <!--div_contenedor-->
        </div>      
    </div> <!--div_principal-->
    
</body>


<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
 
    var modulo='OTROS_INGRESOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var matriz = <?php echo $_SESSION['sucursales']?>;
    var idRegistro=0;


    $(function(){

        mostrarBotonAyuda(modulo);
        muestraSelectUnidades(matriz, 's_id_unidad', idUnidadActual);
        muestraSucursalesAcceso('s_id_sucursal', idUnidadActual, idUsuario); 
        muestraAreasAcceso('s_id_area');
        generaFecha();

        $("#i_anio").val(new Date().getFullYear());
        $("#i_mes").val((new Date().getMonth())+1);

        $('#s_id_unidad').change(function()
       {

            var idUnidadNegocio = $('#s_id_unidad').val();
            $('.img-flag').css({'width':'50px','height':'20px'});
            muestraSucursalesAcceso('s_id_sucursal', idUnidadNegocio, idUsuario);
            $('#t_presupuesto >tbody tr').remove();

        });
    

        $('#s_id_unidad').change(function()
       {
            var idUnidadNegocio = $('#s_id_unidad').val();
            $('.img-flag').css({'width':'50px','height':'20px'});
            muestraSucursalesAcceso('s_id_sucursal', idUnidadNegocio, idUsuario);
        });


        $('#s_id_area').change(function(){
            $('#s_id_departamento').prop('disabled',false); 
            muestraDepartamentoArea('s_id_departamento', $('#s_id_sucursal').val(), $('#s_id_area').val());
        });

    
        function generaFecha()
        {

            var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

            $('#i_mes').select2();
            $('#i_mes').html('');
            var html = '<option selected disabled>Selecciona</option>';
            $('#i_mes').append(html);

            var d = new Date();
            var monthC = d.getMonth() + 1;

            for(var i = 0; i < meses.length; i++)
            {
                var actual = meses[i];
                   
                var html = "<option value=" + (i+1) + ">" + actual + "</option>";
                $('#i_mes').append(html);

            }
            //--MGFS SE AGREGA 2 AÑOS ANTES Y UN AÑO DESPUES EN EL COMBO DE AÑO
            var anioC = new Date().getFullYear();

            $('#i_anio').select2();
            $('#i_anio').html('');
            var html = '<option selecte disabled>Selecciona</option>';
            html += "<option value='"+(parseInt(anioC)-2)+"'>" + (parseInt(anioC)-2) + "</option>";
            html += "<option value='"+(parseInt(anioC)-1)+"'>" + (parseInt(anioC)-1) + "</option>";
            html += "<option value='"+anioC+"'>" + anioC + "</option>";
            html += "<option value='"+(parseInt(anioC)+1)+"'>" + (parseInt(anioC)+1) + "</option>";
            $('#i_anio').append(html);

        }

        $('.busca').on('change',function(){
            buscarPresupuestoIngresos();
        });


        function buscarPresupuestoIngresos()
        {
           
            var idUnidad =  $('#s_id_unidad').val();
            var idSucursal = $('#s_id_sucursal').val();
            var idDepartamento =  $('#s_id_departamento').val();
            var idArea = $('#s_id_area').val();
            var anio = $('#i_anio').val();
            var mes = $('#i_mes').val();
            

            var verifica = false;
            if(idUnidad == null)
                verifica = true;

            if(idSucursal == null)
                verifica = true;

            if(anio== null)
                verifica = true;

            if(mes == null)
                verifica = true;
            
            if(idDepartamento == null)
                verifica = true; 
            
            if(idArea == null)
                verifica = true;       

            if(verifica == false)
            {

                $.ajax({

                    type: 'POST',
                    url: 'php/presupuesto_otros_ingresos_buscar.php',
                    dataType:"json", 
                    data:
                    {
                        'id_unidad': $('#s_id_unidad').val(),
                        'id_sucursal': $('#s_id_sucursal').val(),
                        'anio': $('#i_anio').val(),
                        'mes': $('#i_mes').val(),
                        'idDepartamento' : $('#s_id_departamento').val(),
                        'idArea' : $('#s_id_area').val()
                    },
                    success: function(data)
                    {
                        console.log("Resultado: "+JSON.stringify(data));
                        if(data.length >0){

            
                            var presupuesto = data[0];                        
                          
                            idRegistro = presupuesto.id;
                            var importe = parseFloat(presupuesto.importe); 
                            var OI = parseFloat(presupuesto.otros_ingresos);
                            var total = parseFloat(presupuesto.total);

                            $('#b_guardar').prop('disabled',true);
                            $('#ta_observaciones').prop('disabled',true).val(presupuesto.observaciones);
                            $('#i_otros_ingresos').prop('disabled',true).attr('valorAnterior',OI).val(formatearNumero(OI));
                            $('#i_importe').val(formatearNumero(importe));

                            if(presupuesto.editar=='si'){

                                $('#i_otros_ingresos').prop('disabled',false);
                                $('#ta_observaciones').prop('disabled',false);
                                $('#b_guardar').prop('disabled',false);
                            }      


                        }else{
                            mandarMensaje('No se encontró información con los datos ingresados, intenta con otros');
                        }

                    
                    },
                    error: function (xhr) 
                    {
                        console.log('php/presupuesto_ingresos_buscar.php-->'+JSON.stringify(xhr));
                        mandarMensaje('* No se encontro información relacionada a los filtros ingresados');
                    }

                });

            }

        }


    $('#b_guardar').on('click',function(){

        $('#b_guardar').prop('disabled',true);

        if ($('#f_p').validationEngine('validate')){
            
            guardar();
            
        }else{

            mandarMensaje('Debes llenar los filtros requeridos para poder guardar esta información');
            $('#b_guardar').prop('disabled',false);
        }
    });

    function guardar(){

        var total = quitaComa($('#i_otros_ingresos').val())+ quitaComa($('#i_importe').val());

        $.ajax({

            type: 'POST',
            url: 'php/presupuesto_otros_ingresos_guardar.php', 
            data:
            {
                'idRegistro' : idRegistro,
                'id_unidad': $('#s_id_unidad').val(),
                'id_sucursal': $('#s_id_sucursal').val(),
                'idDepartamento': $('#s_id_departamento').val(),
                'idArea': $('#s_id_area').val(),
                'anio': $('#i_anio').val(),
                'mes': $('#i_mes').val(),
                'observaciones':$('#ta_observaciones').val(),
                'otrosIngresos' : quitaComa($('#i_otros_ingresos').val()),
                'total' : total,
                'camposModificados':'Otros Ingresos: '+$('#i_otros_ingresos').attr('valorAnterior')+' <br>',
                'idUsuario':idUsuario,
                'modulo':modulo
            },
            success: function(data)
            {
               
                $('#b_guardar').prop('disabled',false);
                if(data > 0 ){

                    mandarMensaje('El registro se guardó correctamente');

                }else{

                    mandarMensaje('Ocurrio un error al guardar el registro');
                }
            },
            error: function (xhr) 
            {
    
                mandarMensaje('* Ocurrio un error al guardar el registro');
                $('#b_guardar').prop('disabled',false);
            }

        });

    }


               
       

    });//--fin de function

</script>

</html>