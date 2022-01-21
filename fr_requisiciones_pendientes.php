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
        max-height: 55px; 
        min-height: 55px;
        width:100px;
    }
    .Autorizada{
        color:green;
    }

    
</style>

<body>
    <div class="container-fluid" id="div_principal">

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor">
            <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Reporte Pendientes de Autorización</div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_autorizar" id="i_filtro_autorizar" class="form-control filtrar_renglones" alt="renglon_autorizar" placeholder="Filtrar" autocomplete="off"></div>
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-success btn-sm form-control" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                    </div>
                </div> 
                <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
                    <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
                    <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
                    <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
                    <input type="hidden" readonly id="i_datos_excel" name='i_datos_excel'>
                </form>
                <br>
                <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_autorizar">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Unidad Negocio</th>
                          <th scope="col">Clave Suc</th>
                          <th scope="col">Sucursal</th>
                          <th scope="col">Folio</th>
                          <th scope="col">Descripción General</th>
                          <th scope="col">Importe Total</th>
                          <th scope="col">Tipo</th>
                          <th scope="col">PDF</th>
                          <th scope="col">Estatus</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>  
                </div>

                </div>
                <br>

            </div> <!--div_contenedor-->
        </div>      

    </div> <!--div_principal-->


<div class="modal fade" id="dialog_archivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Requisición</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			    
			</div>
			<div class="modal-body">
					<div style="width:100%" id="div_archivo"></div>
			</div>
		
		</div>
	</div>
</div>
    
</body>

