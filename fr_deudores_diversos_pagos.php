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
    #vistaPrevia_1{
        border: 1px solid rgb(214, 214, 194); 
        background-color: #fff; 
        max-height: 65px; 
        min-height: 65px;
        width:120px;
    }
    /* Responsive Web Design */
	@media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
    }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="titulo_ban">Pago de Deudores Diversos</div>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md-1"><input id="i_id_sucursal" type="hidden"/></div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <form id="forma" name="forma">
                                    <div class="form-group row">
                                        <label for="i_nombre" class="col-sm-2 col-md-2 col-form-label requerido">Empleado</label>
                                        <div class="input-group col-md-7">
                                            <input type="text" id="i_empleado" name="i_empleado" class="form-control form-control-sm validate[required]" readonly autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_referencia" class="col-sm-2 col-md-2 col-form-label requerido">Referencia</label>
                                        <div class="col-sm-12 col-md-5">
                                            <input type="text" class="form-control validate[required]" id="i_referencia" name="i_referencia" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_importe_d" class="col-sm-2 col-md-2 col-form-label requerido">Importe DD</label>
                                        <div class="col-sm-12 col-md-5">
                                            <input type="text" class="form-control" id="i_importe_d" name="i_importe_d" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_importe_c" class="col-sm-2 col-md-2 col-form-label requerido">Importe Comprobado</label>
                                        <div class="col-sm-12 col-md-5">
                                            <input type="text" class="form-control validate[required,custom[number]]" id="i_importe_c" name="i_importe_c" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_devolucion" class="col-sm-2 col-md-2 col-form-label">Devolución</label>
                                        <div class="col-sm-12 col-md-3">
                                            <input type="text" class="form-control validate[custom[number]]" id="i_devolucion" name="i_devolucion" autocomplete="off">
                                        </div>
                                        <label for="s_cuenta_banco" class="col-sm-2 col-md-2 col-form-label">Cuenta Banco</label>
                                        <div class="col-sm-12 col-md-5">
                                            <select class="form-control" id="s_cuenta_banco" name="s_cuenta_banco"></select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_descuento" class="col-sm-2 col-md-2 col-form-label">Descuento a Nómina</label>
                                        <div class="col-sm-12 col-md-3">
                                            <input type="text" class="form-control validate[custom[number]]" id="i_descuento" name="i_descuento" autocomplete="off">
                                        </div>
                                        <label for="i_quincenas" class="col-sm-2 col-md-2 col-form-label">Quincenas</label>
                                        <div class="col-sm-12 col-md-3">
                                            <input type="text" class="form-control validate[custom[number]]" id="i_quincenas" name="i_quincenas" autocomplete="off">
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
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_aplicar"><i class="fa fa-check" aria-hidden="true"></i> Aplicar</button>
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
<script src="vendor/select2/js/select2.js"></script>

<script>
 
    var modulo='PAGO_DEUDORES_DIVERSOS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;

    var matriz = <?php echo $_SESSION['sucursales']?>;

    $(function(){
        muestraCuentasBancos('s_cuenta_banco', 0);

        /*$('#b_buscar_empleados').click(function(){
            $('#i_filtro_empleado').val('');
            muestraModalDeudoresDiversos('renglon_empleado','t_empleados tbody','dialog_empleados');
        });*/

    });

</script>

</html>