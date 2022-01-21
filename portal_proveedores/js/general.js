/*
    Nora Escareño (2019-03-04) Contiene funciones generales que se utilizan en todo o la mayoria del sistema
*/
$(function(){

    /* Nora Escareño (2019-03-04):Detecta si el navegador es Chrome, 
    sino manda notificacion que es recomendable usar chrome para el mejor funcionamiento del sitio*/
    if(navigator.userAgent.indexOf("Chrome") != -1)
    {
        if(navigator.userAgent.indexOf("Edge") != -1)
        {
            mandarMensaje('Te recomendamos usar el navegador Chrome para el mejor funcionamiento y visualización del sitio.');
        }
    }else{
        mandarMensaje('Te recomendamos usar el navegador Chrome para el mejor funcionamiento y visualización del sitio.');
    }

    //---------------------------Modal de alerta para funcion mandarMensaje()
    var dialogo = '<div class="modal fade bd-example-modal-sm" tabindex="-1" aria-labelledby="mySmallModalLabel" id="modal_alerta" role="dialog">\
        <div class="modal-dialog modal-sm" role="document">\
        <div class="modal-content">\
            <div class="modal-header">\
            <h5 class="modal-title">Mensaje del sistema</h5>\
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
                <span aria-hidden="true">&times;</span>\
            </button>\
            </div>\
            <div class="modal-body">\
            </div>\
            <div class="modal-footer">\
            <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>\
            </div>\
        </div>\
        </div>\
    </div>';
    $('body').append(dialogo);
    $("#modal_alerta").modal({'show':false});

    //---------------------------Modal de alerta para funcion mandarMensajeConfimacion()
    var dialogo2 = '<div class="modal fade bd-example-modal-sm" tabindex="-1" aria-labelledby="mySmallModalLabel" id="modal_alerta2" role="dialog">\
        <div class="modal-dialog modal-sm" role="document">\
        <div class="modal-content">\
            <div class="modal-header">\
            <h5 class="modal-title">Mensaje del sistema</h5>\
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
                <span aria-hidden="true">&times;</span>\
            </button>\
            </div>\
            <div class="modal-body">\
            </div>\
            <div class="modal-footer">\
            </div>\
        </div>\
        </div>\
    </div>';
    $('body').append(dialogo2);
    $("#modal_alerta2").modal({'show':false});
    
});

/*
Cuando haga un enter en la forma no me mande la forma cuando tengo un boton submit
*/
$(document).keydown(function(e) {  
    var test_var = e.target.nodeName.toUpperCase();
    if (e.target.type)
        var test_type = e.target.type.toUpperCase();
    if ((test_var == 'INPUT' && test_type == 'TEXT') || test_type == 'SEARCH' || test_type == 'SELECT' || test_var == 'TEXTAREA' || test_type == 'PASSWORD' || test_type == 'EMAIL') {
        return e.keyCode;
    } else if (e.keyCode == 8) {
        e.preventDefault();
    }
});

/*
Permite poner mayusculas y unusculas en la funcion de filtrar()
*/
$.expr[":"].contains = $.expr.createPseudo(function(arg) {
    return function(elem) {
        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    };
});

/*
Oculta los mensajes del validation Engine
*/
$("input,checkbox,textarea").click(function() {
    $(this).validationEngine('hide');
});

$("select").change(function() {
    $(this).validationEngine('hide');
});

/*
Mensaje notificacion al ejecutarse una acción
*/
function mandarMensaje(mensaje){
    $("#modal_alerta .modal-body").html("<p>"+mensaje+"</p>");
    $("#modal_alerta").modal("show");
}

/*
Mensaje para confirmar que se debe ejecutar una acción
*/
function mandarMensajeConfimacion(mensaje,id_registro,concepto){
    $("#modal_alerta2 .modal-body").html("<p>"+mensaje+"</p>");
    $("#modal_alerta2 .modal-footer").html("<button type='button' class='btn btn-danger b_cancelar' data-dismiss='modal'>No</button><button id='b_"+concepto+"' alt='"+id_registro+"' type='button' class='btn btn-primary b_aceptar' data-dismiss='modal'> Si</button>");
    $("#modal_alerta2").modal("show");
}

//**************** Le da a un input un formato de moneda ejemplo 1,456.45 ********** */
$(document).on("change",'.numeroMoneda',function(){
	var dinero=formatearNumero($(this).val());
	$(this).val(dinero);
});
//***************Cambia un numero a formato moneda ejemplo 1,456.45 **************** */
function formatearNumero(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    
    if(x[1]==undefined){
    	x2='.00';
    }else{
    	x2 = x.length > 1 ? '.' + (x[1]).substr(0,2) : '';
	}

    var rgx = /(\d+)(\d{3})/;

    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }

    return x1 + x2;

}

function formatearNumeroA4Dec(nStr) 
{

    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    
    if(x[1]==undefined){
        x2='.00';
    }else{
        x2 = x.length > 1 ? '.' + (x[1]).substr(0,4) : '';
    }

    var rgx = /(\d+)(\d{3})/;

    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }

    return x1 + x2;
}

