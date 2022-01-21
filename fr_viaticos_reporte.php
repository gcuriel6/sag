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
        margin-left:4%;
    }
    #div_contenedor{
        background-color: #ffffff;
    }
    #div_t_registros{
        max-height:400px;
        overflow:auto;
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

    /* Responsive Web Design */
    @media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_t_registros{
            height:auto;
            overflow:auto;
        }
        #div_principal{
            margin-left:0%;
        }
    }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-11" id="div_contenedor">
            <br>
                <div class="form-group row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Reportes Viaticos</div>
                    </div>
                    <div class="col-sm-12 col-md-4"></div>
                    <div class="col-sm-12 col-md-2">
                      
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel" disabled><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-12 col-md-auto"><label for="s_id_unidades" class="col-form-label">Unidad de Negocio </label></div>
                    <div class="col-sm-12 col-md-3"><select id="s_id_unidades" name="s_id_unidades" class="form-control form-control-sm validate[required]" autocomplete="off" style="width:100%;"></select></div>
                
                    <div class="col-sm-12 col-md-5">
                        <div class="row">
                            <div class="col-sm-12 col-md-auto">Del: </div>
                            <div class="input-group col-sm-12 col-md-4">
                                <input type="text" name="i_fecha_inicio" id="i_fecha_inicio" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                                <div class="input-group-addon input_group_span">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-auto">Al: </div>
                            <div class="input-group col-sm-12 col-md-4">
                                <input type="text" name="i_fecha_fin" id="i_fecha_fin" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                                <div class="input-group-addon input_group_span">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="col-sm-12 col-md-2"> 
                        Todas las Unidades
                        <input type="checkbox" name="ch_todas" id="ch_todas" >
                        <input type="hidden" id="i_todas" name="i_todas">
                    </div>   
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <input type="text" name="i_filtro" id="i_filtro" alt="renglon_registros" class="form-control form-control-sm filtrar_renglones" placeholder="Filtrar" autocomplete="off">  
                    </div>
                </div>

                <div class="row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>
                <br>

                <div class="row" id="div_resgitros">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Unidad de Negocio</th>
                                    <th scope="col">Sucursal</th>
                                    <th scope="col">Fecha <br> Captura</th>
                                    <th scope="col">Folio</th>
                                    <th scope="col">Empleado</th>
                                    <th scope="col">Destino</th>
                                    <th scope="col">Fecha<br>Inicio</th>
                                    <th scope="col">Fecha<br>Fin</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Estatus</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Estatus Finanzas</th>
                                    <th scope="col">Usuario</th>
                                </tr>
                            </thead>
                        </table>
                        <div id="div_t_registros">
                            <table class="tablon"  id="t_registros">
                                <tbody>
                                    
                                </tbody>
                            </table>  
                        </div>  
                    </div>
                </div>

                <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
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

