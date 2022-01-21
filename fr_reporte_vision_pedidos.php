<?php


  session_start();

  $usuario = 0;
  $idUsuario = '';

  if (isset($_SESSION['usuario']))
   {  

     $usuario = $_SESSION['usuario'];
     $idUsuario = $_SESSION['id_usuario'];

  }else
      include('php/logout.php');
    
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
        /*background-image: url('imagenes/almacen2.jpg');*/
        background-size:cover;
       
    }
    #div_principal,
    #div_produccion,
    #div_seguimiento_pedidos{
      position: absolute;
      top:0px;
      left:0px;
      height: 100%;
      background-color: rgba(250,250,250,0.6);
      
    }

     .boton_eliminar{
        width:50px;
    }

   
    #div_contenedor{
        background-color: rgba(250,250,250,0.8);
        height: 100%;
    }
    /*button{
        cursor: pointer;
    }*/
    .tablon {
      border: 1px solid #ccc;
      border-collapse: collapse;
      margin: 0;
      padding: 0;
      width: 100%;
      font-size: 11px;
      table-layout: fixed;
    }
    .tablon tr {
      background: #f8f8f8;
      border: 1px solid #ddd;
      padding: .15em;
    }
    .tablon th,
    .tablon td {
      padding: .225em;
      text-align: center;
    }
    .tablon th {
      font-size: .86em;
      letter-spacing: .1em;
      text-transform: uppercase;
    }

    @media screen and (max-width: 700px) {
        #b_nuevo,#b_buscar,#b_guardar,#b_excel{
            margin-bottom:10px;
        }
    }

    @media screen and (max-width: 600px) {
        .tablon {
            border: 0;
        }
        .tablon caption {
            font-size: 1.3em;
        }
        .tablon thead {
            border: none;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }
        .tablon tr {
            border-bottom: 3px solid #ddd;
            display: block;
            margin-bottom: .625em;
        }
        .tablon  td {
            border-bottom: 1px solid #ddd;
            display: block;
            font-size: .8em;
            text-align: right;
        }
        .tablon  td:before {
            content: attr(data-label);
            float: left;
            font-weight: bold;
            text-transform: uppercase;
        }
        .tablon  td:last-child {
            border-bottom: 0;
        }

    }

    .p_comodato{
      color:#17A2B8;
    }

    .form-control[readonly]{
      background-color:#FAFAFA;
      opacity: 9;
    }



    
    
    .permiso[readonly]{
      background-color:#DFECFC;
      opacity: 9;
    }
    .permiso:disabled{
      background-color: #e9ecef;
      opacity: 1;
    }
    .permiso{
      background-color:#DFECFC;
    }
    textarea{
      resize: none;
    }

    .verde td{
      color:green;
    }
    .azul td{
      color:#17A2B8;
    }
    .rojo td{
      color:#DC3545;
      }
    }

    #info_existencias:hover{
      color:blue;
    }
    .falta{
      border:1px solid #DC3545;
    }

 .falta input[type="checkbox"]{
  background-color: #DC3545;
  border-color: #DC3545; }

  #dialog_cliente >  .modal-lg{
   
            min-width: 1000px;
            max-width: 1000px;
 }

 .div_imagenes{
    position: relative;
		border: 1px solid #e6e6e6; 
		max-width:570px;
		min-width:570px; 
		max-height:190px;
		min-height:190px;
		overflow-x: auto;
		overflow-y: hidden; 
		padding: 2px;
		border-radius: 5px;
	}
	.div_imagenes table tr td{
		padding-left: 5px;
		padding-right: 5px;
	}

  .eliminar_imagen,
  .eliminar_imagen_guardada{
    cursor:pointer;
    color:#fafafa;
    background:#DC3545;
    border-radius:3px;
    padding:3px;
  }
    
</style>

