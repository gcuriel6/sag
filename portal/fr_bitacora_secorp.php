<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GINTHERCORP</title>
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
        background-color:rgb(238,238,238);
    }
    #div_principal{
        padding-top:20px;
    }
    #div_contenedor{
        background-color: #ffffff;
    }
    #div_t_montos_nomina{
        height:170px;
        overflow:auto;
    }
    #td_descripcion{
        width:30%;
    }
    #td_clave{
        width:10%;
    }

    .izquierda { 
        text-align: right; 
    }

    .tr_totales th{
        border:none;
        background:rgba(231,243,245,0.6);
        font-weight:bold;
        font-size:11px;
        text-align:right;
    }
    .tr_totales th input{
        font-weight:bold;
        font-size:11px;
        text-align:right;
        margin-right:10px;
        padding-right:10px;
    }

    #d_estatus{
       padding-top:7px;
       text-align:center;
       font-weight:bold;
       font-size:15px;
       height:40px;
       vertical-align:middle;
   }

   #dialog_buscar_requisiciones > .modal-lg{
        min-width: 80%;
        max-width: 80%;
    } 

    /* Responsive Web Design */
    @media only screen and (max-width:768px){
        .tablon{
            margin-top:10px;
        }
        #div_t_montos_nomina{
            height:auto;
            overflow:auto;
        }
        #td_descripcion{
            width:100%;
        }
        #td_clave{
            width:100%;
        }
        #dialog_buscar_requisiciones > .modal-lg{
            max-width: 100%;
        }
    }
    
</style>

<body>
    <div class="container" id="div_principal">

        <div class="card">
            <div class="card-header">
                <h2>Actualizar Bitacora</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Unidad</label>
                            <select class="form-control" id="s_id_unidad"></select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Sucursal</label>
                            <select class="form-control" id="s_id_sucursal"></select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Servicio</label>
                            <select class="form-control" id="s_id_depto"></select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Area</label>
                            <select class="form-control" id="s_id_area"></select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!--div_principal-->
    
</body>

<div id="dialog_buscar_productos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Productos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
            <div class="row">
                <div class="input-group col-sm-12 col-md-4">
                    <input type="text" id="i_familia_filtro" name="i_familia_filtro" class="form-control" placeholder="Filtrar Por Familia" readonly autocomplete="off">
                    <div class="input-group-btn">
                        <button class="btn btn-primary" type="button" id="b_buscar_familia_filtro" style="margin:0px;">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </div> 
                <div class="input-group col-sm-12 col-md-4">
                    <input type="text" id="i_linea_filtro" name="i_linea_filtro" class="form-control" placeholder="Filtrar Por Línea" readonly autocomplete="off">
                    <div class="input-group-btn">
                        <button class="btn btn-primary" type="button" id="b_buscar_lineas_filtro" style="margin:0px;">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>  
                <div class="col-sm-12 col-md-4"><input type="text" name="i_filtro_producto" id="i_filtro_producto" class="form-control filtrar_renglones" alt="producto-partida" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_productos">
                      <thead>
                        <tr class="renglon">
                          
                          <th scope="col">Familia</th>
                          <th scope="col">Linea</th>
                          <th scope="col">Concepto</th>
                          <th scope="col">Precio</th>

                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>  
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<script src="../js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/js/bootstrap.js"></script>
<script src="../js/jquery.validationEngine.js"></script>
<script src="../js/jquery.validationEngine-es.js"></script>
<script src="../js/general.js"></script>
<script src="../vendor/select2/js/select2.js"></script>
<script src="../js/bootstrap-datepicker.min.js"></script>

<script>

    var idUnidadActual = <?php echo $_SESSION['id_unidad_actual']; ?>;
    var idUsuario = <?php echo $_SESSION['id_usuario']; ?>;
    var modulo = 'RASTREO_PRODUCTOS';
    var matriz = <?php echo $_SESSION['sucursales']; ?>;
    $(function(){
        muestraSelectUnidades(matriz, 's_id_unidad', idUnidadActual);
        muestraSucursalesPermiso('s_id_sucursal', idUnidadActual, modulo,idUsuario);
    });

</script>

</html> 