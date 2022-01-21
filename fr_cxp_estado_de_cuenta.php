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
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Estado de Cuenta</div>
                    </div>
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-12 col-md-1">
                        <label class="col-form-label">Proveedor</label>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <input type="text" id="i_proveedor" name="i_proveedor" class="form-control form-control-sm " disabled>
                    </div>
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_regresar"><i class="fa fa-reply" aria-hidden="true"></i> CxP</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-12 col-md-5">
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-1">Del: </div>
                            <div class="input-group col-sm-12 col-md-5">
                                <input type="text" name="i_fecha_inicio" id="i_fecha_inicio" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                                <div class="input-group-addon input_group_span">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-1">Al: </div>
                            <div class="input-group col-sm-12 col-md-5">
                                <input type="text" name="i_fecha_fin" id="i_fecha_fin" class="form-control form-control-sm fecha" autocomplete="off" readonly>
                                <div class="input-group-addon input_group_span">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> EXCEL</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-info btn-sm form-control" id="b_pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</button>
                    </div>
                </div>

                <div class="row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>
                
                <div class="form-group row" id="div_resgitros">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Concepto</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Cargos</th>
                                    <th scope="col">Abonos</th>
                                    <th scope="col">Saldo</th>
                                    <th scope="col">Referencia</th>
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

                <div class="row">
                    <div class="col-sm-12 col-md-8"></div>
                    <div class="col-sm-12 col-md-4">
                        <div class="row">
                            <label for="i_saldo" class="col-sm-12 col-md-2 col-form-label">Saldo </label>
                            <div class="col-md-5">
                                <input type="text" id="i_saldo" name="i_saldo" class="form-control form-control-sm" autocomplete="off" readonly>
                            </div>
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
  
    var modulo='ESTADO_DE_CUENTA_CXP';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var idProveedor=<?php echo $_REQUEST['idProveedor']?>;
    var proveedor='<?php echo $_REQUEST['proveedor']?>';

    var matriz = <?php echo $_SESSION['sucursales']?>;
    $(function(){
        mostrarBotonAyuda(modulo);

        fechaHoyServidor('i_fecha_inicio','primerDiaMes');
        fechaHoyServidor('i_fecha_fin','ultimoDiaMes');
        
        $('#i_proveedor').val(proveedor);
       
        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true,
        });

        $('#i_fecha_inicio,#i_fecha_fin').change(function(){
            muestraEstadoDeCuenta();
        });

        muestraEstadoDeCuenta();

        function muestraEstadoDeCuenta(){
            var totalCargos=0;
            var totalAbonos=0;
            $('#t_registros .renglon').remove();

            var datos = {
                'fechaInicio':$('#i_fecha_inicio').val(),
                'fechaFin':$('#i_fecha_fin').val(),
                'idProveedor':idProveedor
            };

            $.ajax({
                type: 'POST',
                url: 'php/cxp_estado_de_cuenta_IdProveedor.php',
                dataType:"json", 
                data:{'datos':datos},
                success: function(data) {
                    if(data.length != 0){
                        var saldo=0;
                        for(var i=0;data.length>i;i++){
                            saldo = saldo+parseFloat(data[i].cargos)-parseFloat(data[i].abonos);
                            ///llena la tabla con renglones de registros
                            var html='<tr class="renglon">\
                                        <td data-label="Concepto">'+data[i].concepto+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Descripción">'+data[i].descripcion+'</td>\
                                        <td data-label="Cargos">$'+formatearNumero(data[i].cargos)+'</td>\
                                        <td data-label="Abonos">$'+formatearNumero(data[i].abonos)+'</td>\
                                        <td data-label="Saldo">$'+formatearNumero(saldo)+'</td>\
                                        <td data-label="Referencia">'+data[i].referencia+'</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros tbody').append(html); 

                            totalCargos=totalCargos+parseFloat(data[i].cargos);
                            totalAbonos=totalAbonos+parseFloat(data[i].abonos);

                        }
                        
                        var saldo=parseFloat(totalCargos)-parseFloat(totalAbonos);
                        $('#i_saldo').val(formatearNumero(saldo));
                    }else{
                        var html='<tr class="renglon">\
                                        <td colspan="7">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros tbody').append(html);
                        $('#i_saldo').val('');
                    }

                },
                error: function (xhr) 
                {
                    console.log('php/cxp_estado_de_cuenta_IdProveedor.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información del estado de cuenta');
                }
            });
        }

        $('#b_regresar').click(function(){
            window.open('fr_cxp.php','_self');
        });

        $('#b_excel').click(function(){
            
            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();

            var datos = {
                'fechaInicio':$('#i_fecha_inicio').val(),
                'fechaFin':$('#i_fecha_fin').val(),
                'idProveedor':idProveedor
            };
            
            $("#i_nombre_excel").val('Estado de Cuenta Proveedor: '+idProveedor);
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val('ESTADO_DE_CUENTA_CXP');
            $('#i_datos_excel').val(JSON.stringify(datos));
            
            $("#f_imprimir_excel").submit();
        });

        $('#b_pdf').click(function(){
            var datos = {
                    'path':'formato_estado_cuenta_proveedor',
                    'idRegistro':idProveedor,
                    'fechaInicio':$('#i_fecha_inicio').val(),
                    'fechaFin':$('#i_fecha_fin').val(),
                    'nombreArchivo':'cxp_estado_cuenta_proveedor_'+idProveedor,
                    'tipo':1
                };
                let objJsonStr = JSON.stringify(datos);
                let datosJ = datosUrl(objJsonStr);

                window.open("php/convierte_pdf.php?D="+datosJ,'_new');
        });
        
    });

</script>

</html>