<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>

    var modulo='R_PENDIENTES_AUTORIZAR';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idsUnidades=',<?php echo $_SESSION['unidades']?>';
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    $(function(){

        mostrarBotonAyuda(modulo);
       
        buscarInformacion(muestraSucursalesPermisoListaId(idsUnidades,modulo,idUsuario));

       function buscarInformacion(idsSucursales){
           
            $('#forma').validationEngine('hide');
            $('#i_filtro_autorizar').val('');
            $('.renglon_autorizar').remove();
   
            $.ajax({

                type: 'POST',
                url: 'php/autorizar_buscar_pendientes.php',
                dataType:"json", 
                data:{'idsUnidades' : idsUnidades,
                      'idUsuario' : idUsuario,
                      'idsSucursales':idsSucursales
                },

                success: function(data) {
                 console.log(data);
                   if(data.length != 0){

                        $('.renglon_autorizar').remove();
                   
                        for(var i=0;data.length>i;i++){
                        
                            var iconoPdf='<button type="button" class="btn btn-success btn-sm form-control" alt="' + data[i].id+'" id="b_pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>';
                            var html='<tr class="renglon_autorizar '+data[i].estatus+'">\
                                       <td data-label="usuario">' + data[i].unidad_negocio+ '</td>\
                                        <td data-label="usuario">' + data[i].clave_suc+ '</td>\
                                        <td data-label="Nombre">' + data[i].sucursal+ '</td>\
                                        <td data-label="usuario">' + data[i].folio+ '</td>\
                                        <td data-label="Nombre">' + data[i].descripcion+ '</td>\
                                        <td data-label="usuario">' + data[i].total+ '</td>\
                                        <td data-label="usuario">' + data[i].tipo+ '</td>\
                                        <td data-label="usuario">' + iconoPdf+ '</td>\
                                        <td data-label="Nombre">' + data[i].estatus+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_autorizar tbody').append(html);   
                        }

                   }else{

                        mandarMensaje('No se encontró información');
                   }

                },
                error: function (xhr) {
                    console.log('autorizar_buscar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }
        
        /* funcion que manda a generar la insecion o actualizacion de un registro */    
        $(document).on('click','.r_estatus',function(){

         var id=$(this).attr('alt');
         var folio=$(this).attr('alt2');
         var estatus=$(this).val();

         if($(this).is(':checked')==false){
            estatus = 1;
         }

         guardarEstatus(id,folio,estatus,'check');

        });


        $(document).on('click','#b_reactivar_guardar',function(){
            var id=$('#i_folio').attr('alt');
            var folio=$('#i_folio').val();
            if(id>0){
                guardarEstatus(id,folio,1,'b_reactivar_guardar');
            }else{
                mandarMensaje('Debes seleccionar primero una requisición');
            }
        });

        function guardarEstatus(id,folio,estatus,boton){
         $.ajax({
                type: 'POST',
                url: 'php/autorizar_guardar.php', 
                data: {
                   'id':  id,
                   'estatus' : estatus  
                },
                //una vez finalizado correctamente
                success: function(data){
               
                    if (data > 0 ) {

                        buscarInformacion();
                        if(boton=='check'){
                            if (estatus == 2){
                                    
                                mandarMensaje('La requisision: '+folio+' se Autorizó correctamente');
        
                            }else if(estatus == 3){
                                
                                mandarMensaje('La requisision: '+folio+' se Rechazó correctamente');
                                    
                            }
                        }else{
                            mandarMensaje('La requisision: '+folio+' se Reactivó correctamente');
                            $('#dialog_reactivar').modal('hide');
                        }
                    
                    }else{
                           
                        mandarMensaje('Error en el guardado');
                    }

                },
                    //si ha ocurrido un error
                 error: function(xhr){
                    console.log('autorizar_guardar.php --> '+JSON.stringify(xhr));
                    mandarMensaje("Ha ocurrido un error.");
                }
            });
          
        }

        $('#b_reactivar').on('click',function(){
            $('#formaReactivar input').val('');
            $('#dialog_reactivar').modal('show');
        });

        $('#b_buscar_requis').on('click',function(){
            $('#i_filtro_requis').val('');
            $('.renglon_requis').remove();
   
            $.ajax({

                type: 'POST',
                url: 'php/autorizar_buscar_requis_reactivar.php',
                dataType:"json", 
                data:{'idsUnidades' : idsUnidades,
                      'idUsuario' : idUsuario
                },
                success: function(data) {
                 
                   if(data.length != 0){

                        $('.renglon_requis').remove();
                   
                        for(var i=0;data.length>i;i++){
                            
                            var html='<tr class="renglon_requis" alt="'+data[i].id+'" alt2="'+data[i].folio+'">\
                                        <td data-label="usuario">' + data[i].folio+ '</td>\
                                        <td data-label="usuario">' + data[i].fecha_pedido+ '</td>\
                                        <td data-label="Nombre">' + data[i].descripcion+ '</td>\
                                        <td data-label="usuario">' + data[i].total+ '</td>\
                                        <td data-label="Nombre">' + data[i].estatus+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_requis tbody').append(html);  
                            $('#dialog_buscar_requis').modal('show'); 
                        }
                   }else{

                        mandarMensaje('No se encontró información');
                   }

                },
                error: function (xhr) {
                    console.log('autorizar_buscar_requis_reactivar.php --> '+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
            $('#dialog_reactivar').modal('show');
        });

        $('#t_requis').on('click', '.renglon_requis', function() {
            
            var idRequisicion = $(this).attr('alt');
            
            $('#dialog_buscar_requis').modal('hide');
            muestraRegistro(idRequisicion);


        });



        function muestraRegistro(idRequisicion){ 
           
            $.ajax({
                type: 'POST',
                url: 'php/autorizar_buscar_requis_reactivar_id.php',
                dataType:"json", 
                data:{
                    'idRequisicion':idRequisicion
                },
                success: function(data) {
                    
                    $('#i_folio').attr('alt',idRequisicion).val(data[0].folio);
                    $('#i_solicito').val(data[0].solicito);
                    $('#i_departamento').val(data[0].departamento);
                    $('#fecha_pedido').val(data[0].fecha_pedido);
                    $('#i_descripcion').val(data[0].descripcion);
                    $('#i_costo').val(data[0].costo);
                    $('#i_estatus').val(data[0].estatus);
                   
                },
                error: function (xhr) {
                    console.log('autorizar_buscar_requis_reactivar_id.php -->'+JSON.stringify(xhr));
                    mandarMensaje(xhr.responseText);
                }
            });
        }

        /******* Al dar click sobre alguna cotizacion esta manda a buscar los datos de la cotizacion selecionada *********/
        $(document).on('click', '#b_pdf', function() {
          
            var idRequi = $(this).attr('alt');
            var folio = $(this).attr('alt2');
            
            var datos = {
                'path':'formato_requisicion',
                'idRegistro':idRequi,
                'tipo':2,
                'vp':'vp_requi'
            };
            
            
            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);
            
            $.post('php/convierte_pdf.php',{
                'D':JSON.stringify(datosJ)
                },function(data){
                    setTimeout (mandaGenerarPDF(idRequi), 10000); 
               });
        });
       /******* Fin de click sobre renglon cotizacion  *********/

        function mandaGenerarPDF(idRequi){
            
            var idRazonSocial=$('#i_id_razon_social_c').val();
            $("#div_archivo").empty(); 
            
            var ruta='formatosPdf/formato_vp_requisicion_'+idRequi+'.pdf';
           
            var fil="<embed width='100%' height='500px' src='"+ruta+"'>";
            $("#div_archivo").append(fil);  

            $('#dialog_archivo').modal('show');
       }


       $('#b_excel').click(function(){

            var datos = {
                'idUsuario':idUsuario,
                'idsUnidades':idsUnidades
            };

            console.log(JSON.stringify(datos));

            $("#i_nombre_excel").val('Requisiciones Pendientes de Autorización');
            $("#i_fecha_excel").val(hoy);
            $('#i_modulo_excel').val(modulo);
            $('#i_datos_excel').val(JSON.stringify(datos));

            $("#f_imprimir_excel").submit();
        });
       

    });

</script>

</html>