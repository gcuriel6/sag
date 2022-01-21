<?php

  session_start();

  $usuario = 0;
  $idUsuario = '';

  if (isset($_SESSION['usuario'])){  

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
    <!-- <link href="vendor/font_awesome/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="vendor/select2/css/select2.css" rel="stylesheet"/>
    <link href="css/general.css" rel="stylesheet"  type="text/css"/>
</head>

<style>
    #fondo_cargando{
      position: absolute;
      top: 1%;
      background-image:url('imagenes/3.svg');
      background-repeat:no-repeat;
      background-size: 500px 500px; 
      background-position:center;
      left: 1%;
      width: 98%;
      bottom:3%;
      border-radius: 5px;
      z-index:2000;
      display:none;
    }
</style>


<body>

<div class="container">
  <div class="row mt-3">
    <div class="col-12">
      <div class="card">
        <div class="card-header bg-secondary text-white">
          <h3>Cotizaciones Aprobadas</h3>
        </div>
        <div class="card-body">
          <table class="table table-striped table-bordered" id="tableCotizacionesAprobadas">
            <thead>
              <tr>
                <th scope="col">Cliente</th>
                <th scope="col">Fecha</th>
                <th scope="col">Total</th>
                <th></th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
  
<div class="modal" tabindex="-1" role="dialog" id="modalDetalle">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detalle de Cotizacion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <h4>Productos</h4>
            <table class="table table-striped table-bordered table-dark" id="tableDetalleProductos">
              <thead>
                <tr>
                  <th scope="col">Nombre</th>
                  <th scope="col">Descripcion</th>
                  <th scope="col">Cantidad</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <h4>Materia Prima</h4>
            <table class="table table-striped table-bordered table-dark" id="tableDetalleMaterias">
              <thead>
                <tr>
                  <th scope="col">MP</th>
                  <th scope="col">Clave</th>
                  <th scope="col">Cantidad</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>

<div id="fondo_cargando"></div>


<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="vendor/select2/js/select2.js"></script>


<script>

  var objProductos
  var objMaterias;

  $(function () { $('[data-toggle="tooltip"]').tooltip() });

  $("#tableCotizacionesAprobadas").on("click",".btnVerCotiz",function(){
    let id = $( this ).closest( "tr" ).attr("alt");

    $("#tableDetalleProductos tbody").html("");
    $("#tableDetalleMaterias tbody").html("");
    
    let prodFilter = objProductos.filter(x => x.idCotiz == id);
    let matsFilter = objMaterias.filter(x => x.idCotiz == id);

    prodFilter.map((k,v, i)=>{
      $("#tableDetalleProductos tbody").append(
        `<tr>
          <th scope="col">${k.nombre}</th>
          <th scope="col">${k.descripcion}</th>
          <th scope="col">${k.cantidad}</th>
        </tr>`
      );
    });

    matsFilter.map((k,v, i)=>{
      $("#tableDetalleMaterias tbody").append(
        `<tr>
          <th scope="col">${k.materia}</th>
          <th scope="col">${k.clave}</th>
          <th scope="col">${k.cantidad}</th>
        </tr>`
      );
    });

    $("#modalDetalle").modal("toggle");

  });

  $("#tableCotizacionesAprobadas").on("click",".btnTerminar",function(){
    if (window.confirm("Cerrar Cotización?")) {
      let id = $( this ).closest( "tr" ).attr("alt");

      $.ajax({
        type: 'POST',
        url: 'php/vision_terminar_cotizacion.php',
        data: {id},
        dataType:"json"
      }).done(function(data) {
        if(data>0){
          $('.modal').modal('hide');
          traerProductos();
          mandarMensaje("Cotizacion cerrada correctamente");
        }
      });
    }
  });

  let validarForm = form => {
    let inputs = $(form+" input");
    let resultado = [];
    let boolean = true;

    inputs.map(function(k,v){
      let valor = $(v).val();
      if(valor == ""){
        $(v).addClass("is-invalid");
        boolean = false;
      }else{
        $(v).removeClass("is-invalid");
        resultado.push(valor);
      }
    });
    
    if(boolean){
      return resultado;
    }else{
      return boolean;
    }
  };

  let traerProductos = () => {

    $('#fondo_cargando').show();
    let prods = $.ajax({
                  type: 'POST',
                  url: 'php/vision_traer_productosaprobadas.php',
                  dataType:"json"
                });

    let maters = $.ajax({
                  type: 'POST',
                  url: 'php/vision_traer_materiasaprobadas.php',
                  dataType:"json"
                });

    let aprobadas = $.ajax({
                    type: 'POST',
                    url: 'php/vision_traer_cotizacionesaprobadas.php',
                    dataType:"json"
                  });

    $.when(prods,maters,aprobadas).done(function(p1, m1, a1) {
      $("#nombreProductoExistente").html("<option value='0' selected disabled>...</option>");
      $("#nombreMateriaExistente").html("<option value='0' selected disabled>...</option>");
      $("#nombreClienteCotizacion").html("<option value='0' selected disabled>...</option>");
      $("#tableListadoHistorial tbody").html("");
      $("#tableListadoClientes tbody").html("");
      $("#tableCotizacionesAprobadas tbody").html("");

      objProductos = p1[0];

      objMaterias = m1[0];

      a1[0].map((k,v, i)=>{

        let btnVerCotiz = `<button class="btn btn-danger btn-sm btnVerCotiz"><i class="fas fa-eye"></i></button>`;

        let btnTerminar =`<button class="btn btn-success btn-sm btnTerminar"><i class="fas fa-check-double"></i></button>`;

        let row = `<tr alt="${k.idCotiz}">
                    <th>${k.cliente}</th>
                    <td>${k.fecha}</td>
                    <td>${k.total}</td>
                    <td>Aprobado</td>
                    <td>${btnVerCotiz + btnTerminar}</td>
                  </tr>`;

        $("#tableCotizacionesAprobadas tbody").append(row);
      });

      $('#fondo_cargando').hide();
    });
  }

  let encadenarModales = (primer, segundo) =>{
    $(primer).on('hidden.bs.modal', function (e) {
      // do something...
      $(segundo).modal("toggle");
      $(primer).off('hidden.bs.modal');
    });

    $(primer).modal("toggle");
  }

  traerProductos();

</script>

</html>
