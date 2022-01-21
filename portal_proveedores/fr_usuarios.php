<?php
$boton=0;
if(isset($_GET['boton'])){
    $boton=$_GET['boton'];
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
                        <div class="titulo_ban" id="d_titulo"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-7"></div>
                    
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar_cuenta"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-info btn-sm form-control" id="b_regresar_inicio"><i class="fa fa-arrow-circle-o-left " aria-hidden="true"></i> Regresar</button>
                    </div>
                </div>
                <br><br>

                <div class="row">
                    <div class="col-sm-12 col-md-1"></div>
                    <div class="col-sm-12 col-md-10">
                        <form id="forma" name="forma">
                           
                            <div class="form-group row">
                                <label for="i_rfc" class="col-sm-6 col-md-6 col-form-label requerido">RFC </label>
                                <div class="col-sm-12 col-md-6">
                                    <input type="text" class="form-control validate[required,minSize[12],maxSize[13],custom[onlyLetterNumberN]]" id="i_rfc"  autocomplete="off">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-12 col-md-12 col-form-label" style="color:green; font-size:12px;">* Es necesario agregar la clave de la unidad con el folio. Ej. CLAVE-987</label>
                            </div>
                            <div class="form-group row">
                                <label for="i_oc" class="col-sm-6 col-md-6 col-form-label requerido">Folio Orden de Compra</label>
                                <div class="col-sm-12 col-md-4">
                                    <input type="text" class="form-control validate[required]" id="i_oc" placeholder="Clave Unidad-Folio Orden de Compra"  autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_entrada_compra" class="col-sm-6 col-md-6 col-form-label requerido">Folio de recepción de mercancía y servicios</label>
                                <div class="col-sm-12 col-md-4">
                                    <input type="text" class="form-control validate[required]" id="i_entrada_compra" placeholder="Clave Unidad-Folio de recepción de mercancía y servicios"  autocomplete="off">
                                </div>
                            </div>
                             <div class="form-group row">
                                <label for="i_password" class="col-sm-6 col-md-6 col-form-label requerido">Contraseña </label>
                                <div class="col-sm-12 col-md-6">
                                    <input type="password" class="form-control validate[required]" id="i_password" name="i_password" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="i_confirmar" class="col-sm-6 col-md-6 col-form-label requerido">Confirmar Contraseña</label>
                                <div class="col-sm-12 col-md-6">
                                    <input type="password" class="form-control validate[required,equals[i_password]]" id="i_confirmar" name="i_confirmar" autocomplete="off">
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
                <br>
            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->
    
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
  var boton = '<?php echo $boton?>';
    $(function(){

        if(boton==0){
            $('#d_titulo').html('').html('Recuperar Contraseña');
        }else{
            $('#d_titulo').html('').html('Crear Usuario para Proveedor');
        }

        $('#b_guardar_cuenta').click(function(){
          
          $('#b_guardar_cuenta').prop('disabled',true);

           if ($('#forma').validationEngine('validate')){
               
                   verificar();

           }else{
              
               $('#b_guardar_cuenta').prop('disabled',false);
           }
       });


        function verificar(){
            var ocUnidad=$('#i_oc').val();
            var dato=ocUnidad.split('-');
            var cveUnidad=dato[0];
            var folioOc=dato[1];

            var E01Unidad=$('#i_entrada_compra').val();
            var datoE01=E01Unidad.split('-');
            var cveUnidadE01=datoE01[0];
            var folioE01=datoE01[1];

           


            
            if(cveUnidad.trim()==cveUnidadE01.trim()){
                $.ajax({
                    type: 'POST',
                    url: 'php/usuarios_verificar.php',
                    data:  {
                        'rfc': $('#i_rfc').val(),
                        'folioOc': folioOc,
                        'folioE01' : folioE01,
                        'cveUnidad' : cveUnidad
                    },
                    success: function(data) 
                    {


                        if (data > 0)
                        {
                            idProveedor=data;
                            guardar();
                        } else {

                            mandarMensaje('NO se encontró información con los datos ingresados, verifica que sean correctos');
                            $('#b_guardar_cuenta').prop('disabled',false);
                        }

                        
                    },
                    error: function (xhr) {
                        $('#b_guardar_cuenta').prop('disabled',false);
                        console.log('php/usuarios_verificar.php'+JSON.stringify(xhr));
                        mandarMensaje('NO se encontró información con los datos ingresados, verifica que sean correctos *** ');
                    }
                });
            }else{
                $('#b_guardar_cuenta').prop('disabled',false);
                mandarMensaje('La Recepción de Mercacias y Servicios no pertenece a la unidad de negocio de la orden de compra, verifica que los datos sean correctos');
            }
        }

        
        /* funcion que manda a generar la insecion o actualizacion de un registro */    
        function guardar(){

         $.ajax({
                type: 'POST',
                url: 'php/usuarios_guardar.php', 
                dataType:"json", 
                data: {
                        'datos':obtenerDatos()

                },
                //una vez finalizado correctamente
                success: function(data){
                    console.log(data);
                    if (data > 0 ) {
                        if (boton == 1){
                        
                            mandarMensaje('La información se guardo correctamente');
                
                            $('#b_nuevo').click();

                        }else{
                            
                            mandarMensaje('La contraseña se actualizó correctamente');
                            $('#b_nuevo').click();
                            
                        }
                    

                    }else{
                        
                        mandarMensaje('Error en el guardado');
                        $('#b_guardar_cuenta').prop('disabled',false);
                    }

                },
                    //si ha ocurrido un error
                 error: function(xhr){
                    console.log('php/usuarios_guardar.php-->'+ JSON.stringify(xhr));
                    mandarMensaje("Ha ocurrido un error.");
                    $('#b_guardar_cuenta').prop('disabled',false);
                }
            });
           
        }
        /* obtine los datos y los guarda en un arreglo*/
        function obtenerDatos(){
            var paquete = [];
                paquete[0]= 1;
                var ocUnidad=$('#i_oc').val();
                var dato=ocUnidad.split('-');
                var idOc=dato[0];
            
          
                var paq = {
                    'idProveedor' : idProveedor,
                    'rfc' : $('#i_rfc').val(),
                    'idOc' : idOc,
                    'password' : $('#i_password').val()
                }
                paquete.push(paq);
              
            return paquete;
        }    
       
       
        $('#b_regresar_inicio').on('click',function(){
          
          window.open("fr_login.php","_self");
       });
       

    });

</script>

</html>