//***************Cambia un numero a que solo acepte 6 caracteres decimales **************** */
function formatearNumeroA6Dec(nStr)
{

    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    
    if(x[1]==undefined){
    	x2='';
    }else{
    	x2 = x.length > 1 ? '.' + (x[1]).substr(0,6) : '';
	}

    var rgx = /(\d+)(\d{3})/;

    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }

    return x1 + x2;

}

function roundNum(n, d)
{

    return Math.round(n);

}
//***************Le quita el formato moneda a un numero de ejemplo 1,456.45 a 1456.45 **** */
function quitaComa(nstr){
	
	var texto=String(nstr);
	var res = texto.split(',');

	if(res.length>1){
		if(nstr.indexOf(',') != -1){	
			x = nstr.split(',');////////////QUITA COMA PARA OPERACIONES O GUARDAR
			var cantidad='';
		
			for( var y=0;y<x.length;y++){
				cantidad=cantidad+x[y];
				
			}
			return parseFloat(cantidad);
		}else{
			return parseFloat(nstr);
		}	
	}else{
		return parseFloat(nstr);
	}
}

/*
Funcion que filtra los renglones de Búsqueda de de un modal se activa en cuanto se ingresa 
info al un input con la clase: ( .filtrar_renglones) y en el alt trae en nombre de la clase
 de los renglones a filtrar ( renglon_usuarios )
Muestra o quita los renglones que tengan la letra que se va indicando
*/
$(document).on('keyup','.filtrar_renglones',function(){

    var campo = $(this).attr('id');// obtene el id del filtro que se esta usuando
    var renglon = $(this).attr('alt');// obtine el nombre de la clase de el renglon de modal que se esta usando
    var aux = $("#"+campo).val();
   
    if(aux == '')
    {
        $('.'+renglon).show();
    }
    else
    {
        $('.'+renglon).hide();
        $('.'+renglon+':contains(' + aux + ')').show();
        aux = aux.toLowerCase();
        $('.'+renglon+':contains(' + aux + ')').show();
        aux = aux.toUpperCase();
        $('.'+renglon+':contains(' + aux + ')').show();
    }
});

/*
Funcion para filtrar por campos de renglones
*/
$(document).on('keyup','.filtrar_campos_renglones',function(){
    
    var id=$(this).prop('id');   //id del input filtro
    var campo=$(this).attr('alt');  //clase del campo en el que se va a buscar
    var visibleid=$(this).attr('alt2');  
    var padre = $(this).attr('alt3');  //nombre del renglon padre
    var valor = $(this).attr('alt4');  //numero de campos
   
    var aux = $("#"+id).val();

    if(aux == '')
    {
        $('.'+campo).parent().removeClass('v'+visibleid);
        $('.'+campo).parent().show();
    }else{
        $('.'+campo).parent().removeClass('v'+visibleid);
        $('.'+campo+':contains(' + aux + ')').parent().addClass('v'+visibleid).show();
        aux = aux.toLowerCase();
        $('.'+campo+':contains(' + aux + ')').parent().addClass('v'+visibleid).show();
        aux = aux.toUpperCase();
        $('.'+campo+':contains(' + aux + ')').parent().addClass('v'+visibleid).show();
    }

    filtros_f(valor,padre);
});

function filtros_f(valor,padre){

    var parametro_g=valor; // cantidad de input que actuan en el filtrado
    
    $("."+padre).each(function () {
        var count=0;
        for (var i=1;i<=parametro_g;i++){
        
            if ($("#i_filtro_"+i).val()=='')
            {
                count=count+0;
            }else{ 
                if($(this).hasClass('v'+i)==false)
                {
                    count=count+1;
                }else{
                    count=count+0;
                }
            }
        }
        
        if (count==0){
            $(this).show();
        }else{
            $(this).hide();
        }    
    });
       
}	

/*
Funcion para filtrar por campos de renglones
*/
$(document).on('change','.filtrar_campos_renglones_combo',function(){
    
    var id=$(this).prop('id');   //id del input filtro
    var campo=$(this).attr('alt');  //clase del campo en el que se va a buscar
    var visibleid=$(this).attr('alt2');  
    var padre = $(this).attr('alt3');  //nombre del renglon padre
    var valor = $(this).attr('alt4');  //numero de campos
   //$('#my-select option:selected').html()
    var aux = $('#'+id+' option:selected').html();
    
    if(aux == '')
    {
        $('.'+campo).parent().removeClass('v'+visibleid);
        $('.'+campo).parent().show();
    }else{
        $('.'+campo).parent().removeClass('v'+visibleid);
        $('.'+campo+':contains(' + aux + ')').parent().addClass('v'+visibleid).show();
        aux = aux.toLowerCase();
        $('.'+campo+':contains(' + aux + ')').parent().addClass('v'+visibleid).show();
        aux = aux.toUpperCase();
        $('.'+campo+':contains(' + aux + ')').parent().addClass('v'+visibleid).show();
    }

    filtros_comb(valor,padre,id,visibleid);
});

function filtros_comb(valor,padre,id,visibleid){

    var parametro_g=valor; // cantidad de input que actuan en el filtrado
    
    $("."+padre).each(function () {  //recorre los renglones pero el cambio es por combo
        var count=0;
     
        if ($('#'+id+' option:selected').html()=='')
        {
            count=count+0;
        }else{ 
            if($(this).hasClass('v'+visibleid)==false)
            {
                count=count+1;
            }else{
                count=count+0;
            }
        }
        
        if (count==0){
            $(this).show();
        }else{
            $(this).hide();
        }    
    });
       
}	

