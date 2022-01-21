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
          <h3>Editar Cotizaciones</h3>
        </div>
        <div class="card-body">
          <table class="table table-striped table-bordered" id="tableCotizacionesPendientes">
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
            <div class="text-center">
              <h3>Crear producto nuevo</h3>
            </div>
            <form id="formNuevoProducto">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Nombre</label>
                  <input type="text" class="form-control" id="nombreProductoNuevo">
                  <div class="invalid-feedback">
                    Campo no puede ir vacio.
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label>Descripción</label>
                  <input type="text" class="form-control" id="descProductoNuevo">
                  <div class="invalid-feedback">
                    Campo no puede ir vacio.
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Costo</label>
                  <input type="text" class="form-control" id="costoProductoNuevo">
                  <div class="invalid-feedback">
                    Campo con informacion no valida. 
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label>Clave</label>
                  <input type="text" class="form-control" id="claveProductoNuevo">
                  <div class="invalid-feedback">
                    Campo no puede ir vacio.
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Cantidad</label>
                  <input type="text" class="form-control" id="cantidadProductoNuevo">
                  <div class="invalid-feedback">
                    Campo con informacion no valida. 
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="imagenProductoNuevo" class="form-label">Imagen</label>
                  <input class="form-control" id="imagenProductoNuevo" type="file" accept="image/*" data-type='image'>
                  <div class="invalid-feedback">
                    Favor de seleccionar imagen.
                  </div>
                </div>
              </div>
            </form>
            <div class="text-center">
              <button class="btn btn-success" id="btnAgregarProductoNuevo">Agregar</button>
            </div>
            <hr>
            <div class="text-center">
              <h3>Seleccionar producto</h3>
            </div>
            <form id="formSelectProducto">
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label>Producto</label>
                  <select type="text" class="form-control" id="nombreProductoExistente"></select>
                </div>
                <div class="form-group col-md-4">
                  <label>Cantidad</label>
                  <input type="text" class="form-control" id="cantidadProductoExistente">
                  <div class="invalid-feedback">
                    Campo con informacion no valida. 
                  </div>
                </div>
                <div class="form-group col-md-4">
                  <label>Costo</label>
                  <input type="text" class="form-control" id="costoProductoExistente">
                  <div class="invalid-feedback">
                    Campo con informacion no valida. 
                  </div>
                </div>
              </div>
            </form>
            <div class="text-center">
              <button class="btn btn-success" id="btnAgregarProductoExistente">Agregar</button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <h4>Productos</h4>
            <table class="table table-striped table-bordered table-dark" id="tableDetalleProductos">
              <thead>
                <tr>
                  <th scope="col">Nombre</th>
                  <th scope="col">Descripcion</th>
                  <th scope="col">Costo</th>
                  <th scope="col">Cantidad</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
            <button class="btn btn-primary" id="btnGuardarEditarCotizacion">Guardar Cambios</button>
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

  var objProductosPends, objProductosTotales;

  $(function () { $('[data-toggle="tooltip"]').tooltip() });

  $("#tableCotizacionesPendientes").on("click",".btnEditar",function(){
    let id = $( this ).closest( "tr" ).attr("alt");

    $("#tableDetalleProductos tbody").html("");
    
    let prodFilter = objProductosPends.filter(x => x.idCotiz == id);

    prodFilter.map((k,v, i)=>{
      agregarProductoTabla([k.nombre, k.descripcion, k.costo, "", k.cantidad, "", k.idProd]);
    });

    // console.log(prodFilter);

    $("#btnGuardarEditarCotizacion").val(id);
    $("#modalDetalle").modal("toggle");

  });

  $("#btnAgregarProductoNuevo").on("click",()=>{
    let nombre = $("#nombreProductoNuevo").val();
    let descr = $("#descProductoNuevo").val();
    let costo = $("#costoProductoNuevo").val();
    let clave = $("#claveProductoNuevo").val();
    let cantid = $("#cantidadProductoNuevo").val();
    let image = $("#imagenProductoNuevo").val();

    let img = image.substr(12,image.length);

    if(isNaN($("#costoProductoNuevo").val()) || $("#costoProductoNuevo").val()==""){
      $("#costoProductoNuevo").addClass("is-invalid");
    }else{
      $("#costoProductoNuevo").removeClass("is-invalid");

      if(isNaN($("#cantidadProductoNuevo").val()) || $("#cantidadProductoNuevo").val() ==""){
        $("#cantidadProductoNuevo").addClass("is-invalid");
      }else{
        $("#cantidadProductoNuevo").removeClass("is-invalid");

        let arreglo = validarForm("#formNuevoProducto");

        if(arreglo){
          arreglo.pop();
          arreglo.push(imagen);
          guardarProducto(arreglo);
        }else{
          mandarMensaje("Faltan campos");
        }
      }
    }
    
  });

  $("#tableDetalleProductos").on("click",".btnQuitar",function(){
    $( this ).closest( "tr" ).remove();
  });

  $("#btnAgregarProductoExistente").on("click",()=>{
    let nombre = $('option:selected', "#nombreProductoExistente").attr('alt1');
    let descr = $('option:selected', "#nombreProductoExistente").attr('alt3');

    let idProd = $("#nombreProductoExistente").val();

    if(idProd == null){
      mandarMensaje("No hay producto seleccionado");
    }else{
      if(isNaN($("#cantidadProductoExistente").val()) || $("#cantidadProductoExistente").val()==""){
        $("#cantidadProductoExistente").addClass("is-invalid");
      }else{
        $("#cantidadProductoExistente").removeClass("is-invalid");

        if(isNaN($("#costoProductoExistente").val()) || $("#costoProductoExistente").val()==""){
          $("#costoProductoExistente").addClass("is-invalid");          
        }else{
          $("#costoProductoExistente").removeClass("is-invalid");

          let cantidad = $("#cantidadProductoExistente").val();
          let costo = $("#costoProductoExistente").val();

          agregarProductoTabla([nombre, descr, costo, "", cantidad,"", idProd]);
          $("#nombreProductoExistente").val(0);
          $("#cantidadProductoExistente").val("");
          $("#costoProductoExistente").val("");
        }
        
      }
      
    }
    
  });

  $("#imagenProductoNuevo").on("change",function(){
    let nombre = $(this).val();

    if(nombre != ""){
      const file = this.files[0];
      const fileType = file['type'];
      const validImageTypes = ['image/gif', 'image/jpeg', 'image/png'];
      if (!validImageTypes.includes(fileType)) {
          mandarMensaje("Archivo no es imagen");
      }else{
        var formData = new FormData();
        formData.append("file", file);

        var xhttp = new XMLHttpRequest();

        // Set POST method and ajax file path
        xhttp.open("POST", "php/vision_subir_imagenes.php", true);

        // call on request changes state
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {

            var response = this.responseText;
            if(response == 0){
              mandarMensaje("Archivo no subido.");
            }else{
              mandarMensaje("Archivo subido correctamente.");
              let object = JSON.parse(response);
              imagen = object.imagen;
            }
          }
        };

        // Send request with data
        xhttp.send(formData);
      }
    }
  });

  $("#btnGuardarEditarCotizacion").on("click",function(){
    let productos = obtenerProductos();
    let idCotiz = $(this).val();
    // if(materias){
      if(productos){
        if (window.confirm("Guardar Cotización?")) {
          editarCotizacion(idCotiz, productos);
        }
        
      }else{
        mandarMensaje("No hay productos agregados");
      }
    // }
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
                  url: 'php/vision_traer_productospendientes.php',
                  dataType:"json"
                });

    let pendientes = $.ajax({
                    type: 'POST',
                    url: 'php/vision_traer_cotizacionespendientes.php',
                    dataType:"json"
                  });

    let prods3 = $.ajax({
                  type: 'POST',
                  url: 'php/vision_traer_productos.php',
                  dataType:"json"
                });

    $.when(prods, pendientes, prods3).done(function(p1, p2, p3) {
      $("#nombreProductoExistente").html("<option value='0' selected disabled>...</option>");
      // $("#nombreMateriaExistente").html("<option value='0' selected disabled>...</option>");
      // $("#nombreClienteCotizacion").html("<option value='0' selected disabled>...</option>");
      // $("#tableListadoHistorial tbody").html("");
      // $("#tableListadoClientes tbody").html("");
      $("#tableCotizacionesPendientes tbody").html("");

      objProductosPends = p1[0];

      p2[0].map((k,v, i)=>{

        let row = `<tr alt="${k.idCotiz}">
                    <td scope="col">${k.cliente}</td>
                    <td scope="col">${k.fecha}</td>
                    <td scope="col">${k.total}</td>
                    <td><button class="btn btn-sm btn-primary btnEditar"><i class="far fa-edit"></i></button></td>
                  </tr>`;

        $("#tableCotizacionesPendientes tbody").append(row);
      });

      p3[0].map((k,v, i)=>{
        $("#nombreProductoExistente").append(`<option value="${k.idProducto}" alt1="${k.nombre}" alt3="${k.descr}">${k.nombre}</option>`);
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

  let guardarProducto = arreglo => {

    $.ajax({
      type: 'POST',
      url: 'php/vision_guardar_productos.php',
      data: {arreglo},
      dataType:"json"
    }).done(function(data) {
      if(data>0){

        $("#nombreProductoNuevo").val("");
        $("#descProductoNuevo").val("");
        $("#costoProductoNuevo").val("");
        $("#claveProductoNuevo").val("");
        $("#cantidadProductoNuevo").val("");
        $("#imagenProductoNuevo").val("");

        traerProductos();
        mandarMensaje("Producto agregado a la lista");
        arreglo.push(data);
        agregarProductoTabla(arreglo);
      }
    });
  };

  let agregarProductoTabla = arreglo =>{

    let nombre = arreglo[0];
    let descr = arreglo[1];
    let costo = arreglo[2];
    let cantidad = arreglo[4];
    let id = arreglo[6];

    let html = `<tr alt="${id}" alt2="${cantidad}" alt3="${costo}">
              <th>${nombre}</th>
              <td>${descr}</td>
              <td>${costo}</td>
              <td>${cantidad}</td>
              <td><button class="btn btn-sm btn-danger btnQuitar"><i class="fas fa-trash-alt"></i></button></th>
            </tr>`;

    $("#tableDetalleProductos tbody").append(html);

  }

  let obtenerProductos = () => {
    let productos = $("#tableDetalleProductos tbody tr");
    let resultado = [];

    if(productos.length > 0){
      productos.map((k,v,i)=>{
        let id = $(v).attr("alt");
        let canti = $(v).attr("alt2");
        let costo = $(v).attr("alt3");
        resultado.push([id, canti, costo]);
      });
      return resultado;
    }else{
      return false;
    }
  }

  let editarCotizacion = (idCotiz, productos) =>{
    $('#fondo_cargando').show();

    $.ajax({
      type: 'POST',
      url: 'php/vision_editar_cotizacion.php',
      data: {idCotiz, productos},
      dataType:"json"
    }).done(function(data) {

      $('#fondo_cargando').hide();
      $("#modalDetalle").modal("toggle");
      if(data==0){
        mandarMensaje("Cambios no guardados");
      }else{
        mandarMensaje("Cambios guardados correctamente");

        traerProductos();
      }
    });
  };

  traerProductos();

</script>

</html>