<body>
    <div class="container-fluid" id="div_principal">
        <div class="row">
            <div class="col-md-1 col-lg-1"></div>
            <div class="col-md-10 col-lg-10" id="div_contenedor">
            <br>
          
                <div class="row">
                    <div class="col-sm-12 col-md-5 col-lg-4">
                         <span style="color:#000099; font-size: 25px;">Reporte Salidas Almacén/Pedidos</span>
                    </div>
                    <!--<div class="col-sm-12 col-md-3 col-lg-2">
                        <button type="button" class="btn btn-success btn-block" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>-->
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-5 col-lg-8"></div>
                    <div class="col-sm-12 col-md-3 col-lg-4">
                        <button type="button" class="btn btn-success btn-block" id="b_excel"><i class="fa fa-floppy-o" aria-hidden="true"></i> Excel</button>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-sm-12 col-md-5 col-lg-8">
                      <input type="text" name="i_filtro_pedido" id="i_filtro_pedido" alt="renglon_pedido" class="filtrar_renglones form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off">
                    </div>
                    <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
                            <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
                            <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
                            <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
                        </form>
                    <div class="col-sm-12 col-md-3 col-lg-4"></div>
                </div>

                <br>
                <div class="row">
                  <div class="col-sm-12 col-md-5 col-lg-12">
                      <table class="tablon" id="t_pedidos">
                        <thead>
                          <tr class="renglon">
                            <th scope="col">Folio Pedido</th>
                            <th scope="col">Folio Almacen</th>
                            <th scope="col">Concepto</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Razon Social</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col">IVA</th>
                            <th scope="col">Total</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                  </div>
                  
                </div>
                <br>
                <!--<form id="form_pedido" name="form_pedido">   
                </form>-->
    
        </div><!-- fin row-->

    </div><!--  fin div principal-->

    
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

  var modulo = 'REPORTE_PEDIDOS_ALMACEN';
  var idUnidadActual = 3;// php echo $_SESSION['id_unidad_actual']
  var idSucursalVision = 24;
  var idUsuario = <?php echo $_SESSION['id_usuario']?>;
  var usuario = '<?php echo $_SESSION['usuario']?>';
  var matriz = <?php echo $_SESSION['sucursales']?>;

  $(function()
  {

    //
    function buscarPedidos()
    {

      $('#i_filtro_pedido').val('');
      $('.renglon_pedido').remove();
      $('#t_pedidos tbody').html('');

      $.ajax({
        type: 'POST',
        url: 'php/reportes_vision.php',
        dataType:"json", 
        data : {'reporte': 'pedidos_almacen'},
        success: function(data) 
        {

          if(data.length != 0)
          {             

            for(var i=0;data.length>i;i++)
            {

              var html = '<tr class="renglon_pedido" alt="' + data[i].id_pedido + '">';
              html += '<td data-label="Folio Pedido">' + data[i].id_pedido + '</td>';
              html += '<td data-label="Folio Almacen">' + data[i].folio_almacen + '</td>';
              html += '<td data-label="Concepto">' + data[i].clave_concepto + ' - ' + data[i].clave_concepto  + '</td>';
              html += '<td data-label="Cliente">' + data[i].cliente + '</td>';
              html += '<td data-label="Razon Social">' + data[i].razon_social + '</td>';
              html += '<td data-label="Fecha">' + data[i].fecha + '</td>';
              html += '<td data-label="Subtotal">' + data[i].subtotal + '</td>';
              html += '<td data-label="IVA">' + data[i].iva + '</td>';
              html += '<td data-label="Total">' + data[i].total + '</td>';
              html += '</tr>';

              $('#t_pedidos tbody').append(html)

            }

          }
          else
          {
            var html='<tr class="renglon_fact">\
              <td colspan="10">No se encontró información</td>\
              </tr>';
            $('#t_pedidos tbody').append(html);
          }
        },
        error: function (xhr)
        {
          console.log('php/facturacion_buscar.php --> '+JSON.stringify(xhr));
          mandarMensaje('Se genero un error al realizar la busqueda.');
        }

      });

    }

    buscarPedidos();

    $('#b_excel').click(function()
    {

      var html = '';
      var aux = new Date();
      var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();
            
      $('#i_nombre_excel').val('Almacén/Pedidos');
      $('#i_fecha_excel').val(hoy);
      $('#i_modulo_excel').val('REPORTE_PEDIDOS_ALMACEN');
            
      $("#f_imprimir_excel").submit();
    
    });

  }); 

</script>

</html>