/*
Buscamos el logo de la unidad actual
*del array de session donde traemos nuestra matriz de unidades y sucursales
*vamos a recorrerlo y vamos a comparar la unidad actual para regresar el valor del elemento logo
*array = nuestro array de unidades y sucursales
*elemento = id_unidad actual que vamos a comparar 
*/
function buscarLogoUnidad(array,elemento) {
    for (i = 0; i < array.length; i++) {
        if (array[i].id_unidad == elemento) {
            return array[i].logo;
        }
    }
}

/*
Mostrar botones de unidades de negocio
*matriz = arrar de unidades y sucursales
*contenedor = nombre id de contenedor donde agregaremos nuestros botones
*/
function muestraUnidades(matriz,contenedor,tipo){
    if(matriz.length > 0)
    {
      var datos=matriz;
      
      $("#"+contenedor).empty();
                  
        var datosTotal=datos.length;
        var numCol=0;
        var tDatos=0;
        var topRow='';
        var totalRen=0;
        var ren=0;

        if(datos.length > 0){
            
            if(datosTotal >3)
            {
                ren=datosTotal/3;
                topRow='9%';
                totalRen=parseInt(ren)+1;
            }else{
                ren=1;
                if(tipo == 'home')
                {
                    topRow='18%';
                }else{
                    topRow='7%';
                }
                
                totalRen=parseInt(ren);
            }
                
                for(var r=1; r<=totalRen; r++){
                    var ren='<div class="row row_unidad" id="r_unidad_'+r+'" style="margin-top:'+topRow+'"></div>';
                    $("#"+contenedor).append(ren);
                    
                    tDatos=datosTotal-numCol;
                    
                    if(tDatos < 3){
                        var totalCol=tDatos;
                    }else{
                    if(tDatos == 4){
                        var totalCol=2;
                    }else{
                        var totalCol=3;
                    }
                    }
                    
                    for(var c=0; c<totalCol; c++){ 
                        if(totalCol ==3){
                        var col ='<div class="col-sm-12 col-md-4 div_unidades">\
                                    <div><img width="210" src="imagenes/'+datos[numCol].logo+'"  class="unidad img-thumbnail" id="unidad_'+datos[numCol].id_unidad+'" alt="'+datos[numCol].id_unidad+'"/></div>\
                                </div>';
                        
                        }else if(totalCol == 2){
                        if(c==0){
                        var col ='<div class="col-sm-12 col-md-2"></div>\
                                    <div class="col-sm-12 col-md-4 div_unidades">\
                                    <div><img width="210" src="imagenes/'+datos[numCol].logo+'"  class="unidad img-thumbnail" id="unidad_'+datos[numCol].id_unidad+'" alt="'+datos[numCol].id_unidad+'"/></div>\
                                </div>';
                        }else{
                            var col ='<div class="col-sm-12 col-md-4 div_unidades">\
                                    <img width="210" src="imagenes/'+datos[numCol].logo+'"  class="unidad img-thumbnail" id="unidad_'+datos[numCol].id_unidad+'" alt="'+datos[numCol].id_unidad+'"/>\
                                </div>';
                        }
                        }else{
                        var col ='<div class="col-sm-12 col-md-4"></div>\
                                    <div class="col-sm-12 col-md-4 div_unidades">\
                                    <img width="210" src="imagenes/'+datos[numCol].logo+'"  class="unidad img-thumbnail" id="unidad_'+datos[numCol].id_unidad+'" alt="'+datos[numCol].id_unidad+'"/>\
                                </div>';
                        }
                        numCol++;

                        $('#r_unidad_'+r).append(col);
                    
                    }
                }
        }
    }else{
      $("#"+contenedor).text('Sin unidades');
    }
}


