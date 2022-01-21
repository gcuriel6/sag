<?php

$idUnidadNegocio = 1;//$_SESSION['id_unidad_actual'];

if( $_REQUEST['id_unidad_neg'] > 0 ){
    $idUnidadNegocio = $_REQUEST['id_unidad_neg'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PORTAL PROVEEDORES</title>
    <!-- Hojas de estilo -->
    <link href="../css/css/bootstrap.css" rel="stylesheet"  type="text/css" media="all">
    <link href="../css/validationEngine.jquery.css" rel="stylesheet" />
    <link href="../css/bootstrap-datepicker.standalone.min.css" rel="stylesheet"/>
    <link href="../css/general.css" rel="stylesheet"  type="text/css"/>
    <link href="../vendor/font_awesome/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet">
    <link href="../vendor/select2/css/select2.css" rel="stylesheet"/>
</head>

<style> 
   
  body{
    margin:auto;
    background-image: url('../imagenes/fondo_login.jpg');
    background-color:#ffffff;
    background-size:cover;
    background-repeat: no-repeat;
    overflow:hidden;
  }

  #d_marco {
    position:absolute;
    top:0%;
    left:0%;
    width: 100%;
    background-color:rgba(250,250,250,0.3);
    bottom:0%;
    z-index: 0;
    border-radius:5px;
    margin-bottom: -800px;
    padding-bottom: 800px;
    overflow: hidden;
  }
    #div_principal{
        padding-top:100px;
        border-radius:5px;
    }
    #div_contenedor{
        background-color: #ffffff;
    }
   
    #vistaPrevia_1{
        border: 1px solid rgb(214, 214, 194); 
        background-color: #fff; 
        max-height: 55px; 
        min-height: 55px;
        width:100px;
    }

    
</style>

<body>
<div id="d_marco"> </div>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-offset-1 col-md-8" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="titulo_ban" id="d_titulo">Proveedor</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-9"></div>
                
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-info btn-sm form-control" id="b_regresar_portal"><i class="fa fa-arrow-circle-o-left " aria-hidden="true"></i> Regresar</button>
                    </div>
                </div>
                <br><br>

                <div class="row">
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-12 col-md-10">
                        <form id="forma" name="forma">
                           
                            <div class="input-group col-sm-12 col-md-10">
                                <input type="text" id="i_proveedor" name="i_proveedor" class="form-control validate[required]" readonly autocomplete="off">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary" type="button" id="b_buscar_proveedor_portal" style="margin:0px;">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </div>
                                <div class="input-group-btn">
                                    <button class="btn btn-info" type="button" id="b_detalle_proveedor_portal" style="margin:0px;">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12 col-md-5"></div>
                            
                                <div class="col-sm-12 col-md-2">
                                    <button type="button" class="btn btn-dark btn-block form-control" id="b_login"><i class="fa fa-key " aria-hidden="true"></i> Entrar</button>
                                </div>
                            </div>


                        </form>
                    </div>

                </div>
                <br>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->

    <div id="dialog_proveedores" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Proveedores</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            
                <div class="row">
                    <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_proveedor" id="i_filtro_proveedor" alt="renglon_proveedor" class="filtrar_renglones form-control filtrar_renglones" alt="renglon_razon_social_emisora" placeholder="Filtrar" autocomplete="off"></div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_proveedores">
                        <thead>
                            <tr class="renglon">
                            <th scope="col">Proveedor</th>
                            <th scope="col">RFC</th>
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
<div id="dialog_proveedores_datos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Datos Proveedor: <span id="nombre_proveedor"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div id="div_datos_proveedor"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="b_cerrar_modal_d_p_portal" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
    
</body>

<script src="../js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/js/bootstrap.js"></script>
<script src="../js/jquery.validationEngine.js"></script>
<script src="../js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="../vendor/select2/js/select2.js"></script>

<script>
  var idProveedor=0;
  var idUnidadNegocio =<?php echo $idUnidadNegocio?>;
    $(function(){

        console.log('negocio ' + idUnidadNegocio);

        $('#b_buscar_proveedor_portal').click(function(){
            $('#i_proveedor').validationEngine('hide');
            $('#i_filtro_proveedor').val('');
            if(idUnidadNegocio>0){
                muestraModalProveedoresUnidades('renglon_proveedor','t_proveedores tbody','dialog_proveedores',idUnidadNegocio);
            }else{
                mandarMensaje('Ocurrio un error al ingresar al portal por favor intentalo de nuevo');
            }
        });

        $('#t_proveedores').on('click', '.renglon_proveedor', function() {
            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            var rfc = $(this).attr('alt3');
            $('#i_proveedor').attr('alt',id).attr('alt2',rfc).val(nombre);
            $('#dialog_proveedores').modal('hide');
        });

        $('#b_detalle_proveedor_portal').click(function(){
            if($('#i_proveedor').val() != '')
            {
                var idProveedor = $('#i_proveedor').attr('alt');
              
                $.ajax({
                    type: 'POST',
                    url: 'php/proveedores_buscar_id.php',
                    dataType:"json", 
                    data:{
                        'idProveedor':idProveedor
                    },
                    success: function(data) {
                       
                        if(data.length > 0){
                            if(data[0].num_int != '')
                            {
                                var num_int=' Int.'+data[0].num_int;
                            }else{
                                var num_int='';
                            }

                            $('#nombre_proveedor').text(data[0].nombre);

                            var detalles = '<p>Nombre: '+data[0].nombre+'</p>';
                                detalles += '<p>RFC: '+data[0].rfc+'</p>';
                                detalles += '<p>Domicilio: '+data[0].domicilio+' '+data[0].num_ext+' '+num_int+'. '+data[0].colonia+', '+data[0].municipio+', '+data[0].estado+', '+data[0].pais+'</p>';
                                detalles += '<p>Código Postal: '+data[0].cp+'</p>';
                                detalles += '<p>Telefono: '+data[0].telefono+'</p>';
                                detalles += '<p>Dias Credito: '+data[0].dias_credito+'</p>';
                                detalles += '<p>Web: '+data[0].web+'</p>';
                                detalles += '<p>Contacto: '+data[0].contacto+'</p>';
                                detalles += '<p>Condiciones: '+data[0].condiciones+'</p>';

                            $('#div_datos_proveedor').html(detalles);

                        }

                        $('#dialog_proveedores_datos').modal('show');
                        
                    },
                    error: function (xhr) 
                    {
                        console.log('php/proveedores_buscar_id.php --> '+JSON.stringify(xhr));
                        mandarMensaje('Error en el sistema');
                    }
                });
            }else{
                mandarMensaje('Primero debes selecionar un proveedor');
            }
        });

        $('#b_login').click(function(){
            if($('#i_proveedor').val() != ''){
               
                $.post("php/login_ginthercorp.php",{ idUsuario: $('#i_proveedor').attr('alt')},function(data){
                    if(data == '1'){
                        window.open('index.php','_top');
                    }
                    else{
                        mandarMensaje(data);
                    }
                });
               
            }else{
                mandarMensaje('Ingresa un usuario');
            }
        });

       
        $('#b_regresar_portal').on('click',function(){
             window.open("../","_blank");
       });
       

    });

</script>

</html>