<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
  
    var modulo='REPORTE_VIATICOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;

    var cadenaSuc = '';

    var matriz = <?php echo $_SESSION['sucursales']?>;
    $(function(){

muestraSucursalesTodas();




        //console.log(JSON.stringify(matriz));

        mostrarBotonAyuda(modulo);
        muestraSelectUnidadesAcceso('s_id_unidades',idUnidadActual,idUsuario);
        $('#b_excel').prop('disabled',true);
        $('#i_fecha_inicio').val(primerDiaMes);
        $('#i_fecha_fin').val(ultimoDiaMes);
        
        mostrarReporte(primerDiaMes,ultimoDiaMes,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));

        $('#s_id_unidades').change(function(){
            
            mostrarReporte($('#i_fecha_inicio').val(),$('#i_fecha_fin').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario));
            $('#b_excel').prop('disabled',false);
           
        });

        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true,
        });

       

        $('#i_fecha_inicio').change(function(){
           
            if($('#i_fecha_inicio').val() == '')
            {

                $('#i_fecha_inicio').val(primerDiaMes);

                if($('#ch_todas').prop("checked") == true)
                    mostrarReporte(primerDiaMes,$('#i_fecha_fin').val(), cadenaSuc);
                else
                    mostrarReporte(primerDiaMes,$('#i_fecha_fin').val(),    muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario));
                
                

            }
            else
            {

                if($('#ch_todas').prop("checked") == true)
                    mostrarReporte($('#i_fecha_inicio').val(),$('#i_fecha_fin').val(), cadenaSuc);
                else
                    mostrarReporte($('#i_fecha_inicio').val(),$('#i_fecha_fin').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario));
            }
           
        });

        $('#i_fecha_fin').change(function(){
           
            if($('#i_fecha_fin').val() == '')
            {
                $('#i_fecha_fin').val(ultimoDiaMes);

                if($('#ch_todas').prop("checked") == true)
                    mostrarReporte($('#i_fecha_inicio').val(),$('#i_fecha_fin').val(), cadenaSuc);
                else
                    mostrarReporte($('#i_fecha_inicio').val(),$('#i_fecha_fin').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario));
        
            }else{
                
                if($('#ch_todas').prop("checked") == true)
                    mostrarReporte($('#i_fecha_inicio').val(),$('#i_fecha_fin').val(), cadenaSuc);
                else
                    mostrarReporte($('#i_fecha_inicio').val(),$('#i_fecha_fin').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario)); 
                //mostrarReporte($('#i_fecha_inicio').val(),$('#i_fecha_fin').val(),muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario));
        
            }
            
        });



        function mostrarReporte(fechaInicio,FechaFin,idsSucursales){
             
            $('.renglon_registros').remove();

            var datos = {
                'idsSucursal':idsSucursales,
                'fechaInicio':fechaInicio,
                'fechaFin':FechaFin
            };
            //console.log("unidades//      "+JSON.stringify(datos));
           
            $.ajax({
                type: 'POST',
                url: 'php/viaticos_buscar_reporte.php',
                dataType:"json", 
                data:  {'datos':datos},
                success: function(data) {
                    if(data.length != 0){
                        
                        var num=data.length;
                        for(var i=0;data.length>i;i++){

                          
                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon_registros">\
                                        <td data-label="Unidad de Negocio">'+data[i].unidad+'</td>\
                                        <td data-label="Sucursal">'+data[i].sucursal+'</td>\
                                        <td data-label="Fecha Captura">'+data[i].fecha_captura+'</td>\
                                        <td data-label="Folio">'+data[i].folio+'</td>\
                                        <td data-label="Empleado">'+data[i].empleado+'</td>\
                                        <td data-label="Desctino">'+data[i].destino+'</td>\
                                        <td data-label="Fecha Inicio">'+data[i].fecha_inicio+'</td>\
                                        <td data-label="Fecha Fin">'+data[i].fecha_fin+'</td>\
                                        <td data-label="Total">'+formatearNumero(data[i].total)+'</td>\
                                        <td data-label="Estatus">'+data[i].estatus+'</td>\
                                        <td data-label="Tipo">'+data[i].tipo+'</td>\
                                        <td data-label="Estatus Finanzas">'+data[i].estatus_finanzas+'</td>\
                                        <td data-label="Usuario Captura">'+data[i].usuario_captura+'</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros tbody').append(html);  
                            $('#b_excel').prop('disabled',false); 
                            
                        }

                    }else{
                        var html='<tr class="renglon_registros">\
                                        <td colspan="12">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros tbody').append(html);
                        $('#b_excel').prop('disabled',true);

                    }
                },
                error: function (xhr) 
                {
                    console.log('php/viaticos_buscar_reporte.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información al buscar reporte de viaticos');
                }
            });
        }

        

        $('#b_excel').click(function(){
            var fechaInicio = primerDiaMes;
            var fechaFin = ultimoDiaMes;
            if($('#i_fecha_inicio').val() != '')
            {
                fechaInicio = $('#i_fecha_inicio').val();
            }

            if($('#i_fecha_fin').val() != '')
            {
                fechaFin = $('#i_fecha_fin').val();
            }

            if($('#s_id_unidades').val() > 0 || $('#s_id_unidades').val() != null)
                var idsSucursales = muestraSucursalesPermisoListaId($('#s_id_unidades').val(),modulo,idUsuario)
            else
                var idsSucursales = muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario)
            
            var datos = {
                'idsSucursal':idsSucursales,
                'fechaInicio':fechaInicio,
                'fechaFin':fechaFin,
            };

            if($('#ch_todas').prop("checked") == true)
            {

                datos = {
                    'idsSucursal':cadenaSuc,
                    'fechaInicio':fechaInicio,
                    'fechaFin':fechaFin,
                };
            }
            //console.log(JSON.stringify(datos));
            
            $("#i_nombre_excel").val('Reportes Viaticos');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(datos));
            
            $("#f_imprimir_excel").submit();
        });


        $('#ch_todas').change(function()
        {

            if($('#ch_todas').prop("checked") == true)
            {
                $('#s_id_unidades').prop('disabled', true);
                mostrarReporte(primerDiaMes,ultimoDiaMes, cadenaSuc);
            }
            else
            {
                $('#s_id_unidades').prop('disabled', false);
                muestraSelectUnidadesAcceso('s_id_unidades',idUnidadActual,idUsuario);
                mostrarReporte(primerDiaMes,ultimoDiaMes,muestraSucursalesPermisoListaId(idUnidadActual,modulo,idUsuario));
            }

        });

        function muestraSucursalesTodas()//modulo,idUsuario verificando
        {


            
            for(var i=0; i<matriz.length; i++)
            {

                //console.log('**** '  +JSON.stringify(matriz[i]));
                var idUN =  matriz[i].id_unidad;
                
                $.ajax({

                    type: 'POST',
                    url: 'php/combos_buscar.php',
                    dataType:"json", 
                    async: false,
                    data:{

                        'tipoSelect' : 'PERMISOS_SUCURSALES',//_LISTA_ID
                        'idUnidadNegocio' : idUN,
                        'modulo' : modulo,
                        'idUsuario' : idUsuario

                    },
                    success: function(data) 
                    {

                        //console.log(JSON.stringify(data));

                        if(data!=0)
                        {

                            var arreglo=data;
                            var cS = '';
                            for(var i=0;i<arreglo.length;i++)
                            {

                                var dato = arreglo[i];
                                cS +=   ',' + dato.id_sucursal;

                            }

                            $("#i_todas").val(cS);

                        }

                    },
                    error: function (xhr) 
                    {
                        //alert('rr');
                    }

             });

             cadenaSuc += $("#i_todas").val();


                

            }

            //alert('* ' + cadenaSuc);

        }
        
    });

</script>

</html>