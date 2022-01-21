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
    <div class="col-md-3">
      <button class="btn btn-warning btn-lg" id="btnHistorial">Historial</button>
    </div>
    <div class="col-md-3">
      <button class="btn btn-success btn-lg" id="btnClientes">Clientes</button>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-12">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <h3>Productos</h3>
        </div>
        <div class="card-body">
          <div id="paso1" class="pasos">

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

          <!-- <div class="pasos" id="paso3" hidden>            

            <div class="text-center">
              <h3>Seleccionar Materia Prima</h3>
            </div>
            <form id="formSelectMateria">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Materia Prima</label>
                  <select type="text" class="form-control" id="nombreMateriaExistente"></select>
                </div>
                <div class="form-group col-md-6">
                  <label>Cantidad</label>
                  <input type="text" class="form-control" id="cantidadMateriaExistente">
                  <div class="invalid-feedback">
                    Campo con informacion no valida. 
                  </div>
                </div>
              </div>
            </form>
            <div class="text-center">
              <button class="btn btn-success" id="btnAgregarMateriaExistente">Agregar</button>
            </div>
          </div> -->

          <div class="pasos" id="paso2" hidden>
            <div class="text-center">
              <h3>Información Prospecto</h3>
            </div>
            <form id="formProspecto">
            <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Nombre</label>
                  <input type="text" class="form-control" id="nombreProspecto">
                  <div class="invalid-feedback">
                    Campo no puede ir vacio. 
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label>Telefono</label>
                  <input type="text" class="form-control" id="telefonoProspecto">
                  <div class="invalid-feedback">
                    Campo no puede ir vacio. 
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Correo</label>
                  <input type="text" class="form-control" id="correoProspecto">
                  <div class="invalid-feedback">
                    Campo no puede ir vacio. 
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Costo Total</label>
                  <input type="text" class="form-control" id="totalProspecto" disabled>
                  <div class="invalid-feedback">
                    Campo con informacion no valida. 
                  </div>
                </div>
              </div>
            </form>
          </div>

        </div>
        <div class="card-footer">
          <button class="btn btn-primary" id="btnAnterior" hidden>Anterior</button>
          <button class="btn btn-primary" id="btnSiguiente">Siguiente</button>
          <button class="btn btn-success" id="btnFinalizar" hidden>Finalizar</button>
        </div>
      </div>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-12">
      <div class="card">
        <div class="card-header bg-secondary text-white">
          <h3>Lista de Productos</h3>
        </div>
        <div class="card-body">
          <table class="table table-striped table-bordered" id="tableListadoProductos">
            <thead>
              <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Clave</th>
                <th scope="col">Costo</th>
                <th scope="col">Cantidad</th>
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
  <!-- <div class="row mt-3">
    <div class="col-12">
      <div class="card">
        <div class="card-header bg-secondary text-white">
          <h3>Lista de Materia Prima</h3>
        </div>
        <div class="card-body">
          <table class="table table-striped table-bordered table-dark" id="tableListadoMaterias">
            <thead>
              <tr>
                <th scope="col">Descripcion</th>
                <th scope="col">Clave</th>
                <th scope="col">Cantidad</th>
                <th></th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div> -->
</div>
  
