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

    .Vencida td{
        color:orange;
    }
    .Cancelada td{
        color:red;
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
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Reportes Facturas Pagadas</div>
                    </div>
 
                    <div class="col-sm-12 col-md-6">
                        <input type="text" name="i_filtro" id="i_filtro" alt="renglon_saldo" class="form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off" />  
                    </div>
                  
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-info btn-sm form-control"  id="b_pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Facturas Saldadas</button>
                    </div>
                </div>

                <div class="row"><div class="col-md-12"><input id="i_id_sucursal" type="hidden"/></div></div>
                <br>

                <div class="row" id="div_resgitros">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col">Factura</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Proveedor</th>
                                    <th scope="col">Banco</th>
                                    <th scope="col">Cuenta</th>
                                    <th scope="col">Cargo</th>
                                    <th scope="col">Abono</th>
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
  
    var modulo='REPORTE_CXP_FACTURAS_SALDADAS';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var nombreReporte='';

    var matriz = <?php echo $_SESSION['sucursales']?>;
    $(function(){
        mostrarBotonAyuda(modulo);
        //muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);

        $('#i_fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true,
        });

        $('#i_fecha').val(hoy);

       

        buscaFacturasSaldadas();

        function buscaFacturasSaldadas(){
            $('#t_registros .renglon').remove();

            $.ajax({
                type: 'POST',
                url: 'php/cxp_reporte_facturas_saldadas.php',
                dataType:"json", 
                data:{

                },
                success: function(data) {
                    if(data.length != 0){
                
                        for(var i=0;data.length>i;i++){
                            ///llena la tabla con renglones de registros
                            var esPar='';
                            if(i%2==0){
                                esPar='par';
                            }
                            var html='<tr class="renglon renglon_saldo '+esPar+'" alt="'+data[i].id_cxp+'">\
                                        <td data-label="Factura">'+data[i].no_factura+'</td>\
                                        <td data-label="Fecha">'+data[i].fecha+'</td>\
                                        <td data-label="Proveedor">'+data[i].proveedor+'</td>\
                                        <td data-label="Banco">'+data[i].banco+'</td>\
                                        <td data-label="Cuenta">'+data[i].cuenta+'</td>\
                                        <td data-label="Cargo">'+formatearNumero(data[i].cargo)+'</td>\
                                        <td data-label="Abono">'+formatearNumero(data[i].abono)+'</td>\
                                     </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_registros tbody').append(html); 

                        }
                    }else{
                        var html='<tr class="renglon">\
                                        <td colspan="3">No se encontró información</td>\
                                    </tr>';

                        $('#t_registros tbody').append(html);
                    }

                },
                error: function (xhr) 
                {
                    console.log('php/cxp_reporte_saldos_proveedores.php --> '+JSON.stringify(xhr));
                    mandarMensaje('* No se encontró información de saldos');
                }
            });
        }

      

        $('#b_pdf').click(function(){
            var datos = {
                    'path':'formato_cxp_facturas_saldadas',
                    'nombreArchivo':'cxp_facturas_saldadas',
                    'tipo':1
                };
            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_new')
        });
        
    });

</script>

</html>