/*
Crea el combo select con imagen de las unidades de negoio a las que tiene acceso el usuario
por default muestra la de la unidad actual
*datos = arrar de unidades y sucursales
*contenedor = nombre id de contenedor select
*idUnidadActual = id de la unidad actual para que al entrar al modulo muestre por default la unidad en la que se encuentra
*/
function muestraSelectTodasUnidades(contenedor,idUnidadActual)
{
    
    $.ajax({

        type: 'POST',
        url: 'php/combos_buscar.php',
        dataType:"json", 
        data:{

            'tipoSelect' : 'TODAS_UNIDADES_NEGOCIO'

        },
        success: function(data) {
          var datos = data;
            if(datos.length > 0)
            {
                var html='';
                html='<option value="" selected disabled >Selecciona</option>';
                
                for (i = 0; i < datos.length; i++) {
                    html+='<option value="'+datos[i].id_unidad+'" label="'+datos[i].logo+'">'+datos[i].nombre_unidad+'</option>';     
                }
                $("#"+contenedor).html(html);
            }

            $('#'+contenedor).val(idUnidadActual);

            $("#"+contenedor).select2({
            templateResult: setCurrency,
            templateSelection: setCurrency
            });

            $('.img-flag').css({'width':'50px','height':'20px'});
        },
        error: function (xhr) {
            console.log("muestraSelectTodasUnidades: "+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información en cat_unidades negocio');
        }
 });
}

function muestraProveedoresUnidad(idSelect, idUnidad)
{

    $('#'+idSelect).select2();

    $('#'+idSelect).html('');
    var html='<option selected disabled>Elige un Proveedor</option>';
    $('#'+idSelect).append(html);

    $.ajax({

            type: 'POST',
            url: 'php/combos_buscar.php',
            dataType:"json", 
            data:{

                'tipoSelect' : 'PROVEEDORES_UNIDAD',
                'idUnidad' : idUnidad,

            },
            success: function(data)
            {

                if(data != 0)
                {

                    var arreglo=data;
                    for(var i=0;i<arreglo.length;i++)
                    {
                        var dato=arreglo[i];
                        var html="<option value="+dato.id+">"+dato.nombre+"</option>";
                        $('#'+idSelect).append(html);
                    }

                }

            },
            error: function (xhr) {
                console.log("muestraProcesosUnidad: "+JSON.stringify(xhr));    
                mandarMensaje('* No se encontró información de Proveedores Unidad de Negocio');
            }
     });
}

function formatearNumeroCSS(valor)
{

  var valII = valor.split(".");
  return "<label style='font-size:13px'>" + formatearSinD(valII[0]) + ".</label><label style='vertical-align: top'>" + valII[1] + "</label>";

}

function formatearSinD(valor)
        {

    
          valor = valor.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
          return valor;
          //return parseFloat(valor).toFixed(0);
        }
        
/*
Crea combo de paises, por default muestra México id_pais 141
*contenedor = nombre id de contenedor select
*/
function muestraSelectPaises(contenedor){

    $('#'+contenedor).select2();

    $('#'+contenedor).html('');
    var html='';
    html='<option value="" disabled>Selecciona</option>';
    $('#'+contenedor).append(html);

    $.ajax({

            type: 'POST',
            url: 'php/combos_buscar.php',
            dataType:"json", 
            data:{
                'tipoSelect' : 'PAISES'
            },
            success: function(data) {
               
                if(data!=0){

                    var arreglo=data;
                    for(var i=0;i<arreglo.length;i++){
                        var dato=arreglo[i];
                           
                        if(dato.id == 141)
                        {
                            var o_mexico='selected';
                        }else{
                            var o_mexico='';
                        }
                        html+='<option value="'+dato.id+'" '+o_mexico+'>'+dato.pais+'</option>';
                    }
                    $('#'+contenedor).html(html);

                }

            },
            error: function (xhr) {
                console.log("muestraSelectPaises: "+JSON.stringify(xhr));    
                mandarMensaje('* No se encontró información de Paises');
            }
     });
}

/*
Crea combo de estados
*contenedor = nombre id de contenedor select
*/
function muestraSelectEstados(contenedor){
    $('#'+contenedor).select2();

    $('#'+contenedor).html('');
    html='<option value="" disabled selected>Selecciona</option>';
    $('#'+contenedor).append(html);

    $.ajax({

            type: 'POST',
            url: 'php/combos_buscar.php',
            dataType:"json", 
            data:{
                'tipoSelect' : 'ESTADOS'
            },
            success: function(data) {
               
                if(data!=0){

                    var arreglo=data;
                    for(var i=0;i<arreglo.length;i++){
                        var dato=arreglo[i];
                        
                        html+='<option value="'+dato.id+'">'+dato.estado+'</option>';
                    }
                    $('#'+contenedor).html(html);

                }

            },
            error: function (xhr) {
                console.log("muestraSelectEstados: "+JSON.stringify(xhr));    
                mandarMensaje('* No se encontró información de Estados');
            }
    });
}

/*
Crea combo de estados
*contenedor = nombre id de contenedor select
*id_estado = id cat_estados al que pertenece el municipio
si cambia el combo de estados se actualiza el combo de municipios
*/
function muestraSelectMunicipios(contenedor,idEstado){
    $('#'+contenedor).select2();

    $('#'+contenedor).html('');
    var html='';
    html='<option value="" disabled selected>Selecciona</option>';
    $('#'+contenedor).append(html);

    $.ajax({

        type: 'POST',
        url: 'php/combos_buscar.php',
        dataType:"json", 
        data:{
            'tipoSelect' : 'MUNICIPIOS',
            'idEstado': idEstado
        },
        success: function(data) {
            
            if(data!=0){

                var arreglo=data;
                for(var i=0;i<arreglo.length;i++){
                    var dato=arreglo[i];
                    
                    html+='<option value="'+dato.id+'">'+dato.municipio+'</option>';
                }
                $('#'+contenedor).html(html);

            }

        },
        error: function (xhr) {
            console.log("muestraSelectMunicipios: "+JSON.stringify(xhr));    
            mandarMensaje('* No se encontró información de Municipios');
        }
    });
}

/*
Limpia combo de paises, estados y municipios
*idSelectPais = nombre id de select paises
*isSelectEstado = nombre id de select estados
*idSelectMunicipio = nombre id de select municipios
*/
function limpiaSelectPaisesEstadosMunicipios(idSelectPais,isSelectEstado,idSelectMunicipio){
    $('#'+idSelectPais).val(141);
    $('#'+idSelectPais).select2({placeholder: $(this).data('elemento')});

    $('#'+isSelectEstado).val('');
    $('#'+isSelectEstado).select2({placeholder: 'Selecciona'});

    $('#'+idSelectMunicipio).val('');
    $('#'+idSelectMunicipio).select2({placeholder: 'Selecciona'});
}

function muestraModalProveedoresUnidades(renglon, tabla, modal, idUnidad)
{
  
    $('.'+renglon).remove();

    $.ajax({
        type: 'POST',
        url: 'php/proveedores_buscar_unidades.php',
        dataType:"json", 
        data:{'id_unidad': idUnidad},  //los activos
        success: function(data)
        {
        
           
            if(data.length != 0)
            {

                $('.'+renglon).remove();
        
                for(var i=0;data.length>i;i++)
                {

                    ///llena la tabla con renglones de registros
                    var html='<tr class="'+renglon+'" alt="'+data[i].id+'" alt2="'+data[i].nombre+'" alt3="'+data[i].rfc+'">\
                                <td data-label="Proveedor" style="text-align:left;">' + data[i].nombre+ '</td>\
                                <td data-label="RFC">' + data[i].rfc+ '</td>\
                            </tr>';
                    ///agrega la tabla creada al div 
                    $('#'+tabla).append(html);   
                    $('#'+modal).modal('show');   
                }

            }
            else
                mandarMensaje('No se encontró información');

        },
        error: function (xhr) {
            console.log('proveedores_buscar.php --> '+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Proveedores de Unidad de Negocio');
        }
    });
}

/*
Busca el id de la sucursal actual en la que se encuentra, para el caso de que entre
a la unidad general que es corporativo
*idInput  nombre ide del input donde almacenaremos el idSucursal generica
*idUnidadNegocio  es el id de la unidad actual en session
*modulo nombre de la forma en la que se encuentra
*idUsuario  id del usuario que inicio session
*/
function muestraSucursalCorporativo(idInput,idUnidadNegocio,modulo,idUsuario){
    $.ajax({

        type: 'POST',
        url: 'php/combos_buscar.php',
        dataType:"json", 
        data:{

            'tipoSelect' : 'PERMISOS_SUCURSALES',
            'idUnidadNegocio' : idUnidadNegocio,
            'modulo' : modulo,
            'idUsuario' : idUsuario

        },
        success: function(data) {
            
            $('#'+idInput).val(data[0].id_sucursal);
            var idSucursal = data[0].id_sucursal;
            verificarPermisos(idUsuario,idSucursal,idUnidadNegocio);
        },
        error: function (xhr) {
            console.log("muestraSucursalCorporativo: "+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información Sucursal Corporativo');
        }
    });
}



/*
Verifica si el usuario tiene permiso de dar click al boton de la forma en la unidad y sucursal
*idInput  nombre ide del input donde almacenaremos el idSucursal generica
*idUnidadNegocio  es el id de la unidad actual en session
*idUsuario  id del usuario que inicio session
*/
function verificarPermisos(idUsuario,idSucursal,idUnidadNegocio){
   
    $(document).find('.verificar_permiso').each(function(){
        
        var boton = $(this).attr('alt');
        var idBoton = $(this).attr('id');
       
        $.ajax({

            type: 'POST',
            url: 'php/permisos_botones_buscar.php', 
            data:{
                'idUsuario' : idUsuario,
                'boton':boton,
                'idBoton':idBoton,
                'idSucursal':idSucursal,
                'idUnidadNegocio':idUnidadNegocio
            },
            success: function(data) {
                
                if(data==1){
                    $('#'+idBoton).prop('disabled',false);
                    
                    if(idBoton == 'b_aprobar_cotizacion'){
                        $('#div_comision_cotizacion div').css('display','inline-block'); 
                        $('#div_comision_resumen').css('display','inline-block');
                    }
                }else{
                    $('#'+idBoton).prop('disabled',true);
                }
    
            },
            error: function (xhr) {
                console.log("verificarPermisos: "+JSON.stringify(xhr));
                mandarMensaje('* No se encontró información al verificar permisos');
            }
        });
    });
}

/* Funcion que muestra solo las sucursales a las que tiene permiso para un modulo especifico 
sin importar la unidad de negocio*/
function muestraSucursalesPermisoUsuario(idSelect,modulo,idUsuario){

    $('#'+idSelect).select2();

    $('#'+idSelect).html('');
    var html='<option selected disabled>Elige una Sucursal</option>';
    $('#'+idSelect).append(html);
    
    $.ajax({

            type: 'POST',
            url: 'php/combos_buscar.php',
            dataType:"json", 
            data:{

                'tipoSelect' : 'PERMISOS_SUCURSALES_USUARIO',
                'modulo' : modulo,
                'idUsuario' : idUsuario

            },
            success: function(data) {
               console.log(data);
                if(data!=0){

                    var arreglo=data;
                    for(var i=0;i<arreglo.length;i++){
                        var dato=arreglo[i];
                           
                        var html="<option value="+dato.id_sucursal+">"+dato.nombre+"</option>";
                        $('#'+idSelect).append(html);
                    }

                }

            },
            error: function (xhr) {
                 console.log("muestraSucursalesPermisoUsuario: "+JSON.stringify(xhr));
                mandarMensaje('* No se encontró información de Sucursales Permiso por Usuario');
            }
    });
}

/*Muestra modal con registros de proveedores
* renglon  nombre clase del renglon que se va a crear
* tabla  id de la tabla con tbody a donde se vana a agregar los renglones
* modal  id del modal que se va a mostrar
*/ 
function muestraModalProveedores(renglon,tabla,modal){
  
    $('.'+renglon).remove();

    $.ajax({
        type: 'POST',
        url: 'php/proveedores_buscar.php',
        dataType:"json", 
        data:{'estatus':0},  //los activos
        success: function(data) {
        
        if(data.length != 0){

                $('.'+renglon).remove();
        
                for(var i=0;data.length>i;i++){

                    ///llena la tabla con renglones de registros
                    var html='<tr class="'+renglon+'" alt="'+data[i].id+'" alt2="'+data[i].nombre+'">\
                                <td data-label="Proveedor" style="text-align:left;">' + data[i].nombre+ '</td>\
                                <td data-label="RFC">' + data[i].rfc+ '</td>\
                            </tr>';
                    ///agrega la tabla creada al div 
                    $('#'+tabla).append(html);   
                    $('#'+modal).modal('show');   
                }
        }else{

                mandarMensaje('No se encontró información');
        }

        },
        error: function (xhr) {
            console.log('proveedores_buscar.php --> '+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Proveedores');
        }
    });
}

function redondear(v)
{
     var d = 2;
    return (Math.floor(v * Math.pow(10, d)) / Math.pow(10, d)).toFixed(d);
}

///*************CALCULA LA FECHA DE HOY */
function addZ(n){return n<10? '0'+n:''+n;}
var dias =['Domingo',"Lunes","Martes",'Miércoles','Jueves','Viernes','Sábado'];
var meses =['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
var aux = new Date();
var fecha = aux.getFullYear()+'-'+addZ(aux.getMonth()+1)+'-'+addZ(aux.getDate());
var hoy = aux.getFullYear()+'-'+addZ(aux.getMonth()+1)+'-'+addZ(aux.getDate());

var primerDia = new Date(aux.getFullYear(), aux.getMonth(), 1);
var ultimoDia = new Date(aux.getFullYear(), aux.getMonth() + 1, 0);

var anio = aux.getFullYear();

var primerDiaMes = aux.getFullYear()+'-'+addZ(aux.getMonth()+1)+'-'+addZ(primerDia.getDate());
var ultimoDiaMes = aux.getFullYear()+'-'+addZ(aux.getMonth()+1)+'-'+addZ(ultimoDia.getDate());

function restarDias(fecha, dias){
    fecha.setDate(fecha.getDate() - dias);
    return fecha.getFullYear()+'-'+addZ(fecha.getMonth()+1)+'-'+addZ(fecha.getDate());
}

function sumarDias(fecha, dias){
    fecha.setDate(fecha.getDate() + dias);
    return fecha.getFullYear()+'-'+addZ(fecha.getMonth()+1)+'-'+addZ(fecha.getDate());
}


    var div_alert='<div class="modal fade" id="modal_ayuda" tabindex="-1" role="dialog" aria-labelledby="modal_label_ayuda" aria-hidden="true">\
                        <div class="modal-dialog">\
                            <div class="modal-content">\
                                <div class="modal-header">\
                                <h4 class="modal-title" id="modal_label_ayuda"> Ayuda</h4>\
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
                                </div>\
                                <div class="modal-body table-responsive">\
                                <div id="texto_ayuda"></div>\
                                </div>\
                                <div class="modal-footer">\
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>\
                                </div>\
                            </div>\
                        </div>\
                    </div>';
    $('body').append(div_alert);
    $("#modal_ayuda").modal({'show':false});

function mostrarBotonAyuda(forma){
    $.ajax({
        type: 'POST',
        url: 'php/ayuda_modal_buscar_boton.php',
        dataType:"json", 
        data:{'pantalla': forma}, 
        success: function(data)
        {
                    
            for(var i=0;data.length>i;i++)
            {
                var boton_a='<span class="boton_modal_ayuda" id="boton_ayuda" alt="'+forma+'" alt2="'+data[i].boton+'" aria-hidden="true"><i class="fa fa-question-circle" aria-hidden="true"></i></span>';
                
                $('body').append(boton_a);
            }

        },
        error: function (xhr) {
            console.log('php/ayuda_modal_buscar_boton.php --> '+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de boton ayuda');
        }
    });
}

$(document).on('click','#boton_ayuda',function(){ 
    var forma = $(this).attr('alt'); 
    var boton = $(this).attr('alt2'); 
    $('#texto_ayuda').empty();
    $.ajax({
        type: 'POST',
        url: 'php/ayuda_modal_buscar_texto.php',
        dataType:"json", 
        data:{'pantalla': forma,
              'boton':boton}, 
        success: function(data)
        {        
            for(var i=0;data.length>i;i++)
            {
                var texto='<p>'+data[i].texto+'</p>';

                $("#texto_ayuda").html(texto);
                $("#modal_ayuda").modal("show");  
            }

        },
        error: function (xhr) {
            console.log('php/ayuda_modal_buscar_texto.php --> '+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Ayuda');
        }
    });
});

function checkForSession()
{
    $.ajax({
        type: "POST",
        url: "php/verifica_session_tiempo.php",
        cache: false,
        success: function(res)
        {
            console.log('res: '+res);
            if(res == 0)
            {
                var fondo_cargando='<div id="d_marco" style="position:absolute;top:0%; left:0%; width: 100%;background-color:rgba(4,5,5,.3); bottom:0%; z-index: 0; border-radius:5px;margin-bottom: -800px;padding-bottom: 800px; overflow: hidden;"> </div>\
                                    <div class="container-fluid" id="div_session_off" style="padding-top:100px;">\
                                        <div class="row">\
                                            <div class="col-sm-12 col-md-12" style="text-align:center;">\
                                            <img src="../imagenes/logoGinther2.png" width="300px"/>\
                                            </div>\
                                        </div>\
                                        <br>\
                                        <div class="row">\
                                            <div class="col-sm-12 col-md-12" style="text-align:center;">\
                                                <h1>Se perdió la sesión</h1>\
                                            </div>\
                                        </div>\
                                        <br>\
                                        <div class="row">\
                                            <div class="col-sm-12 col-md-5"></div>\
                                            <div class="col-sm-12 col-md-2">\
                                                <a href="php/logout.php" type="button" class="btn btn-dark btn-sm form-control" id="b_iniciar_session"> Iniciar Sesión <i class="fa fa-sign-in" aria-hidden="true"></i></a>\
                                            </div>\
                                        </div>\
                                    </div>';
                $('body').empty().append(fondo_cargando).css('background-image','url("../imagenes/fondo_login.jpg")');
            }
            
        }
    });
}

/* Funcion que muestra solo las sucursales a las que tiene permiso para un modulo especifico*/
function muestraSucursalesPermisoListaId(idUnidadNegocio,modulo,idUsuario){
    var lista='';
    $.ajax({
        type: 'POST',
        url: 'php/combos_buscar.php',
        data:{
            'tipoSelect' : 'PERMISOS_SUCURSALES_LISTA_ID',
            'idUnidadNegocio' : idUnidadNegocio,
            'modulo' : modulo,
            'idUsuario' : idUsuario
        },
        async: false, //-->quita asincrono para que pueda returnar el valor cuando ya se haya terminado el proceso ajax
        success: function(data) {
            lista = data;
        },
        error: function (xhr) {
            console.log("muestraSucursalesPermisoListaId: "+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Sucursales Permiso Lista Id');
        }
    });
    return lista;
}

/*
Verifica si el usuario tiene permiso de un boton especifico de la forma en la unidad y sucursal
*idInput  nombre ide del input donde almacenaremos el idSucursal generica
*idUnidadNegocio  es el id de la unidad actual en session
*idUsuario  id del usuario que inicio session
*/
function verificarPermisoBoton(idBoton,idUsuario,idSucursal,idUnidadNegocio){
        
        var boton = $('#'+idBoton).attr('alt');
        
        $.ajax({

            type: 'POST',
            url: 'php/permisos_botones_buscar.php', 
            data:{
                'idUsuario' : idUsuario,
                'boton':boton,
                'idBoton':idBoton,
                'idSucursal':idSucursal,
                'idUnidadNegocio':idUnidadNegocio
            },
            success: function(data) {
                
                if(data==1){
                    $('#'+idBoton).prop('disabled',false);
                }else{
                    $('#'+idBoton).prop('disabled',true);
                }
    
            },
            error: function (xhr) {
                console.log("verificarPermisos: "+JSON.stringify(xhr));
                mandarMensaje('* No se encontró información al verificar permisos');
            }
        });
}

function muestraUnidadesTodas(contenedor, idUnidadActual)
{

    $.ajax({

            type: 'POST',
            url: 'php/combos_buscar.php',
            dataType:"json", 
            data:{
                'tipoSelect' : 'UNIDADES_TODAS'
            },
            success: function(data)
            {


                //if(data.length > 0)
                //{

                  var html = '';
                  html = '<option value="" selected disabled >Selecciona</option>';
                 
                  for (i = 0; i < data.length; i++)
                  { 
                    html += '<option value="' + data[i].id_unidad + '" label="' + data[i].logo + '">' + data[i].nombre_unidad + '</option>';     
                  }

                  $("#" + contenedor).html(html);

                //}

                $('#' + contenedor).val(idUnidadActual);

                $("#" + contenedor).select2({
                  templateResult: setCurrency,
                  templateSelection: setCurrency
                });

                $('.img-flag').css({'width':'50px','height':'20px'});

                /*var arreglo=data;
                for(var i=0;i<arreglo.length;i++){
                    var dato=arreglo[i];
                    
                    var html="<option value="+dato.id_sucursal+">"+dato.nombre+"</option>";
                    $('#'+idSelect).append(html);

                }*/

            },
            error: function (xhr) {
                console.log("muestraSucursalesPermiso: "+JSON.stringify(xhr));
                mandarMensaje('El sistema encontró un error al realizar la búsqueda de  la información correspondiente, si persiste el comportamiento notificar al área de sistemas ');
            }
     });

}

/*Genera combo de meses*/
function generaFecha(idSelect){
    var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

    $('#'+idSelect).select2();
    $('#'+idSelect).html('');
    var html = '<option selected disabled>Selecciona</option>';
    $('#'+idSelect).append(html);

    //var d = new Date();
    //var monthC = d.getMonth() + 1;

    for(var i = 0; i < meses.length; i++)
    {
        var actual = meses[i];
         
        var html = "<option value=" + (i + 1) + ">" + actual + "</option>";
        $('#'+idSelect).append(html);

    }
}

function nombreMes(num_mes){
    var mes='';
    switch(parseInt(num_mes)){
        case 1:
            mes = 'Enero';
        break;
        case 2:
            mes = 'Febrero';
        break;
        case 3:
            mes = 'Marzo';
        break;
        case 4:
            mes = 'Abril';
        break;
        case 5:
            mes = 'Mayo';
        break;
        case 6:
            mes = 'Junio';
        break;
        case 7:
            mes = 'Julio';
        break;
        case 8:
            mes = 'Agosto';
        break;
        case 9:
            mes = 'Septiembre';
        break;
        case 10:
            mes = 'Octubre';
        break;
        case 11:
            mes = 'Noviembre';
        break;
        default:
            mes= 'Diciembre';
        break;
    }

    return mes;
}

function soloNumero(evt)
{

    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
    {
        return false;
    }

    return true;

}


function fechaHoyServidor(idInput,dia){
 
    $.ajax({

        type: 'POST',
        url: 'php/obtener_fecha_hoy.php',
        data:{
            'dia' :dia
        },
        async: false,
        success: function(data)
        { 
            $('#'+idInput).val(data);
        },
        error: function (xhr) {
           
            console.log("obtener_fecha_hoy: "+JSON.stringify(xhr));    
            mandarMensaje('*Error al traer la fecha hoy');
        }
    });
}

function validateDecimalKeyPressN(el, evt, totalD) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    var number = el.value.split('.');
    totalD = totalD -1;
    
    //console.log(charCode);

    if (charCode != 46 && charCode != 44 && charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    //just one dot (thanks ddlab)
    if(number.length>1 && charCode == 46)
         return false;
    
    //get the carat position
    var caratPos = getSelectionStart(el);
    var dotPos = el.value.indexOf(".");
    console.log(caratPos);
    if( caratPos > dotPos && dotPos>-1 && (number[1].length > totalD))
        return false;

    return true;

}

function getSelectionStart(o) 
{
    if (o.createTextRange)
    {

        var r = document.selection.createRange().duplicate()
        r.moveEnd('character', o.value.length)
        if (r.text == '') return o.value.length
            return o.value.lastIndexOf(r.text)

    }
    else 
        return o.selectionStart

}


$(document).on('mousedown','.btn,.menu_clic',function(e){

    var id= $(this).attr('id');
    if(id != 'b_regresar_portal' && id != 'b_detalle_proveedor_portal' && id != 'b_buscar_proveedor_portal' && id != 'b_login' && id != 'b_cerrar_modal_d_p_portal' && id != 'b_iniciar_session' 
    && id!='b_crear_cuenta' && id!='b_olvide_contrasena' && id!='b_guardar_cuenta' && id!='b_regresar_inicio' && id != 'b_buscar_razon_social_emisora' )
    {
        
        //var id_personal=window.parent.document.getElementById('#i_id_personal');
        
        $.post('php/verifica_session.php',function(data){
            console.log("resutado del boton:"+data);
            if (data==0){
                var fondo_cargando='<div id="d_marco" style="position:absolute;top:0%; left:0%; width: 100%;background-color:rgba(4,5,5,.3); bottom:0%; z-index: 0; border-radius:5px;margin-bottom: -800px;padding-bottom: 800px; overflow: hidden;"> </div>\
                                    <div class="container-fluid" id="div_session_off" style="padding-top:100px;">\
                                        <div class="row">\
                                            <div class="col-sm-12 col-md-12" style="text-align:center;">\
                                            <img src="../imagenes/logoGinther2.png" width="300px"/>\
                                            </div>\
                                        </div>\
                                        <br>\
                                        <div class="row">\
                                            <div class="col-sm-12 col-md-12" style="text-align:center;">\
                                                <h1>Se perdió la sesión</h1>\
                                            </div>\
                                        </div>\
                                        <br>\
                                        <div class="row">\
                                            <div class="col-sm-12 col-md-5"></div>\
                                            <div class="col-sm-12 col-md-2">\
                                                <a href="php/logout.php" type="button" class="btn btn-dark btn-sm form-control" id="b_iniciar_session"> Iniciar Sesión <i class="fa fa-sign-in" aria-hidden="true"></i></a>\
                                            </div>\
                                        </div>\
                                    </div>';
                $('body').empty().append(fondo_cargando).css('background-image','url("../imagenes/fondo_login.jpg")');
            }
        }); 
    }
});

/***utf8_to_b64 se codifican los datos a enviar */
function datosUrl( str ) {
    return btoa(unescape(encodeURIComponent( str )));
}