<div class="modal" tabindex="-1" role="dialog" id="modalHistorial">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Historial de Cotizaciones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-striped table-bordered" id="tableListadoHistorial">
          <thead>
            <tr>
              <th scope="col">Cliente</th>
              <th scope="col">Fecha</th>
              <th scope="col">Total</th>
              <th scope="col">Estatus</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modalClientes">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Listado de Clientes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-striped table-bordered" id="tableListadoClientes">
          <thead>
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">RFC</th>
              <th scope="col">Correo</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modalAprobarCliente">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Asignar cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <label>Cliente</label>
              <select class="form-control" id="nombreClienteCotizacion"></select>
            </div>
          </div>
          <div class="col-12">
            <hr>
            <label>Seleccionar</label>
            <form id="formSelectMateria">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Materia Prima</label>
                  <select type="text" class="form-control" id="nombreMateriaExistente"></select>
                </div>
                <div class="form-group col-md-6">
                  <label>Cantidad</label>
                  <input type="number" class="form-control" id="cantidadMateriaExistente">
                  <div class="invalid-feedback">
                    Campo con informacion no valida. 
                  </div>
                </div>
              </div>
            </form>
            <div class="text-center">
              <button class="btn btn-success" id="btnAgregarMateriaExistente">Agregar</button>
            </div>
          </div>
          <div class="col-12">
            <label>Materias Primas</label>
            <table class="table table-striped table-bordered" id="tableListadoMaterias">
              <thead>
                <tr>
                  <th scope="col">Descripcion</th>
                  <th scope="col">Clave</th>
                  <th scope="col">Cantidad</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" id="btnAprobarCotizacion">Guardar</button>
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

  var paso = 1;
  var imagen = "";
  var productosCotizacion = [];
  var historialCotizaciones = [];
  var objProspectos = [];

  $(function () { $('[data-toggle="tooltip"]').tooltip() });

  $("#btnSiguiente").on("click",()=>{

    switch(paso){
      case 1:
        let productos = $("#tableListadoProductos tbody tr");

        if(productos.length > 0){
          paso++;
          $("#tableListadoProductos .quitarProducto").prop("disabled", true);

          let totalCotizacion = 0;

          productos.map((k,v,i)=>{
            let canti = $(v).attr("alt2");
            let costo = $(v).attr("alt3");

            totalCotizacion += (canti * costo);
          });

          $("#totalProspecto").val(totalCotizacion);
        }else{
          mandarMensaje("Hay que agregar por lo menos un producto");
        }
        break;
      case 2:
        let materia = $("#tableListadoMaterias tbody tr");

        if(materia.length > 0){
          paso++;
          $("#tableListadoMaterias .quitarProducto").prop("disabled", true);
        }else{
          mandarMensaje("Hay que agregar por lo menos una materia prima");
        }
        break;
    }

    if(paso>1){
      $("#btnAnterior").prop("hidden", false);
    }
    if(paso == 2){
      $("#btnFinalizar").prop("hidden", false);
      $("#btnSiguiente").prop("hidden", true);
    }

    $(".pasos").prop("hidden", true);
    $("#paso"+paso).prop("hidden", false);
  });

  $("#btnAnterior").on("click",()=>{
    paso--;

    if(paso==1){
      $("#btnAnterior").prop("hidden", true);
      $("#tableListadoProductos .quitarProducto").prop("disabled", false);
    }

    if(paso < 3){
      $("#btnFinalizar").prop("hidden", true);
      $("#btnSiguiente").prop("hidden", false);
      $("#tableListadoMaterias .quitarProducto").prop("disabled", false);
    }

    $(".pasos").prop("hidden", true);
    $("#paso"+paso).prop("hidden", false);
  });

  $("#btnFinalizar").on("click",()=>{
    if(isNaN($("#totalProspecto").val()) || $("#totalProspecto").val()==""){
      $("#totalProspecto").addClass("is-invalid");
    }else{
      $("#totalProspecto").removeClass("is-invalid");

      let prospecto = validarForm("#formProspecto");

      if(prospecto){
        let materias = obtenerMaterias();
        let productos = obtenerProductos();

        // if(materias){
          if(productos){
            if (window.confirm("Guardar Cotización?")) {
              guardarCotizacion(prospecto, materias, productos);
            }
            
          }
        // }
        // guardarCotizacion(prospecto)
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

  $("body").on("click",".quitarProducto",function(){
    $( this ).closest( "tr" ).remove();
  });

  $("#btnAgregarProductoExistente").on("click",()=>{
    let nombre = $('option:selected', "#nombreProductoExistente").attr('alt1');
    let clave = $('option:selected', "#nombreProductoExistente").attr('alt3');

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

          agregarProductoTabla([nombre,"",costo, clave, cantidad,"", idProd]);
          $("#nombreProductoExistente").val(0);
          $("#cantidadProductoExistente").val("");
          $("#costoProductoExistente").val("");
        }
        
      }
      
    }
    
  });

  $("#btnAgregarMateriaExistente").on("click",()=>{
    let nombre = $('option:selected', "#nombreMateriaExistente").attr('alt1');
    let clave = $('option:selected', "#nombreMateriaExistente").attr('alt2');
    let restante = $('option:selected', "#nombreMateriaExistente").attr('alt3');

    let idMat = $("#nombreMateriaExistente").val();

    if(idMat == null){
      mandarMensaje("No hay materia prima seleccionada");
    }else{
      if(isNaN($("#cantidadMateriaExistente").val()) || $("#cantidadMateriaExistente").val()==""){
        $("#cantidadMateriaExistente").addClass("is-invalid");
      }else{
        $("#cantidadMateriaExistente").removeClass("is-invalid");
        let cantidad = $("#cantidadMateriaExistente").val();
        if(cantidad > restante){
          mandarMensaje("No hay suficiente materia prima, stock: "+restante);
        }else{
          agregarMateriaTabla([nombre, clave, cantidad, idMat]);
          $("#nombreMateriaExistente").val(0);
          $("#cantidadMateriaExistente").val("");
        }
      }      
    }    
  });

  $("#btnAprobarCotizacion").on("click",()=>{
    let idCotiz = $("#btnAprobarCotizacion").val();
    let idCliente = $("#nombreClienteCotizacion").val();

    if(idCliente){

      let materia = obtenerMaterias();

      if(materia){
        // $("#tableListadoMaterias .quitarProducto").prop("disabled", true);
        cambiarEstatusCotizacion(idCotiz, idCliente, 1, materia);
      }else{
        mandarMensaje("Hay que agregar por lo menos una materia prima");
      }
      
    }else{
      mandarMensaje("Hay que seleccionar un cliente de la lista");
    }
  });

  $("#tableListadoHistorial").on("click",".btnAprobar",function(){
    let id = $( this ).closest( "tr" ).attr("alt");
    console.log("aprobando: ", id);

    $("#btnAprobarCotizacion").val(id);

    encadenarModales("#modalHistorial","#modalAprobarCliente");
  });

  $("#tableListadoHistorial").on("click",".btnCancelar",function(){
    let id = $( this ).closest( "tr" ).attr("alt");
    cambiarEstatusCotizacion(id, 0, 2, null);
  });

  // $("#tableListadoHistorial").on("click",".btnEditar",function(){
  //   let id = $( this ).closest( "tr" ).attr("alt");

  //   let filtrados = productosCotizacion.filter(x => x.idCotiz == id);
  //   let prospecto = objProspectos.filter(x => x.idCotiz == id);

  //   $("#nombreProspecto").val(prospecto[0].nombre_cliente);
  //   $("#telefonoProspecto").val(prospecto[0].telefono);
  //   $("#correoProspecto").val(prospecto[0].correo);
  //   $("#totalProspecto").val(prospecto[0].total);

  //   $("#tableListadoProductos tbody").html("");

  //   filtrados.map((k,v,i)=>{

  //     let nombre = k.nombre;
  //     let descr = "";
  //     let costo = k.costo;
  //     let clave = k.clave;
  //     let canti = k.cantidad;
  //     let id = k.id;

  //     agregarProductoTabla([nombre, descr, costo, clave, canti, id]);
  //   });
  // });

  $("#tableListadoClientes").on("click",".btnDesactivarCliente",function(){
    let id = $( this ).closest( "tr" ).attr("alt");
    console.log("desactivando cliente: ", id);
  });

  $("#tableListadoHistorial").on("click",".btnVerPdf",function(){
    let idCotiz = $( this ).closest( "tr" ).attr("alt");

    var datos = {
        'path':'formato_cotizacion_vision',
        'idCotiz':idCotiz,
        'nombreArchivo':'cotizacion',
        'tipo':1
    };

    let objJsonStr = JSON.stringify(datos);
    let datosJ = datosUrl(objJsonStr);

    window.open("php/convierte_pdf.php?D="+datosJ,'_new');
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
    let costo = arreglo[2];
    let clave = arreglo[3];
    let cantidad = arreglo[4];
    let id = arreglo[6];

    let html = `<tr alt="${id}" alt2="${cantidad}" alt3="${costo}">
              <th>${nombre}</th>
              <td>${clave}</td>
              <td>${costo}</td>
              <td>${cantidad}</td>
              <td><button class="btn btn-danger btn-sm quitarProducto">X</button></td>
            </tr>`;

    $("#tableListadoProductos tbody").append(html);

  }

  let agregarMateriaTabla = arreglo =>{

    let nombre = arreglo[0];
    let clave = arreglo[1];
    let cantidad = arreglo[2];
    let id = arreglo[3];

    let html = `<tr alt="${id}" alt2="${cantidad}">
              <th>${nombre}</th>
              <td>${clave}</td>
              <td>${cantidad}</td>
              <td><button class="btn btn-danger btn-sm quitarProducto">X</button></td>
            </tr>`;

    $("#tableListadoMaterias tbody").append(html);

  }

  let traerProductos = () => {

    $('#fondo_cargando').show();
    let prods = $.ajax({
                  type: 'POST',
                  url: 'php/vision_traer_productos.php',
                  dataType:"json"
                });

    let maters = $.ajax({
                  type: 'POST',
                  url: 'php/vision_traer_materiasprimas.php',
                  dataType:"json"
                });

    let historial = $.ajax({
                    type: 'POST',
                    url: 'php/vision_traer_historial.php',
                    dataType:"json"
                  });

    let clientes = $.ajax({
                    type: 'POST',
                    url: 'php/vision_traer_clientes.php',
                    dataType:"json"
                  });

    let prodsCotiz = $.ajax({
                    type: 'POST',
                    url: 'php/vision_traer_productoscotizacion.php',
                    dataType:"json"
                  });

    let prospectos = $.ajax({
                    type: 'POST',
                    url: 'php/vision_traer_prospectos.php',
                    dataType:"json"
                  });

    $.when(prods,maters,historial, clientes, prodsCotiz, prospectos).done(function(p1, m1, h1, c1, p2, p3) {
      $("#nombreProductoExistente").html("<option value='0' selected disabled>...</option>");
      $("#nombreMateriaExistente").html("<option value='0' selected disabled>...</option>");
      $("#nombreClienteCotizacion").html("<option value='0' selected disabled>...</option>");
      $("#tableListadoHistorial tbody").html("");
      $("#tableListadoClientes tbody").html("");

      p1[0].map((k,v, i)=>{
        $("#nombreProductoExistente").append(`<option value="${k.idProducto}" alt1="${k.nombre}" alt3="${k.clave}">${k.nombre}</option>`);
      });

      m1[0].map((k,v, i)=>{
        $("#nombreMateriaExistente").append(`<option value="${k.idMateria}" alt1="${k.descr}" alt2="${k.clave}" alt3="${k.restante}" >${k.descr} - ${k.clave}</option>`);
      });

      h1[0].map((k,v, i)=>{

        let btnPdf = `<button class="btn btn-danger btn-sm btnVerPdf"><i class="fas fa-file-pdf"></i></button>`;

        let btnCancelar = `<button class="btn btn-warning btn-sm btnCancelar"><i class="fas fa-ban"></i></button>`;
        let btnAprobar = `<button class="btn btn-success btn-sm btnAprobar"><i class="fas fa-check-circle"></i></button>`;
        // let btnEditar = `<button class="btn btn-primary btn-sm btnEditar"><i class="fas fa-pencil-alt"></i></button>`
        let btnEditar = "";

        let todosBotones =btnAprobar+btnCancelar+btnEditar;

        let estatus = "Pendiente";

        if(k.estatus > 0){
          todosBotones = "";
          switch(k.estatus){
            case "1":
              estatus = "Aprobada";
              break;
            case "2":
              estatus = "Cancelada";
              break;
            case "3":
              estatus = "Terminada";
              break;
          }
        }

        let row = `<tr alt="${k.idCotiz}">
                    <th>${k.cliente}</th>
                    <td>${k.fecha}</td>
                    <td>${k.total}</td>
                    <td>${estatus}</td>
                    <td>${todosBotones + btnPdf}</td>
                  </tr>`;

        $("#tableListadoHistorial tbody").append(row);
      });

      c1[0].map((k,v,i)=>{
        let row = `<tr alt="${k.idCliente}">
                    <th>${k.nombreCorto}</th>
                    <td>${k.rfc}</td>
                    <td>${k.correo}</td>
                    <td><button class="btn btn-danger btn-sm btnDesactivarCliente"><i class="fas fa-trash"></i></button></td>
                  </tr>`;

        $("#tableListadoClientes tbody").append(row);

        $("#nombreClienteCotizacion").append(`<option value="${k.idCliente}">${k.nombreCorto} - ${k.rfc}</option>`);
      });

      productosCotizacion = p2[0];
      historialCotizaciones = h1[0];
      objProspectos = p3[0];

      $('#fondo_cargando').hide();
    });
  }

  let obtenerProductos = () => {
    let productos = $("#tableListadoProductos tbody tr");
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

  let obtenerMaterias = () => {
    let materia = $("#tableListadoMaterias tbody tr");
    let resultado = [];

    if(materia.length > 0){
      materia.map((k,v,i)=>{
        let id = $(v).attr("alt");
        let canti = $(v).attr("alt2");
        resultado.push([id, canti]);
      });
      return resultado;
    }else{
      return false;
    }
  }

  let guardarCotizacion = (prospecto, materias, productos) =>{
    $('#fondo_cargando').show();

    $.ajax({
      type: 'POST',
      url: 'php/vision_guardar_cotizacion.php',
      data: {prospecto, materias, productos},
      dataType:"json"
    }).done(function(data) {

      $('#fondo_cargando').hide();
      if(data==0){
        mandarMensaje("Cotización no guardada");

      }else{
        mandarMensaje("Cotización guardada correctamente");
        paso = 1;
        $(".pasos").prop("hidden", true);
        $("#paso"+paso).prop("hidden", false);
        traerProductos();
        $("#tableListadoProductos tbody").html("");
        $("#tableListadoMaterias tbody").html("");
        $("#btnAnterior").prop("hidden", true);
        $("#btnFinalizar").prop("hidden", true);
        $("#btnSiguiente").prop("hidden", false);
        $("#tableListadoMaterias .quitarProducto").prop("disabled", false);
        $("#tableListadoProductos .quitarProducto").prop("disabled", false);

        $("#nombreProspecto").val("");
        $("#telefonoProspecto").val("");
        $("#correoProspecto").val("");
        $("#totalProspecto").val("");
      }
    });
  };

  let encadenarModales = (primer, segundo) =>{
    $(primer).on('hidden.bs.modal', function (e) {
      // do something...
      $(segundo).modal("toggle");
      $(primer).off('hidden.bs.modal');
    });

    $(primer).modal("toggle");
  }

  let cambiarEstatusCotizacion = (idCotiz, idCliente, estatus, materias) => {
    $.ajax({
      type: 'POST',
      url: 'php/vision_estatus_cotizacion.php',
      data: {idCotiz, idCliente, estatus, materias},
      dataType:"json"
    }).done(function(data) {
      if(data>0){
        $('.modal').modal('hide');
        traerProductos();
        mandarMensaje("Cotizacion actualizada correctamente");
        $("#btnHistorial").trigger("click");
      }
    });
  };

  $("#btnHistorial").on("click",()=>{
    $("#modalHistorial").modal("toggle");
  });

  $("#btnClientes").on("click",()=>{
    $("#modalClientes").modal("toggle");
  });

  traerProductos();

</script>

</html>
