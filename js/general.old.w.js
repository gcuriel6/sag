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
            <button type="button" class="btn btn-primary" id="b_aceptar" data-dismiss="modal">Aceptar</button>\
            </div>\
        </div>\
        </div>\
    </div>';
    $('body').append(dialogo);
    $("#modal_alerta").modal({'show':false});

    //---------------------------Modal de alerta para funcion mandarMensajeConfimacion()
    var dialogo2 = '<div class="modal fade bd-example-modal-sm" tabindex="-1" aria-labelledby="mySmallModalLabel" id="modal_alerta2" role="dialog" data-backdrop="static" data-keyboard="false">\
        <div class="modal-dialog modal-sm" role="document">\
        <div class="modal-content">\
            <div class="modal-header">\
            <h5 class="modal-title">Mensaje del sistema</h5>\
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
$(document).on('click','input,checkbox,textarea',function(){
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

/*
Crea el combo select con imagen de las unidades de negoio a las que tiene acceso el usuario
por default muestra la de la unidad actual
*datos = arrar de unidades y sucursales
*contenedor = nombre id de contenedor select
*idUnidadActual = id de la unidad actual para que al entrar al modulo muestre por default la unidad en la que se encuentra
*/
function muestraSelectUnidades(datos,contenedor,idUnidadActual)
{
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
}

function setCurrency (currency) {
    if (!currency.id) { return currency.text; }
    var $currency = $('<span><img src="imagenes/'+currency.element.label+'" class="img-flag" style="width:70px; height:40px;"/> '+currency.text+'</span>');
    return $currency;
};


/*
Al cambiar las opciones del select unidades de negocio cambiamos el taaño de la imagen para que no sobrepase el combo
*/
$(document).on('change','#s_id_unidades',function(){
    if($('#s_id_unidades').val()!= ''){
        $('.img-flag').css({'width':'50px','height':'20px'});
    }
});


/* Funcion que muestra solo las sucursales a las que tiene permiso para un modulo especifico*/
function muestraSucursalesPermiso(idSelect,idUnidadNegocio,modulo,idUsuario){

    $('#'+idSelect).select2();

    $('#'+idSelect).html('');
    var html='<option selected disabled>Elige una Sucursal</option>';
    $('#'+idSelect).append(html);
    
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
               //console.log(data);
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
                console.log("muestraSucursalesPermiso: "+JSON.stringify(xhr));
                mandarMensaje('* No se encontró información de Sucursales Permiso');
            }
     });

}


/* Funcion que muestra solo las sucursales a las que tiene acceso para un modulo especifico*/
function muestraSucursalesAcceso(idSelect,idUnidadNegocio,idUsuario){

    $('#'+idSelect).select2();

    $('#'+idSelect).html('');
    var html='<option selected disabled>Elige una Sucursal</option>';
    $('#'+idSelect).append(html);

//alert(idUnidadNegocio + ' ** ' + idUsuario);

     $.ajax({

            type: 'POST',
            url: 'php/combos_buscar.php',
            dataType:"json", 
            data:{

                'tipoSelect' : 'ACCESOS_SUCURSALES',
                'idUnidadNegocio' : idUnidadNegocio,
                'idUsuario' : idUsuario
            },
            success: function(data) {
               console.log(JSON.stringify(data));
                if(data!=0)
                {

                    var arreglo=data;
                    for(var i=0;i<arreglo.length;i++){
                        var dato=arreglo[i];
                        
                        var html="<option value="+dato.id_sucursal+">"+dato.nombre+"</option>";
                        $('#'+idSelect).append(html);

                    }
                }


            },
            error: function (xhr) {
                console.log("muestraSucursalesAcceso: "+JSON.stringify(xhr));    
                mandarMensaje('* No se encontró información de Sucursales Acceso');
            }
     });

}

/*
* Esta función muestra las areas, las cuales on genericas  y no van filtradas por nada
*/
function muestraAreasAcceso(idSelect, idSucursal)
{

    $('#'+idSelect).select2();

    $('#'+idSelect).html('');
    var html='<option selected disabled>Elige un área</option>';
    $('#'+idSelect).append(html);

    $.ajax({

            type: 'POST',
            url: 'php/combos_buscar.php',
            dataType:"json", 
            data:{

                'tipoSelect' : 'ACCESOS_AREAS',
                'id_sucursal': idSucursal

            },
            success: function(data)
            {


                if(data != 0)
                {

                    var arreglo=data;
                    for(var i=0;i<arreglo.length;i++)
                    {
                        var dato=arreglo[i];
                        var html="<option value="+dato.id+">"+dato.descripcion+"</option>";
                        $('#'+idSelect).append(html);
                    }

                }

            },
            error: function (xhr) {
                console.log("muestraAreasAcceso: "+JSON.stringify(xhr));    
                //mandarMensaje('* No se encontró información de Areas Acceso');
            }
     });
}

function muestraDepartamentoArea(idSelect, idSucursal, idArea)
{

   
    $('#'+idSelect).select2();

    $('#'+idSelect).html('');
    var html='<option selected disabled>Elige una Departamento</option>';
    $('#'+idSelect).append(html);

    if(parseInt(idSucursal)>0 && parseInt(idArea)>0){

    
        $.ajax({

                type: 'POST',
                url: 'php/combos_buscar.php',
                dataType:"json", 
                data:{

                    'tipoSelect' : 'DEPARTAMENTOS_AREA',
                    'idSucursal': idSucursal,
                    'idArea': idArea 

                },
                success: function(data)
                {
                    

                    if(data != 0)
                    {

                        var arreglo=data;
                        for(var i=0;i<arreglo.length;i++)
                        {
                            var dato=arreglo[i];
                            var html="<option value="+dato.id_depto+">"+dato.des_dep+"</option>";
                            $('#'+idSelect).append(html);
                        }

                    }

                },
                error: function (xhr) {
                    console.log("muestraDepartamentoArea: "+JSON.stringify(xhr));    
                    mandarMensaje('* No se encontró información de Departamentos');
                }
        });
    }
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


/*
Crea combo de departamentos
*contenedor = nombre id de contenedor select
*idSucursal = id_sucursal  a las que se tiene acceso para este combo 
*por dafault se seleciona solo los departamentos de secorp
*/
function muestraSelectDepartamentos(contenedor,idSucursal){
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
            'tipoSelect' : 'DEPARTAMENTOS',
            'idSucursal': idSucursal
        },
        success: function(data) {
            
            if(data!=0){

                var arreglo=data;
                for(var i=0;i<arreglo.length;i++){
                    var dato=arreglo[i];
                    
                    html+='<option value="'+dato.id+'" alt="'+dato.clave+'">'+dato.descripcion+'</option>';
                }
                $('#'+contenedor).html(html);

            }

        },
        error: function (xhr) {
            console.log("muestraSelectDepartamentos: "+JSON.stringify(xhr));    
            mandarMensaje('* No se encontró información de Departamentos');
        }
    });
}
/***Muestra solo los aprobados y activos */
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

/*
Crea combo de Puestos
*contenedor = nombre id de contenedor select
*/
function muestraSelectPuestos(contenedor){
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
            'tipoSelect' : 'PUESTOS'
        },
        success: function(data) {
            //console.log(data);
            if(data!=0){

                var arreglo=data;
                for(var i=0;i<arreglo.length;i++){
                    var dato=arreglo[i];
                    
                    html+='<option value="'+dato.id_puesto+'">'+dato.puesto+'</option>';
                }
                $('#'+contenedor).html(html);

            }

        },
        error: function (xhr) {
            console.log("muestraSelectPuestos: "+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Puestos');
        }
    });
}

/*
Crea combo de Firmantes
*contenedor = nombre id de contenedor select
*/
function muestraSelectFirmantes(contenedor){
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
            'tipoSelect' : 'FIRMANTES'
        },
        success: function(data) {
            //console.log(data);
            if(data!=0){

                var arreglo=data;
                for(var i=0;i<arreglo.length;i++){
                    var dato=arreglo[i];
                    
                    html+='<option value="'+dato.id+'">'+dato.nombre+'</option>';
                }
                $('#'+contenedor).html(html);

            }

        },
        error: function (xhr) {
            console.log("muestraSelectFirmantes: "+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Combo Firmantes');
        }
    });
}


/*
Crea el combo select con imagen de las unidades de negoio a las que tiene acceso el usuario 
*contenedor = nombre id de contenedor select
*idUnidadActual = id de la unidad actual para que al entrar al modulo muestre por default la unidad en la que se encuentra
*/
function muestraSelectUnidadesAcceso(contenedor,idUnidadActual,idUsuario){
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
            'tipoSelect' : 'UNIDADES_NEGOCIO_ACCESO',
            'idUsuario'  : idUsuario
        },
        success: function(datos) {
            console.log(datos);
            if(datos!=0){

                var html='';
                html='<option value="" selected disabled >Selecciona</option>';
                 
                for (i = 0; i < datos.length; i++) {
                    
                    html+='<option value="'+datos[i].id_unidad+'" label="'+datos[i].logo+'">'+datos[i].nombre_unidad+'</option>';     
                }

                $("#"+contenedor).html(html);

                }

                //$('#'+contenedor).val(idUnidadActual);

                $("#"+contenedor).select2({
                  templateResult: setCurrency,
                  templateSelection: setCurrency
                });

                $('.img-flag').css({'width':'50px','height':'20px'});

                 //muestraSucursalesPermiso('s_id_sucursal',1,modulo,id);

                 },
        error: function (xhr) {
             console.log("muestraSelectUnidadesAcceso: "+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Unidades de Negocio Acceso');
        }
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

/*Función que muestra los salarios puestos de una unidad de negocio*/
function muestraSelectSalariosPuestos(contenedor,idUnidadNegocio,idSucursal){
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
            'tipoSelect' : 'SALARIOS',
            'idUnidadNegocio' : idUnidadNegocio,
            'idSucursal' : idSucursal
        },
        success: function(data) {
            
            if(data!=0){

                var arreglo=data;
                for(var i=0;i<arreglo.length;i++){
                    var dato=arreglo[i];
                    
                    html+='<option value="'+dato.id+'">'+dato.puesto+' - $'+dato.sueldo_mensual+'</option>';
                }
                $('#'+contenedor).html(html);

            }

        },
        error: function (xhr) {
            console.log("combos_buscar.php SALARIOS -->: "+JSON.stringify(xhr));    
            mandarMensaje('* No se encontró información de Salarios Puestos');
        }
    });
}

/*Muestra modal con registros de empresas fiscales que estan activas no importa si van a facturar
* renglon  nombre clase del renglon que se va a crear
* tabla  id de la tabla con tbody a donde se vana a agregar los renglones
* modal  id del modal que se va a mostrar
*/ 
function muestraModalEmpresasFiscales(renglon,tabla,modal){
    $('.'+renglon).remove();

    $.ajax({
        type: 'POST',
        url: 'php/empresas_fiscales_buscar.php',
        dataType:"json", 
        success: function(data) {
        
        if(data.length != 0){

                $('.'+renglon).remove();
        
                for(var i=0;data.length>i;i++){

                    ///llena la tabla con renglones de registros
                    var html='<tr class="'+renglon+'" alt="'+data[i].id_empresa+'" alt2="'+data[i].razon_social+'" alt3="'+data[i].id_cfdi+'">\
                                <td data-label="Razón Social" style="text-align:left;">' + data[i].razon_social+ '</td>\
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
            console.log('empresas_fiscales_buscar.php --> '+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Empresas Fiscales');
        }
    });
}

function muestraModalEmpresasFiscalesCuotas(renglon,tabla,modal){
    $('.'+renglon).remove();

    $.ajax({
        type: 'POST',
        url: 'php/empresas_fiscales_cuotas_buscar.php',
        dataType:"json", 
        success: function(data) {
        
        if(data.length != 0){

                $('.'+renglon).remove();
        
                for(var i=0;data.length>i;i++){

                    ///llena la tabla con renglones de registros
                    var html='<tr class="'+renglon+'" alt="'+data[i].id_empresa+'" alt2="'+data[i].razon_social+'" alt3="'+data[i].id_cfdi+'">\
                                <td data-label="Razón Social" style="text-align:left;">' + data[i].razon_social+ '</td>\
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
            console.log('empresas_fiscales_buscar.php --> '+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Empresas Fiscales');
        }
    });
}

/*Muestra modal con registros de firmantes que pertenecen a la unidad de negocio y sucursal
* renglon  nombre clase del renglon que se va a crear
* tabla  id de la tabla con tbody a donde se vana a agregar los renglones
* modal  id del modal que se va a mostrar
* idUnidadNegocio que se selecciono
* idSucursal que se selecciono
*/ 
function muestraModalFirmantes(renglon,tabla,modal,idUnidadNegocio,idSucursal){
    $('.'+renglon).remove();

    $.ajax({
        type: 'POST',
        url: 'php/firmantes_buscar_idUnidad_idSucursal.php',
        dataType:"json", 
        data:{'idUnidadNegocio':idUnidadNegocio,'idSucursal':idSucursal}, //solo los activos
        success: function(data) {
        
        if(data.length != 0){

                $('.'+renglon).remove();
        
                for(var i=0;data.length>i;i++){

                    ///llena la tabla con renglones de registros
                    var html='<tr class="'+renglon+'" alt="'+data[i].id+'" alt2="'+data[i].nombre+'">\
                                <td data-label="Nombre" style="text-align:left;">' + data[i].nombre+ '</td>\
                                <td data-label="Iniciales">' + data[i].iniciales+ '</td>\
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
            console.log('firmantes_buscar_idUnidad_idSucursal.php --> '+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Firmantes');
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


 /**NIVELES INICIO**/
/*
<b>…</b>  texto en negrita
<i>…</i>  texto en cursiva
<u>…</u>  texto en subrayado
<center>…</center>  texto centrado   (para html5 no funciona)


[    nivel sin biñeta
|    nivel con biñeta a
||   doble nivel con biñeta b 
[|   nivel con biñeta a
[||  doble nivel con biñeta b

.replace(/\n/g, '<br />')
*/

var nivel_ant=1;
var nivel_act=0;
var pos_act=0;
var html_niv='';
var contador=0;

function niveles(dato_texto){
    html_niv='';
    nivel_ant=1,nivel_act=0,pos_act=0,contador=0;
    var txt_restante='';
    var txt_anterior='';
    txt_restante=dato_texto.trim();
                
    
    var letra='';
    letra = txt_restante.charAt(0);
    
    if(letra=='|'){
        
        pos_act=txt_restante.indexOf('|');
    }else if(letra=='['){
        
        pos_act=txt_restante.indexOf('[');
    }else{
        
        var pos_or=0,pos_co=0;
        pos_or=txt_restante.indexOf('|');
        pos_co=txt_restante.indexOf('[');
        
        var p_or=0,p_co=0;
        if(pos_or != -1){
            p_or=pos_or;
        }else{
            p_or=1;
        }
        
        if(pos_co != -1){
            p_co=pos_co;
        }else{
            p_co=1;
        }
        
        if(pos_or != -1 && pos_co != -1){
            
            if(p_or < p_co){
                pos_act=txt_restante.indexOf('|');
            }else{
                pos_act=txt_restante.indexOf('[');
            }
        }else{
            
            if(p_or > p_co){
                pos_act=txt_restante.indexOf('|');
            }else{
                pos_act=txt_restante.indexOf('[');
            }
        }
        
        
    }
    
        if(pos_act != -1){
            txt_anterior=txt_restante.substring(0,pos_act);
            html_niv+=txt_anterior;
            
            html_niv+="<ul>";
            
            txt_restante=txt_restante.substring(pos_act);
            
            while(txt_restante != ''){
                
                txt_restante=txt_restante.trim();
                
                var letra2='';
                letra2 = txt_restante.charAt(0);
                
                if(letra2=='|'){
                    pos_act=txt_restante.indexOf('|');
                    
                    var a='',b='',c='',nivel=0;
                    a=txt_restante.substring(0,1);
                    b=txt_restante.substring(1,2);
                    c=txt_restante.substring(2,3);
                    nivel=0;
                    if(a == '|'){
                        nivel++;
                    }
                    if(b == '|'){
                        nivel++;
                    }
                    if(c == '|'){
                        nivel++;
                    }
                }else{
                    pos_act=txt_restante.indexOf('[');
                    
                    var a='',b='',c='',nivel=0;
                    a=txt_restante.substring(0,1);
                    b=txt_restante.substring(1,2);
                    c=txt_restante.substring(2,3);
                    nivel=0;
                    if(a == '['){
                        nivel++;
                    }
                    if(b == '['){
                        nivel++;
                    }
                    if(c == '['){
                        nivel++;
                    }
                }
                
                nivel_act=nivel;
                
                if(nivel_ant == nivel_act){  
                    var busca_sig_or='';
                    busca_sig_or=txt_restante.substring(nivel_act);
                    
                    var letra3='';
                    letra3 = busca_sig_or.charAt(0);
                
                    var pos_sig_or=0;
                    if(letra3=='|'){
                        pos_sig_or=busca_sig_or.indexOf('|');
                    }else if(letra3=='['){
                        pos_sig_or=busca_sig_or.indexOf('[');
                    }else{
                        var pos_or=0,pos_co=0;
                        pos_or=busca_sig_or.indexOf('|');
                        pos_co=busca_sig_or.indexOf('[');
                        
                        var p_or=0,p_co=0;
                        if(pos_or != -1){
                            p_or=pos_or;
                        }else{
                            p_or=1;
                        }
                        
                        if(pos_co != -1){
                            p_co=pos_co;
                        }else{
                            p_co=1;
                        }

                        
                        if(pos_or != -1 && pos_co != -1){
                            
                            if(p_or < p_co){
                                pos_sig_or=busca_sig_or.indexOf('|');
                            }else{
                                pos_sig_or=busca_sig_or.indexOf('[');
                            }
                        }else{
                            
                            if(p_or > p_co){
                                pos_sig_or=busca_sig_or.indexOf('|');
                            }else{
                                pos_sig_or=busca_sig_or.indexOf('[');
                            }
                        }
                        
                    }
                    
                    if(pos_sig_or == -1){
                        txt_anterior=txt_restante.substring(nivel_act);
                        
                        if(nivel_act == 1){
                            
                            if(letra2=='|'){
                                
                                html_niv+='</li><li>'+txt_anterior+'</li>';   
                            }else{
                                
                                html_niv+='</li><li class="listas_niv_dos">'+txt_anterior+'</li>';   
                            }
                            
                        }else if(nivel_act == 2){
                            
                            if(letra2=='|'){
                                
                                html_niv+='</li><li>'+txt_anterior+'</li></ul></li>';  
                            }else{
                                
                                html_niv+='</li><li class="listas_niv_dos">'+txt_anterior+'</li></ul></li>';  
                            }	
                            
                        }else{
                        
                            if(letra2=='|'){
                                
                                html_niv+='</li><li>'+txt_anterior+'</li></ul></li></ul></li>';    
                            }else{
                                
                                html_niv+='</li><li class="listas_niv_dos">'+txt_anterior+'</li></ul></li></ul></li>';   
                            }
                        }
                        txt_restante='';
                    }else{
                        txt_anterior=txt_restante.substring(nivel_act,pos_sig_or+nivel_act);
                        
                        if(nivel_act == 1){

                            if(contador == 0){
                                if(letra2=='|'){
                                    
                                    html_niv+='<li>'+txt_anterior;  
                                }else{
                                    
                                    html_niv+='<li class="listas_niv_dos">'+txt_anterior;  
                                }
                                
                            }else{
                                if(letra2=='|'){
                                    html_niv+='</li><li>'+txt_anterior;   
                                }else{
                                    html_niv+='</li><li class="listas_niv_dos">'+txt_anterior;  
                                }
                            }
                            contador ++;
                            
                        }else if(nivel_act == 2){
                            
                            if(letra2=='|'){
                                
                                html_niv+='</li><li>'+txt_anterior;  
                            }else{
                                
                                html_niv+='</li><li class="listas_niv_dos">'+txt_anterior;  
                            }
                            
                        }else{
                            
                            if(letra2=='|'){
                                
                                html_niv+='</li><li>'+txt_anterior;  
                            }else{
                                
                                html_niv+='</li><li class="listas_niv_dos">'+txt_anterior;  
                            }
                        }
                        
                        txt_restante=txt_restante.substring(pos_sig_or+nivel_act);
                    }
                    
                }else if(nivel_ant < nivel_act){  

                    var busca_sig_or='';
                    
                    busca_sig_or=txt_restante.substring(nivel_act);

                    var letra4='';
                    
                    letra4 = busca_sig_or.charAt(0);
            
                    var pos_sig_or=0;

                    if(letra4=='|'){
                        pos_sig_or=busca_sig_or.indexOf('|');
                    }else if(letra4=='['){
                        pos_sig_or=busca_sig_or.indexOf('[');
                    }else{
                        var pos_or=0,pos_co=0;
                        pos_or=busca_sig_or.indexOf('|');
                        pos_co=busca_sig_or.indexOf('[');
                        
                        var p_or=0,p_co=0;

                        if(pos_or != -1){
                            p_or=pos_or;
                        }else{
                            p_or=1;
                        }
                        
                        if(pos_co != -1){
                            p_co=pos_co;
                        }else{
                            p_co=1;
                        }
                        

                        if(pos_or != -1 && pos_co != -1){
                            
                            if(p_or < p_co){
                                pos_sig_or=busca_sig_or.indexOf('|');
                            }else{
                                pos_sig_or=busca_sig_or.indexOf('[');
                            }
                        }else{
                            
                            if(p_or > p_co){
                                pos_sig_or=busca_sig_or.indexOf('|');
                            }else{
                                pos_sig_or=busca_sig_or.indexOf('[');
                            }
                        }
                        
                    }
                    
                    if(pos_sig_or == -1){
                        txt_anterior=txt_restante.substring(nivel_act);
                        
                        if((nivel_ant == 1) && (nivel_act == 2)){
                            
                            if(letra2=='|'){
                                
                                html_niv+='<ul><li>'+txt_anterior+'</li></ul></li>';  
                            }else{
                                
                                html_niv+='<ul><li class="listas_niv_dos">'+txt_anterior+'</li></ul></li>';   
                                
                            }
                            
                        }else if((nivel_ant == 1) && (nivel_act == 3)){
                            ////este nunca va  aocurrir porque no se puede pasar de nivel 1 al 3
                            if(letra2=='|'){
                                html_niv+='</ul></li><ul><li>'+txt_anterior+'</li></ul>';
                            }else{
                                html_niv+='</ul></li><ul><li class="listas_niv_dos">'+txt_anterior+'</li></ul>';
                                
                            }
                            
                        }else{
                            
                            if(letra2=='|'){
                                
                                html_niv+='<ul><li>'+txt_anterior+'</li></ul></li></ul></li></ul>';    
                                
                            }else{
                                
                                html_niv+='<ul><li class="listas_niv_dos">'+txt_anterior+'</li></ul></li></ul></li></ul>';  
                                
                            }
                        }  
                        txt_restante='';
                    }else{
                        txt_anterior=txt_restante.substring(nivel_act,pos_sig_or+nivel_act);
                        
                        if((nivel_ant == 1) && (nivel_act == 2)){
                            
                            if(letra2=='|'){
                                
                                html_niv+='<ul><li>'+txt_anterior;   
                                
                            }else{
                                
                                html_niv+='<ul><li class="listas_niv_dos">'+txt_anterior;  
                                
                            }
                            
                        }else if((nivel_ant == 1) && (nivel_act == 3)){
                            
                            if(letra2=='|'){
                                
                                html_niv+='<ul><li>'+txt_anterior;   
                                
                            }else{
                                
                                html_niv+='<ul><li class="listas_niv_dos">'+txt_anterior;    
                                
                            }
                            
                        }else{   
                            
                            if(letra2=='|'){
                                
                                html_niv+='<ul><li>'+txt_anterior;  
                                
                            }else{
                                
                                html_niv+='<ul><li class="listas_niv_dos">'+txt_anterior;   
                                
                            }
                        }
                        txt_restante=txt_restante.substring(pos_sig_or+nivel_act);
                    }
                    
                }else{  

                    var busca_sig_or='';

                    busca_sig_or=txt_restante.substring(nivel_act);
                    
                    var letra5='';
                    letra5 = busca_sig_or.charAt(0);
                    
                    var pos_sig_or=0;
                    if(letra5=='|'){
                        pos_sig_or=busca_sig_or.indexOf('|');
                    }else if(letra5=='|'){
                        pos_sig_or=busca_sig_or.indexOf('[');
                    }else{
                        var pos_or=0,pos_co=0;
                        pos_or=busca_sig_or.indexOf('|');
                        pos_co=busca_sig_or.indexOf('[');
                        
                        var p_or=0,p_co=0;
                        if(pos_or != -1){
                            p_or=pos_or;
                        }else{
                            p_or=1;
                        }
                        
                        if(pos_co != -1){
                            p_co=pos_co;
                        }else{
                            p_co=1;
                        }
                        
                        if(pos_or != -1 && pos_co != -1){
                            
                            if(p_or < p_co){
                                pos_sig_or=busca_sig_or.indexOf('|');
                            }else{
                                pos_sig_or=busca_sig_or.indexOf('[');
                            }
                        }else{
                            
                            if(p_or > p_co){
                                pos_sig_or=busca_sig_or.indexOf('|');
                            }else{
                                pos_sig_or=busca_sig_or.indexOf('[');
                            }
                        }
                        
                    }
                    
                    if(pos_sig_or == -1){
                        txt_anterior=txt_restante.substring(nivel_act);
                        
                        if((nivel_ant == 2) && (nivel_act == 1)){
                            
                            if(letra2=='|'){
                                
                                html_niv+='</li></ul></li><li>'+txt_anterior+'</li>'; 
                            
                            }else{
                                
                                html_niv+='</li></ul></li><li class="listas_niv_dos">'+txt_anterior+'</li>';    
                                
                            } 
                            
                        }else if((nivel_ant == 3) && (nivel_act == 1)){
                            
                            if(letra2=='|'){
                                
                                html_niv+='</li></ul></li></ul></li><li>'+txt_anterior+'</li>';  
                                
                            }else{
                                
                                html_niv+='</li></ul></li></ul></li><li class="listas_niv_dos">'+txt_anterior+'</li>';    
                            
                            }

                        }else{   
                            
                            if(letra2=='|'){
                                
                                html_niv+='</li></ul></li><li>'+txt_anterior+'</li></ul></li>';  
                                
                            }else{
                                
                                html_niv+='</li></ul></li><li class="listas_niv_dos">'+txt_anterior+'</li></ul></li>'; 
                                
                            }
                        }
                        txt_restante='';
                    }else{
                        txt_anterior=txt_restante.substring(nivel_act,pos_sig_or+nivel_act);
                        if((nivel_ant == 2) && (nivel_act == 1)){
                            
                            if(letra2=='|'){
                                
                                html_niv+='</li></ul></li><li>'+txt_anterior;  
                                
                            }else{
                                
                                html_niv+='</li></ul></li><li class="listas_niv_dos">'+txt_anterior;  
                                
                            }
                            
                        }else if((nivel_ant == 3) && (nivel_act == 1)){

                            
                            if(letra2=='|'){
                                
                                html_niv+='</li></ul></li></ul></li><li>'+txt_anterior;   
                                
                            }else{
                                
                                html_niv+='</li></ul></li></ul></li><li class="listas_niv_dos">'+txt_anterior;  
                                
                            }
                            
                        }else{   
                            
                            if(letra2=='|'){
                                
                                html_niv+='</li></ul></li><li>'+txt_anterior;     
                            
                            }else{
                                
                                html_niv+='</li></ul></li><li class="listas_niv_dos">'+txt_anterior;     ///YA
                                
                            }
                        }
                        txt_restante=txt_restante.substring(pos_sig_or+nivel_act);
                    }
                }
                nivel_ant=nivel;
            }
            
            html_niv+='</ul>';
            
        }else{
            
            html_niv+=txt_restante;
        }

        return html_niv;
}
/**NIVELES FIN**/

function redondear(v)
{
     var d = 2;
    return (Math.floor(v * Math.pow(10, d)) / Math.pow(10, d)).toFixed(d);
}


/*Busca los departamentos de una sucursal */
function muestraModalDepartamentosSucursal(renglon, tabla, modal, idSucursal){
    $('.'+renglon).remove();

    $.ajax({
        type: 'POST',
        url: 'php/departamentos_buscar_idSucursal.php',
        dataType:"json", 
        data:{'idSucursal': idSucursal}, 
        success: function(data)
        {
            if(data.length != 0)
            {
                $('.'+renglon).remove();
        
                for(var i=0;data.length>i;i++)
                {
                    ///llena la tabla con renglones de registros
                    var html='<tr class="'+renglon+'" alt="'+data[i].id_depto+'" alt2="'+data[i].departamento+'" alt3="'+data[i].area+'" alt4="'+data[i].supervisor+'">\
                                <td data-label="Departamento" style="text-align:left;">' + data[i].departamento+ '</td>\
                                <td data-label="Área">' + data[i].area+ '</td>\
                                <td data-label="Supervisor">' + data[i].supervisor+ '</td>\
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
            console.log('php/departamentos_buscar_idSucursal.php --> '+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Departamentos de una Sucursal');
        }
    });
}


/*Busca los empleados de los departamentos de una unidad de negocio */
function muestraModalEmpleadosUnidad(renglon, tabla, modal, idUnidadNegocio){
    $('.'+renglon).remove();

    $.ajax({
        type: 'POST',
        url: 'php/empleados_buscar_idUnidad.php',
        dataType:"json", 
        data:{'idUnidadNegocio': idUnidadNegocio}, 
        success: function(data)
        {
            if(data.length != 0)
            {
                $('.'+renglon).remove();
        
                for(var i=0;data.length>i;i++)
                {   //MGFS 29-11-29 SE AGREGRA EL CAMPO DE ID EN LA TABLA 
                    ///llena la tabla con renglones de registros
                    var html='<tr class="'+renglon+'" alt="'+data[i].id_trabajador+'" alt2="'+data[i].nombre+'" alt3="'+data[i].cve_nom+'">\
                                <td data-label="ID Trabajador" style="text-align:left;">' + data[i].id_trabajador+ '</td>\
                                <td data-label="Nombre" style="text-align:left;">' + data[i].nombre+ '</td>\
                                <td data-label="Iniciales">' + data[i].iniciales+ '</td>\
                                <td data-label="Puesto">' + data[i].puesto+ '</td>\
                                <td data-label="Departamento">' + data[i].departamento+ '</td>\
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
            console.log('php/empleados_buscar_idUnidad.php --> '+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Empleados la unidad de negocio');
        }
    });
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
var numMes = aux.getMonth()+1;

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

/*
Crea combo de familia gasros
*contenedor = nombre id de contenedor select
*/
function muestraSelectFamiliaGastos(contenedor){
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
            'tipoSelect' : 'FAMILIA_GASTOS'
        },
        success: function(data) {
            //console.log(data);
            if(data!=0){

                var arreglo=data;
                for(var i=0;i<arreglo.length;i++){
                    var dato=arreglo[i];
                    
                    html+='<option value="'+dato.id_fam+'">'+dato.familia_gasto+'</option>';
                }
                $('#'+contenedor).html(html);

            }

        },
        error: function (xhr) {
            console.log("muestraSelectFamiliaGastos --> php/combos_buscar.php: -->"+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Familia Gastos');
        }
    });
}

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
                                            <img src="imagenes/logoGinther2.png" width="300px"/>\
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
                $('body').empty().append(fondo_cargando).css('background-image','url("imagenes/fondo_login.jpg")');
            }
            
        }
    });
}

function muestraCuentasBancos(idSelect,idCuentaOrigen,tipo)
{

    $('#'+idSelect).select2();

    $('#'+idSelect).html('');
    var html='<option selected disabled>Selecciona una Cuenta</option>';
    $('#'+idSelect).append(html);

    $.ajax({

        type: 'POST',
        url: 'php/combos_buscar.php',
        dataType:"json", 
        data:{

            'tipoSelect' : 'CUENTAS_BANCOS',
            'idCuentaOrigen': idCuentaOrigen,
            'tipo':tipo
        },
        success: function(data)
        {  
            if(data != 0)
            {
                var arreglo=data;
                for(var i=0;i<arreglo.length;i++)
                {
                    var dato=arreglo[i];
                    var html="<option value="+dato.id+" alt="+dato.id_banco+" alt2="+dato.tipo+" alt3="+dato.id_sucursal+">"+dato.cuenta+"</option>";
                    $('#'+idSelect).append(html);
                }
            }
        },
        error: function (xhr) {
            console.log("muestraCuentasBancos: "+JSON.stringify(xhr));    
            mandarMensaje('* No se encontró información de Cuentas Bancos');
        }
    });
}

function muestraTiposIngresos(idSelect)
{

    $('#'+idSelect).select2();

    $('#'+idSelect).html('');
    var html='<option selected disabled>Selecciona</option>';
    $('#'+idSelect).append(html);

    $.ajax({

        type: 'POST',
        url: 'php/combos_buscar.php',
        dataType:"json", 
        data:{

            'tipoSelect' : 'TIPOS_INGRESOS'
        },
        success: function(data)
        {
            if(data != 0)
            {
                var arreglo=data;
                for(var i=0;i<arreglo.length;i++)
                {
                    var dato=arreglo[i];
                    var html="<option value="+dato.id+">"+dato.descripcion+"</option>";
                    $('#'+idSelect).append(html);
                }
            }
        },
        error: function (xhr) {
            console.log("muestraTiposIngresos: "+JSON.stringify(xhr));    
            mandarMensaje('* No se encontró información de Tipos Ingresos');
        }
    });
}

/*
*Busca los conceptos de cxp, gastos, avles de gasolina, etc
*tipo:  1=cxp    2=vales de gasolina
*/
function muestraConceptosCxP(idSelect,tipo)
{
    $('#'+idSelect).select2();

    $('#'+idSelect).html('');
    var html='<option selected disabled>Selecciona</option>';
    $('#'+idSelect).append(html);

    $.ajax({

        type: 'POST',
        url: 'php/combos_buscar.php',
        dataType:"json", 
        data:{

            'tipoSelect' : 'CONCEPTOS_CXP',
            'tipo':tipo
        },
        success: function(data)
        {  
            if(data != 0)
            {
                var arreglo=data;
                for(var i=0;i<arreglo.length;i++)
                {
                    var dato=arreglo[i];
                    var html="<option value="+dato.id+" alt="+dato.clave+">"+dato.concepto+"</option>";
                    $('#'+idSelect).append(html);
                }
            }
        },
        error: function (xhr) {
            console.log("muestraConceptosCxP: "+JSON.stringify(xhr));    
            mandarMensaje('* No se encontró información de Conceptos CxP');
        }
    });
}

/*
* Esta función muestra las areas, las cuales on genericas  y no van filtradas por nada
*/
function muestraTiposGasto(idSelect)
{

    $('#'+idSelect).select2();

    $('#'+idSelect).html('');
    var html='<option selected disabled>Elige un Tipo</option><option value="F">Factura</option><option value="N">Nota</option><option value="R">Recibo</option><option value="RP">Reposición</option>';
    
    $('#'+idSelect).append(html);

}

/*
Crea combo de clasificacion de gastos
* si trae idFamiliaGastos >0 se muestran solo las clasificacion de esa familia si no trae todas
*contenedor = nombre id de contenedor select
*/
function muestraSelectClasificacionGastos(contenedor,idFamiliaGastos){
    //---MGFS verificar que siempre exista la calsificacaion id=0 valor='NO APLICA' en la tabla(gastos_clasificacion) y se emuetsra en todas las familias
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
            'tipoSelect' : 'CLASIFICACION_GASTOS',
            'idFamiliaGastos' :idFamiliaGastos
        },
        success: function(data) {
            //console.log(data);
            if(data!=0){

                var arreglo=data;
                for(var i=0;i<arreglo.length;i++){
                    var dato=arreglo[i];
                    
                    html+='<option value="'+dato.id+'">'+dato.clasificacion+'</option>';
                }
                $('#'+contenedor).html(html);

            }

        },
        error: function (xhr) {
            console.log("muestraSelectFamiliaGastos --> php/combos_buscar.php: -->"+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Familia Gastos');
        }
    });
}


function muestraDepartamentoAreaInternos(idSelect, idSucursal, idArea)
{

    $('#'+idSelect).select2();

    $('#'+idSelect).html('');
    var html='<option selected disabled>Elige una Departamento</option>';
    $('#'+idSelect).append(html);

    $.ajax({

            type: 'POST',
            url: 'php/combos_buscar.php',
            dataType:"json", 
            data:{

                'tipoSelect' : 'DEPARTAMENTOS_AREA_INTERNOS',
                'idSucursal': idSucursal,
                'idArea': idArea 

            },
            success: function(data)
            {

                console.log(data);
                if(data != 0)
                {

                    var arreglo=data;
                    for(var i=0;i<arreglo.length;i++)
                    {
                        var dato=arreglo[i];
                        var html="<option value="+dato.id_depto+">"+dato.des_dep+"</option>";
                        $('#'+idSelect).append(html);
                    }

                }

            },
            error: function (xhr) {
                console.log("muestraDepartamentoAreaInternos: "+JSON.stringify(xhr));  
                //--MGFS 13-12-2019 se quita el mensaje de que no se encontraron departamentos internos ya se mostraba cada vez que cambiaban de sucursal
                //--ISSUE DEN18-2468 
                //mandarMensaje('* No se encontró información de Departamentos Internos');
            }
     });
}

function muestraModalProveedoresCxP(renglon,tabla,modal,factura,fechaInicio,fechaFin){
    $('.'+renglon).remove();

    var datos = {
        'factura':factura,
        'fechaInicio':fechaInicio,
        'fechaFin':fechaFin
    };

    $.ajax({
        type: 'POST',
        url: 'php/cxp_proveedores_buscar.php',
        dataType:"json", 
        data:{'datos':datos},
        success: function(data) {
        
        if(data.length != 0){

                $('.'+renglon).remove();
        
                for(var i=0;data.length>i;i++){

                    ///llena la tabla con renglones de registros
                    var html='<tr class="'+renglon+'" alt="'+data[i].id_proveedor+'" alt2="'+data[i].nombre+'">\
                                <td data-label="Clave">' + data[i].id_proveedor+ '</td>\
                                <td data-label="RFC">' + data[i].rfc+ '</td>\
                                <td data-label="Nombre">' + data[i].nombre+ '</td>\
                                <td data-label="Grupo">' + data[i].grupo+ '</td>\
                                <td data-label="Estatus">' + data[i].estatus+ '</td>\
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
            console.log('cxp_proveedores_buscar.php --> '+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Proveedores');
        }
    });
}


function muestraModalFacturasCxP(renglon,tabla,modal,idProveedor,fechaInicio,fechaFin){
    $('.'+renglon).remove();

    var datos = {
        'idProveedor':idProveedor,
        'fechaInicio':fechaInicio,
        'fechaFin':fechaFin
    };

    $.ajax({
        type: 'POST',
        url: 'php/cxp_facturas_buscar.php',
        dataType:"json", 
        data:{'datos':datos},
        success: function(data) {
        
        if(data.length != 0){

                $('.'+renglon).remove();
        
                for(var i=0;data.length>i;i++){

                    ///llena la tabla con renglones de registros
                    var html='<tr class="'+renglon+'" alt="'+ data[i].id +'" alt2="'+data[i].no_factura +'" alt3="'+data[i].importe+'" alt4="'+data[i].cargo+' alt5="'+data[i].bandera_cancela+'" alt6="'+data[i].id_proveedor+'" alt7="'+data[i].proveedor+'">\
                                <td data-label="Factura">' + data[i].no_factura + '</td>\
                                <td data-label="Proveedor">' + data[i].proveedor + '</td>\
                                <td data-label="Fecha">' + data[i].fecha + '</td>\
                                <td data-label="Concepto">' + data[i].concepto + '</td>\
                                <td data-label="Estatus">' + data[i].estatus + '</td>\
                                <td data-label="Importe">' + formatearNumero(data[i].importe) + '</td>\
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
            console.log('cxp_facturas_buscar.php --> '+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Proveedores');
        }
    });
}

/*Busca los empleados de los departamentos de una unidad de negocio */
function muestraModalEmpleadosIdSucursal(renglon, tabla, modal, idSucursal){
    $('.'+renglon).remove();

    $.ajax({
        type: 'POST',
        url: 'php/empleados_buscar_idSucursal.php',
        dataType:"json", 
        data:{'idSucursal': idSucursal}, 
        success: function(data)
        {
            if(data.length != 0)
            {
                $('.'+renglon).remove();
        
                for(var i=0;data.length>i;i++)
                {
                    ///llena la tabla con renglones de registros
                    var html='<tr class="'+renglon+'" alt="'+data[i].id_trabajador+'" alt2="'+data[i].nombre+'" alt3="'+data[i].cve_nom+'">\
                                <td data-label="ID" style="text-align:left;">' + data[i].id_trabajador+ '</td>\
                                <td data-label="Nombre" style="text-align:left;">' + data[i].nombre+ '</td>\
                                <td data-label="Iniciales">' + data[i].iniciales+ '</td>\
                                <td data-label="Puesto">' + data[i].puesto+ '</td>\
                                <td data-label="Departamento">' + data[i].departamento+ '</td>\
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
            console.log('php/empleados_buscar_idUnidad.php --> '+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Empleados la sucursal');
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

/*Busca los empleados con regisro de gastos de tipo deudores diversos */
function muestraModalDeudoresDiversos(renglon, tabla, modal){
    $('.'+renglon).remove();

    $.ajax({
        type: 'POST',
        url: 'php/gastos_deudores_diversos_buscar.php',
        dataType:"json",  
        success: function(data)
        {
            if(data.length != 0)
            {
                $('.'+renglon).remove();
        
                for(var i=0;data.length>i;i++)
                {
                    ///llena la tabla con renglones de registros
                    var html='<tr class="'+renglon+'" alt="'+data[i].id_trabajador+'" alt2="'+data[i].nombre+'">\
                                <td data-label="Nombre" style="text-align:left;">' + data[i].nombre+ '</td>\
                                <td data-label="Puesto">' + data[i].puesto+ '</td>\
                                <td data-label="Departamento">' + data[i].departamento+ '</td>\
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
            console.log('php/gastos_deudores_diversos_buscar.php --> '+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Empleados Deudores Diversos');
        }
    });
}
/*
* Esta función muestra las clasificaciones de viaticos
*/
function muestraSelectClasificacionViaticos(idSelect)
{

    $('#'+idSelect).select2();

    $('#'+idSelect).html('');
    var html='<option selected disabled>Elige una Clasificación</option>';
    $('#'+idSelect).append(html);
    
    $.ajax({

            type: 'POST',
            url: 'php/combos_buscar.php',
            dataType:"json", 
            data:{

                'tipoSelect' : 'CLASIFICACION_VIATICOS'

            },
            success: function(data)
            {

                if(data != 0)
                {

                    var arreglo=data;
                    for(var i=0;i<arreglo.length;i++)
                    {
                        var dato=arreglo[i];
                        var html="<option value="+dato.id+">"+dato.descripcion+"</option>";
                        $('#'+idSelect).append(html);
                    }

                }

            },
            error: function (xhr) {
                console.log("muestraSelectClasificacionViaticos: "+JSON.stringify(xhr));    
                mandarMensaje('* No se encontró información de Clasificación de viáticos');
            }
     });
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

/*
*Busca los conceptos de cxp solo de abonos 
*/
function muestraConceptosCxPAbonos(idSelect)
{
    $('#'+idSelect).select2();

    $('#'+idSelect).html('');
    var html='<option selected disabled>Selecciona</option>';
    $('#'+idSelect).append(html);

    $.ajax({

        type: 'POST',
        url: 'php/combos_buscar.php',
        dataType:"json", 
        data:{

            'tipoSelect' : 'CONCEPTOS_CXP_ABONOS'
        },
        success: function(data)
        {  
            if(data != 0)
            {
                var arreglo=data;
                for(var i=0;i<arreglo.length;i++)
                {
                    var dato=arreglo[i];
                    var html="<option value="+dato.id+" alt="+dato.clave+">"+dato.concepto+"</option>";
                    $('#'+idSelect).append(html);
                }
            }
        },
        error: function (xhr) {
            console.log("muestraConceptosCxPAbonos: "+JSON.stringify(xhr));    
            mandarMensaje('* No se encontró información de Conceptos CxP');
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

//-->Carga los opcion y asigna el valor en selected
function muestraUnidadesValor(datos,idSelect,valor)
{
    $('#'+idSelect).select2();

    $('#'+idSelect).html('');
    var html='<option selected disabled>Selecciona</option>';
    $('#'+idSelect).append(html);

    if(datos.length > 0)
    {
        for (i = 0; i < datos.length; i++) {
            if(parseInt(datos[i].id_unidad) == parseInt(valor))
            {     
                var html="<option value="+datos[i].id_unidad+" selected>"+datos[i].nombre_unidad+"</option>";
            }else{
                var html="<option value="+datos[i].id_unidad+">"+datos[i].nombre_unidad+"</option>";
            }
        
            $('#'+idSelect).append(html);
        }

    }
}
//-->Carga los opcion y asigna el valor en selected
function muestraSucursalesPermisoValor(idSelect,idUnidadNegocio,modulo,idUsuario,valor){

    $('#'+idSelect).select2();

    $('#'+idSelect).html('');
    var html='<option selected disabled>Selecciona</option>';
    $('#'+idSelect).append(html);
    
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
        success: function(data)
        {

            if(data != 0)
            {
                var arreglo=data;
                for(var i=0;i<arreglo.length;i++)
                {
                    var dato=arreglo[i];
                    if(parseInt(dato.id_sucursal) == parseInt(valor))
                    {
                        var html="<option value="+dato.id_sucursal+" selected>"+dato.nombre+"</option>";
                    }else{
                        var html="<option value="+dato.id_sucursal+">"+dato.nombre+"</option>";
                    }
                    $('#'+idSelect).append(html);
                }

            }

        },
        error: function (xhr) {
            console.log("muestraSucursalesPermisoValor: "+JSON.stringify(xhr));    
            mandarMensaje('* No se encontró información de sucursales');
        }
    });
}

//-->Carga los opcion y asigna el valor en selected
function muestraAreasAccesoValor(idSelect,valor)
{

    $('#'+idSelect).select2();

    $('#'+idSelect).html('');
    var html='<option selected disabled>Elige un área</option>';
    $('#'+idSelect).append(html);

    $.ajax({

            type: 'POST',
            url: 'php/combos_buscar.php',
            dataType:"json", 
            data:{

                'tipoSelect' : 'ACCESOS_AREAS'

            },
            success: function(data)
            {

                if(data != 0)
                {

                    var arreglo=data;
                    for(var i=0;i<arreglo.length;i++)
                    {
                        var dato=arreglo[i];
                        if(parseInt(dato.id) == parseInt(valor))
                        {
                            var html="<option value="+dato.id+" selected>"+dato.descripcion+"</option>";
                        }else{
                            var html="<option value="+dato.id+">"+dato.descripcion+"</option>";
                        }
                        $('#'+idSelect).append(html);
                    }

                }

            },
            error: function (xhr) {
                console.log("muestraAreasAcceso: "+JSON.stringify(xhr));    
                //mandarMensaje('* No se encontró información de Areas Acceso');
            }
    });
}
//-->Carga los opcion y asigna el valor en selected
function muestraDepartamentoAreaInternosValor(idSelect, idSucursal, idArea, valor)
{

    $('#'+idSelect).select2();

    $('#'+idSelect).html('');
    var html='<option selected disabled>Elige una Departamento</option>';
    $('#'+idSelect).append(html);

    $.ajax({

            type: 'POST',
            url: 'php/combos_buscar.php',
            dataType:"json", 
            data:{

                'tipoSelect' : 'DEPARTAMENTOS_AREA_INTERNOS',
                'idSucursal': idSucursal,
                'idArea': idArea 

            },
            success: function(data)
            {

                if(data != 0)
                {

                    var arreglo=data;
                    for(var i=0;i<arreglo.length;i++)
                    {
                        var dato=arreglo[i];
                        if(parseInt(dato.id_depto) == parseInt(valor))
                        {
                            var html="<option value="+dato.id_depto+" selected>"+dato.des_dep+"</option>";
                        }else{
                            var html="<option value="+dato.id_depto+">"+dato.des_dep+"</option>";
                        }
                        $('#'+idSelect).append(html);
                    }

                }

            },
            error: function (xhr) {
                console.log("muestraDepartamentoAreaInternos: "+JSON.stringify(xhr));    
                mandarMensaje('* No se encontró información de Departamentos Internos');
            }
     });
}

//-->Carga los opcion y asigna el valor en selected
function muestraSelectFamiliaGastosValor(contenedor,valor){
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
            'tipoSelect' : 'FAMILIA_GASTOS'
        },
        success: function(data) {
            //console.log(data);
            if(data!=0){

                var arreglo=data;
                for(var i=0;i<arreglo.length;i++){
                    var dato=arreglo[i];
                    
                    if(parseInt(dato.id_fam) == parseInt(valor))
                    {
                        html+="<option value="+dato.id_fam+" selected>"+dato.familia_gasto+"</option>";
                    }else{
                        html+="<option value="+dato.id_fam+">"+dato.familia_gasto+"</option>";
                    }
                    //html+='<option value="'+dato.id_fam+'">'+dato.familia_gasto+'</option>';
                }
                $('#'+contenedor).html(html);

            }

        },
        error: function (xhr) {
            console.log("muestraSelectFamiliaGastos --> php/combos_buscar.php: -->"+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Familia Gastos');
        }
    });
}

//-->Carga los opcion y asigna el valor en selected
function muestraSelectClasificacionGastosValor(contenedor,idFamiliaGastos,valor){
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
            'tipoSelect' : 'CLASIFICACION_GASTOS',
            'idFamiliaGastos' :idFamiliaGastos
        },
        success: function(data) {
            //console.log(data);
            if(data!=0){

                var arreglo=data;
                for(var i=0;i<arreglo.length;i++){
                    var dato=arreglo[i];
                    
                    if(parseInt(dato.id) == parseInt(valor))
                    {
                        html+="<option value="+dato.id+" selected>"+dato.clasificacion+"</option>";
                    }else{
                        html+="<option value="+dato.id+">"+dato.clasificacion+"</option>";
                    }
                    //html+='<option value="'+dato.id+'">'+dato.clasificacion+'</option>';
                }
                $('#'+contenedor).html(html);

            }

        },
        error: function (xhr) {
            console.log("muestraSelectFamiliaGastos --> php/combos_buscar.php: -->"+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Familia Gastos');
        }
    });
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

/*Busca los clientes */
function muestraModalClientes(renglon, tabla, modal){
    $('.'+renglon).remove();

    $.ajax({
        type: 'POST',
        url: 'php/clientes_buscar.php',
        dataType:"json", 
        data:{'estatus':0}, 
        success: function(data)
        {
            if(data.length != 0)
            {
                $('.'+renglon).remove();
        
                for(var i=0;data.length>i;i++)
                {
                    ///llena la tabla con renglones de registros
                    var html='<tr class="'+renglon+'" alt="'+data[i].id+'" alt2="'+data[i].nombre_comercial+'">\
                                <td data-label="ID" style="text-align:left;">' + data[i].id+ '</td>\
                                <td data-label="Nombre Comercial">' + data[i].nombre_comercial+ '</td>\
                                <td data-label="Fecha Inicio">' + data[i].fecha_inicio+ '</td>\
                            </tr>';
                    ///agrega la tabla creada al div 
                    $('#'+tabla).append(html);   
                    $('#'+modal).modal('show');   
                }

            }else{
                mandarMensaje('No se encontró información al buscar clientes');
            }
        },
        error: function (xhr) {
            console.log('php/empleados_buscar_idUnidad.php --> '+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Empleados la unidad de negocio');
        }
    });
}

function muestraSelectRazonesSociales(idCliente,idUnidadNegocio,contenedor){
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
            'tipoSelect' : 'RAZON_SOCIAL',
            'idCliente' :idCliente,
            'idUnidadNegocio':idUnidadNegocio
        },
        success: function(data) {
            //console.log(data);
            if(data!=0){

                var arreglo=data;
                for(var i=0;i<arreglo.length;i++){
                    var dato=arreglo[i];
                    
                    html+="<option value="+dato.id+" alt="+dato.dias_cred+" alt2="+dato.rfc+" alt3="+dato.codigo_postal+" alt4='"+dato.correo_facturas+"' alt5='"+dato.id_pais+"' alt6='"+dato.razon_social+"'>"+dato.razon_social+"</option>";
                }
                $('#'+contenedor).html(html);

            }

        },
        error: function (xhr) {
            console.log("muestraSelectRazonesSocialesClientes --> php/combos_buscar.php: -->"+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Razones Sociales');
        }
    });
}

function muestraSelectUsoCFDI(contenedor){
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
            'tipoSelect' : 'USO_CFDI'
        },
        success: function(data) {
            //console.log(data);
            if(data!=0){

                var arreglo=data;
                for(var i=0;i<arreglo.length;i++){
                    var dato=arreglo[i];
                    
                    html+="<option value="+dato.clave+">"+dato.clave+' - '+dato.descripcion+"</option>";
                }
                $('#'+contenedor).html(html);

            }

        },
        error: function (xhr) {
            console.log("muestraSelectCFDI --> php/combos_buscar.php: -->"+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Uso de CFDI');
        }
    });
}

function muestraSelectMetodoPago(contenedor){
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
            'tipoSelect' : 'METODO_PAGO'
        },
        success: function(data) {
            //console.log(data);
            if(data!=0){

                var arreglo=data;
                for(var i=0;i<arreglo.length;i++){
                    var dato=arreglo[i];
                    
                    html+="<option value="+dato.clave+">"+dato.clave+' - '+dato.descripcion+"</option>";
                }
                $('#'+contenedor).html(html);
            }
        },
        error: function (xhr) {
            console.log("muestraSelectMetodoPago --> php/combos_buscar.php: -->"+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de metodos de pago');
        }
    });
}

function muestraSelectFormaPago(tipo,contenedor){
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
            'tipoSelect' : 'FORMA_PAGO',
            'tipo':tipo
        },
        success: function(data) {
            //console.log(data);
            if(data!=0){

                var arreglo=data;
                for(var i=0;i<arreglo.length;i++){
                    var dato=arreglo[i];
                    
                    html+="<option value="+dato.clave+">"+dato.clave+' - '+dato.descripcion+"</option>";
                }
                $('#'+contenedor).html(html);
            }
        },
        error: function (xhr) {
            console.log("muestraSelectMetodoPago --> php/combos_buscar.php: -->"+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de metodos de pago');
        }
    });
}

function muestraSelectClaveProductoSAT(contenedor){
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
            'tipoSelect' : 'PRODUCTOS_SAT'
        },
        success: function(data) {
            if(data!=0){

                var arreglo=data;
                for(var i=0;i<arreglo.length;i++){
                    var dato=arreglo[i];
                    
                    html+="<option value="+dato.c_clave_prod_serv+" alt='"+dato.descripcion+"'>"+dato.c_clave_prod_serv+" - "+dato.descripcion+"</option>";
                }
                $('#'+contenedor).html(html);
            }
        },
        error: function (xhr) {
            console.log("muestraSelectClaveSatProductosServicios --> php/combos_buscar.php: -->"+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de clave SAT Productos/Servicios');
        }
    });
}

function muestraSelectClaveUnidadesSAT(contenedor){
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
            'tipoSelect' : 'UNIDADES_SAT'
        },
        success: function(data) {
            if(data!=0){

                var arreglo=data;
                for(var i=0;i<arreglo.length;i++){
                    var dato=arreglo[i];
                    
                    html+="<option value="+dato.c_clave_unidad+" alt='"+dato.nombre+"'>"+dato.c_clave_unidad+" - "+dato.nombre+"</option>";
                }
                $('#'+contenedor).html(html);
            }
        },
        error: function (xhr) {
            console.log("muestraSelectClaveSatUnidades --> php/combos_buscar.php: -->"+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de clave SAT Unidades');
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

function actualizarDatosCFDI(id, idCFDI)
{
    var idFactura = 0;

    $.ajax({
        type: 'GET',
        url: 'php/facturacion_actualizar_cfdi.php',
        data : {'id':id, 'id_cfdi': idCFDI},
        async: false, //-->quita asincrono para que pueda returnar el valor cuando ya se haya terminado el proceso ajax
        success: function(data)
        {
            console.log('*'+data+'*');
            idFactura =  data;
        },
        error: function (xhr)
        {
            console.log("php/facturacion_actualizar_cfdi.php: -->"+JSON.stringify(xhr));
            mandarMensaje('* No se actualizaron datos al timbrar');
        }
    });

    return idFactura;
}

function actualizarEstatusFactura(id,estatus)
{
    var idFactura = 0;

    $.ajax({
        type: 'GET',
        url: 'php/facturacion_actualizar_estatus_cfdi.php',
        data : {'id':id,'estatus':estatus},
        async: false, //-->quita asincrono para que pueda returnar el valor cuando ya se haya terminado el proceso ajax
        success: function(data)
        {
            console.log(data);
            idFactura =  data;
        },
        error: function (xhr)
        {
            console.log("php/facturacion_actualizar_estatus_cfdi.php: -->"+JSON.stringify(xhr));
            mandarMensaje('* No se actualizó el estatus');
        }
    });

    return idFactura;

}

function actualizarEstatusPago(id,estatus)
{
    var idPago = 0;

    $.ajax({
        type: 'GET',
        url: 'php/pagos_actualizar_estatus_cfdi.php',
        data : {'id':id,'estatus':estatus},
        async: false, //-->quita asincrono para que pueda returnar el valor cuando ya se haya terminado el proceso ajax
        success: function(data)
        {
            console.log(data);
            idPago =  data;
        },
        error: function (xhr)
        {
            console.log("php/pagos_actualizar_estatus_cfdi.php: -->"+JSON.stringify(xhr));
            mandarMensaje('* No se actualizó el estatus');
        }
    });

    return idPago;

}

function actualizarDatosCFDIPagos(id, idCFDI)
{
    var idPago = 0;

    $.ajax({
        type: 'GET',
        url: 'php/pagos_actualizar_cfdi.php',
        data : {'id':id, 'id_cfdi': idCFDI},
        async: false, //-->quita asincrono para que pueda returnar el valor cuando ya se haya terminado el proceso ajax
        success: function(data)
        {
            console.log('*'+data+'*');
            idPago =  data;
        },
        error: function (xhr)
        {
            console.log("php/pagos_actualizar_cfdi.php: -->"+JSON.stringify(xhr));
            mandarMensaje('* No se actualizaron datos al timbrar');
        }
    });

    return idPago;
}


$(document).on('mousedown','.btn,.menu_clic',function(e){

    var id= $(this).attr('id');
    
    if(id != 'b_regresar_portal' && id != 'b_detalle_proveedor_portal' && id != 'b_buscar_proveedor_portal' && id != 'b_login' && id != 'b_cerrar_modal_d_p_portal' && id != 'b_aceptar' && id != 'b_iniciar_session' && id != 'b_buscar_razon_social_emisora')
    {
        
        //var id_personal=window.parent.document.getElementById('#i_id_personal');
        
        $.post('php/verifica_session.php',function(data){
            console.log("resutado del boton:"+data);
            if (data==0){
                var fondo_cargando='<div id="d_marco" style="position:absolute;top:0%; left:0%; width: 100%;background-color:rgba(4,5,5,.3); bottom:0%; z-index: 0; border-radius:5px;margin-bottom: -800px;padding-bottom: 800px; overflow: hidden;"> </div>\
                                    <div class="container-fluid" id="div_session_off" style="padding-top:100px;">\
                                        <div class="row">\
                                            <div class="col-sm-12 col-md-12" style="text-align:center;">\
                                            <img src="imagenes/logoGinther2.png" width="300px"/>\
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
                $('body').empty().append(fondo_cargando).css('background-image','url("imagenes/fondo_login.jpg")');
            }
        }); 
    }
});

/*
Crea combo de Planes, por default muestra México id_pais 141
*contenedor = nombre id de contenedor select
*/
function muestraSelectPlanes(contenedor){

    $('#'+contenedor).select2();

    $('#'+contenedor).html('');
    var html='';
    html='<option value="" selected disabled>Selecciona</option>';
    $('#'+contenedor).append(html);

    $.ajax({

            type: 'POST',
            url: 'php/combos_buscar.php',
            dataType:"json", 
            data:{
                'tipoSelect' : 'PLANES'
            },
            success: function(data) {
               
                if(data!=0){

                    var arreglo=data;
                    for(var i=0;i<arreglo.length;i++){
                        var dato=arreglo[i];
                        html+='<option value="'+dato.id+'" cantidad="'+dato.cantidad+'" tipo="'+dato.tipo+'">'+dato.descripcion+'</option>';
                    }
                    $('#'+contenedor).html(html);

                }

            },
            error: function (xhr) {
                console.log("muestraSelectPlanes: "+JSON.stringify(xhr));    
                mandarMensaje('* No se encontró información de planes');
            }
     });
}


/*
Verifica si el usuario tiene permiso de dar click al boton de la forma en la unidad y sucursal
*idInput  nombre ide del input donde almacenaremos el idSucursal generica
*idUnidadNegocio  es el id de la unidad actual en session
*idUsuario  id del usuario que inicio session
*/
function verificarPermisosAlarmas(idUsuario,idUnidadNegocio){

    $(document).find('.verificar_permiso').each(function(){
        
        var boton = $(this).attr('alt');
        var idBoton = $(this).attr('id');
      
        $.ajax({

            type: 'POST',
            url: 'php/permisos_botones_alarmas_buscar.php', 
            data:{
                'idUsuario' : idUsuario,
                'boton':boton,
                'idBoton':idBoton,
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
                mandarMensaje('* No se encontró información al verificar permisos Alarmas');
            }
        });
    });
}

/*
Crea combo de Reporta
*contenedor = nombre id de contenedor select
*/
function muestraSelectReporta(contenedor,tipo){

    $('#'+contenedor).select2();
    $('#'+contenedor).html('');

    var html='';
    html='<option value="" disabled>Selecciona</option>';
    html+='<option value="3">VENTAS</option>';
    
    if(tipo == 'instalacion')
        html+='<option value="4">COBRANZA</option>';

    if(tipo == 'general')
    {
        html+='<option value="4">COBRANZA</option>';
        html+='<option value="1">CUADRILLA</option>';
        html+='<option value="2">MONITOREO</option>';
    }
    $('#'+contenedor).html(html); 
}

/*
Crea combo de Prioridad
*contenedor = nombre id de contenedor select
*/
function muestraSelectPrioridad(contenedor){

    $('#'+contenedor).select2();
    $('#'+contenedor).html('');
    
    var html='';
    html='<option value="" disabled>Selecciona</option>';
    html+='<option value="1">BAJA</option>';
    html+='<option value="2">MEDIA</option>';
    html+='<option value="3">ALTA</option>';
    $('#'+contenedor).html(html); 
}

/*
Crea combo de CASIFICACION_SERVICIOS
*contenedor = nombre id de contenedor select
*/
function muestraSelectClasificacionServicios(contenedor){

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
                'tipoSelect' : 'CASIFICACION_SERVICIOS'
            },
            success: function(data) {
               
                if(data!=0){

                    var arreglo=data;
                    for(var i=0;i<arreglo.length;i++){
                        var dato=arreglo[i];
                        html+='<option value="'+dato.id+'" cantidad="'+dato.cantidad+'">'+dato.descripcion+'</option>';
                    }
                    $('#'+contenedor).html(html);

                }

            },
            error: function (xhr) {
                console.log("muestraSelectClasificacionServicios: "+JSON.stringify(xhr));    
                mandarMensaje('* No se encontró información de clasificacion de servicios');
            }
     });
}

/*
*Busca los conceptos de cxp, gastos, avles de gasolina, etc
*tipo:  1=cxp    2=vales de gasolina
*/
function muestraConceptosCxCAlarmas(idSelect,tipo)
{
    $('#'+idSelect).select2();

    $('#'+idSelect).html('');
    var html='<option selected disabled>Selecciona</option>';
    $('#'+idSelect).append(html);

    $.ajax({

        type: 'POST',
        url: 'php/combos_buscar.php',
        dataType:"json", 
        data:{

            'tipoSelect' : 'CONCEPTOS_CXC_ALARMAS',
            'tipo':tipo
        },
        success: function(data)
        {  
            if(data != 0)
            {
                var arreglo=data;
                for(var i=0;i<arreglo.length;i++)
                {
                    var dato=arreglo[i];
                    var html="<option value="+dato.id+" alt="+dato.clave+">"+dato.concepto+"</option>";
                    $('#'+idSelect).append(html);
                }
            }
        },
        error: function (xhr) {
            console.log("muestraConceptosCxP: "+JSON.stringify(xhr));    
            mandarMensaje('* No se encontró información de Conceptos CxP');
        }
    });
}

/*Busca los empleados de los departamentos de una unidad de negocio */
function muestraModalEmpleadosUnidadNomina(renglon, tabla, modal, idUnidadNegocio){
    $('.'+renglon).remove();

    $.ajax({
        type: 'POST',
        url: 'php/empleados_buscar_idUnidad.php',
        dataType:"json", 
        data:{'idUnidadNegocio': idUnidadNegocio}, 
        success: function(data)
        {
            if(data.length != 0)
            {
                $('.'+renglon).remove();
        
                for(var i=0;data.length>i;i++)
                {
                    ///llena la tabla con renglones de registros
                    var html='<tr class="'+renglon+'" alt="'+data[i].id_trabajador+'" alt2="'+data[i].nombre+'" alt3="'+data[i].cve_nom+'">\
                                <td data-label="ID" style="text-align:left;">' + data[i].id_trabajador+ '</td>\
                                <td data-label="Nombre" style="text-align:left;">' + data[i].nombre+ '</td>\
                                <td data-label="Iniciales">' + data[i].iniciales+ '</td>\
                                <td data-label="Puesto">' + data[i].puesto+ '</td>\
                                <td data-label="Departamento">' + data[i].departamento+ '</td>\
                                <td data-label="Departamento">' + data[i].no_nomina+ '</td>\
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
            console.log('php/empleados_buscar_idUnidad.php --> '+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Empleados la unidad de negocio');
        }
    });
}
//--muestraSelectTiposContratos
/*
Crea combo de Reporta
*contenedor = nombre id de contenedor select
*/
function muestraSelectTiposContratos(contenedor){

    $('#'+contenedor).select2();
    $('#'+contenedor).html('');

    var html='';
    html='<option value="" disabled>Selecciona</option>';
    html+='<option value="1">K9</option>';
    html+='<option value="2">PATRIMONIAL</option>';
    html+='<option value="3">PATRIMONIAL CON K9</option>';
    
    
    $('#'+contenedor).html(html); 
}

function muestraCarpetasArea(idUnidadNegocio,idArea,renglon,tabla,modal){
    $('.'+renglon).remove();

    $.ajax({
        type: 'POST',
        url: 'php/archivos_carpetas_buscar.php',
        dataType:"json", 
        data:{'idUnidadNegocio':idUnidadNegocio,'idArea': idArea}, 
        success: function(data) {
        
        if(data.length != 0){

                $('.'+renglon).remove();
        
                for(var i=0;data.length>i;i++){

                    ///llena la tabla con renglones de registros
                    var html='<tr class="'+renglon+'" alt="'+data[i].id+'" alt2="'+data[i].carpeta+'">\
                                <td data-label="RFC">' + data[i].carpeta+ '</td>\
                            </tr>';
                    ///agrega la tabla creada al div 
                    $('#'+tabla).append(html);   
                    $('#'+modal).modal('show');   
                }
        }else{

                mandarMensaje('No se encontró información al buscar las carpetas del área');
        }

        },
        error: function (xhr) {
            console.log('php/archivos_carpetas_buscar.php --> '+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información al buscar las carpetas del área');
        }
    });
}

function muestraSelectSalariosRazonSocial(contenedor,idRazonSocial,idCuotaObrero){
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
            'tipoSelect' : 'SALARIOS_RAZON_SOCIAL',
            'idRazonSocial' : idRazonSocial
        },
        success: function(data) {
            
            if(data!=0){

                var arreglo=data;
                for(var i=0;i<arreglo.length;i++){
                    var dato=arreglo[i];
                    
                    if(dato.id == idCuotaObrero)
                        html+='<option value="'+dato.id+'" selected> $'+dato.salario_diario+'</option>';
                    else
                        html+='<option value="'+dato.id+'"> $'+dato.salario_diario+'</option>';

                }
                $('#'+contenedor).html(html);

            }

        },
        error: function (xhr) {
            console.log("combos_buscar.php SALARIOS -->: "+JSON.stringify(xhr));    
            mandarMensaje('* No se encontró información de Salarios Puestos');
        }
    });
}


function muestraProveedorCorporativo(idSelect, idUnidad)
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

                'tipoSelect' : 'PROVEEDOR_CORPORATIVO',
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

function muestraModalProveedoresCorporativo(renglon, tabla, modal, idUnidad)
{
  
    $('.'+renglon).remove();

    $.ajax({
        type: 'POST',
        url: 'php/proveedores_buscar_corporativo.php',
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


/*Muestra modal con registros de empresas fiscales que van a  facturar y de ingresos sin facturas 
* (RAZON SOCIAL GENERICA)
* renglon  nombre clase del renglon que se va a crear
* tabla  id de la tabla con tbody a donde se vana a agregar los renglones
* modal  id del modal que se va a mostrar
*/ 
function muestraModalEmpresasFiscalesGenerica(renglon,tabla,modal){
    $('.'+renglon).remove();

    $.ajax({
        type: 'POST',
        url: 'php/empresas_fiscales_buscar_generica.php',
        dataType:"json", 
        success: function(data) {
        
        if(data.length != 0){

                $('.'+renglon).remove();
        
                for(var i=0;data.length>i;i++){

                    ///llena la tabla con renglones de registros
                    var html='<tr class="'+renglon+'" alt="'+data[i].id_empresa+'" alt2="'+data[i].razon_social+'" alt3="'+data[i].id_cfdi+'">\
                                <td data-label="Razón Social" style="text-align:left;">' + data[i].razon_social+ '</td>\
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
            console.log('empresas_fiscales_buscar.php --> '+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Empresas Fiscales');
        }
    });
}

/* MUESTRA RAZONES SOCIALES DE UNA UNIDAD DE NEGOCIO-SUCURSAL
*/ 
function muestraRazonesSocialesUnidadSucursal(renglon,tabla,modal,idUnidadNegocio,idSucursal){
    $('.'+renglon).remove();

    $.ajax({
        type: 'POST',
        url: 'php/razones_sociales_buscar_unidad_sucursal.php',
        dataType:"json", 
        data:{'idUnidadNegocio':idUnidadNegocio,
              'idSucursal':idSucursal
        },
        success: function(data) {
        
        if(data.length != 0){

                $('.'+renglon).remove();
        
                for(var i=0;data.length>i;i++){

                    ///llena la tabla con renglones de registros
                    var html='<tr class="'+renglon+'" alt="'+data[i].id+'" alt2="'+data[i].razon_social+'">\
                                <td data-label="Nombre Corto" style="text-align:left;">' + data[i].nombre_corto+ '</td>\
                                <td data-label="Razón Social" style="text-align:left;">' + data[i].razon_social+ '</td>\
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
            console.log('empresas_fiscales_buscar.php --> '+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Empresas Fiscales');
        }
    });
}

function muestraFamiliaAlarmas(idSelect)
{
    var idFamiliaAlarmas=0;
    $('#'+idSelect).val('').attr('alt',0);
    $.ajax({

            type: 'POST',
            url: 'php/combos_buscar.php',
            dataType:"json", 
            data:{

                'tipoSelect' : 'FAMILIA_ALARMAS'
            },
            async:false,
            success: function(data)
            {

                if(data != 0)
                {

                    var arreglo=data;
                   
                    var dato=arreglo[0];
                    $('#'+idSelect).val(dato.descripcion).attr('alt',dato.id);
                    idFamiliaAlarmas = dato.id;

                }

            },
            error: function (xhr) {
                console.log("muestraFamiliaAlarmas: "+JSON.stringify(xhr));    
                mandarMensaje('* No se encontró información de Familia de Alarmas');
            }
     });
     return idFamiliaAlarmas;
}

function muestraIdsEmpresasFiscalesTodas(){
    var empresas='';

    $.ajax({
        type: 'POST',
        url: 'php/empresas_fiscales_buscar_todas.php',
        dataType:"json", 
        async:false,
        success: function(data) {
        
        if(data.length != 0){
        
            empresas = data[0].empresas_fiscales;
        }else{

            mandarMensaje('No se encontró información de Empresas Fiscales Todas');
        }

        },
        error: function (xhr) {
            console.log('empresas_fiscales_buscar_todas.php --> '+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Empresas Fiscales Todas');
        }
    });

    return empresas;
}

$(document).find('.modal').each(function(){
    $(this).css('overflow-y','scroll');
});
/***utf8_to_b64 se codifican los datos a enviar */
function datosUrl( str ) {
    return btoa(unescape(encodeURIComponent( str )));
}
/***MGFS 27-11-2019 CALCULA CADA VEZ QUE DA CLIC EN EL BOTON UNIDADES 
 * YA SE PUEDE DAR ACCESO A MAS UNIDADES DE NEGOCIO O QUITAR **** */
function buscaMatrizUnidades(){
   var unidad='';

    $.ajax({
        type: 'POST',
        url: 'php/matriz_buscar_unidades_acceso_usuario.php',
        dataType:"json", 
        async:false,
        success: function(data) {
           
           unidad=data;
        
        },
        error: function (xhr) {
            console.log('matriz_buscar_unidades_acceso_usuario.php --> '+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de las unidades de negocio con  acceso');
        }
    });
    //console.log("manda"+JSON.stringify(unidad));
    return unidad;
}


function valideKeySoloNumeros(evt) {
    var code = evt.which ? evt.which : evt.keyCode;
    if (code == 8) {
        //backspace
        return true;
    } else if (code >= 48 && code <= 57) {
        //is a number
        return true;
    } else {
        return false;
    }
}
/**Muestra solo los proveedores autorizados es para el modulo de ordenes de compra */
function muestraModalProveedoresAprobadosUnidades(renglon, tabla, modal, idUnidad)
{
  
    $('.'+renglon).remove();

    $.ajax({
        type: 'POST',
        url: 'php/proveedores_buscar_aprobados_unidades.php',
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
/**muestra todos los proveedores menos los rechazados */
function muestraModalProveedoresUnidadesTodos(renglon, tabla, modal, idUnidad)
{
  
    $('.'+renglon).remove();

    $.ajax({
        type: 'POST',
        url: 'php/proveedores_todos_buscar_unidades.php',
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


/*Muestra modal con registros de empresas fiscales que vana  facturar
* renglon  nombre clase del renglon que se va a crear
* tabla  id de la tabla con tbody a donde se vana a agregar los renglones
* modal  id del modal que se va a mostrar
*/ 
function muestraModalEmpresasFiscalesCFDI(renglon,tabla,modal){
    $('.'+renglon).remove();

    $.ajax({
        type: 'POST',
        url: 'php/empresas_fiscales_cfdi_buscar.php',
        dataType:"json", 
        success: function(data) {
        
        if(data.length != 0){

                $('.'+renglon).remove();
        
                for(var i=0;data.length>i;i++){

                    ///llena la tabla con renglones de registros
                    var html='<tr class="'+renglon+'" alt="'+data[i].id_empresa+'" alt2="'+data[i].razon_social+'" alt3="'+data[i].id_cfdi+'">\
                                <td data-label="Razón Social" style="text-align:left;">' + data[i].razon_social+ '</td>\
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
            console.log('empresas_fiscales_buscar.php --> '+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Empresas Fiscales');
        }
    });
}
/**
 * MGFS 20-12-19 issue:DEN18-2425
 * Muestra la caja chica de una sucursal (se ulitiza en el modulo de viaticos para la reposicion de un viatico)
 * En la comprobación, cuando se manejen devoluciones, 
 * que solo permita seleccionar en cuentas-bancos, las cajas chicas de las sucursales y afecten ese saldo, 
 * ya que no está permitido ingresar efectivo a las cuentas bancarias 
 * @param {*} idSelect Indica el id del combo
 * @param {*} idSucursal Indica el id de la sucursal de la cual se otrorgo el viatico
 */
function muestraCuentaCajaChica(idSelect,idSucursal)
{

    $('#'+idSelect).select2();

    $('#'+idSelect).html('');
    var html='<option selected disabled>Selecciona una Cuenta</option>';
    $('#'+idSelect).append(html);

    $.ajax({

        type: 'POST',
        url: 'php/combos_buscar.php',
        dataType:"json", 
        data:{

            'tipoSelect' : 'CUENTA_CAJA_CHICA',
            'idSucursal': idSucursal
        },
        success: function(data)
        {  
            if(data != 0)
            {
                var arreglo=data;
                for(var i=0;i<arreglo.length;i++)
                {
                    var dato=arreglo[i];
                    var html="<option value="+dato.id+" alt="+dato.id_banco+" alt2="+dato.tipo+" alt3="+dato.id_sucursal+">"+dato.cuenta+"</option>";
                    $('#'+idSelect).append(html);
                }
            }else{
                mandarMensaje('La sucursal no cuenta con una caja chica, notifica al administrador para que se de de alta');
            }
        },
        error: function (xhr) {
            console.log("muestraCuentaCajaChica: "+JSON.stringify(xhr));    
            mandarMensaje('* No se encontró información sobre caja chica en la sucural actual');
        }
    });
}

//NJES GASTOS (2) (DEN18-2424) verificar que exista una cuenta banco caja chica de la sucursal seleccionada cuando se insertara movimiento a caja chica de sucursal Dic/26/2019
function existeCajaChicaSucursal(idSucursal){
    var existe=0;
    $.ajax({
        type: 'POST',
        url: 'php/cuentas_bancos_caja_sucursal_verificar.php',
        data:{
            'idSucursal' : idSucursal
        },
        async: false, //-->quita asincrono para que pueda returnar el valor cuando ya se haya terminado el proceso ajax
        success: function(data) {
            existe = data;
        },
        error: function (xhr) {
            console.log("muestraSucursalesPermisoListaId: "+JSON.stringify(xhr));
            mandarMensaje('* No se encontró información de Sucursales Permiso Lista Id');
        }
    });

    return existe;
}


function muestraCuentasBancosSaldos(idSelect,idCuentaOrigen,tipo)
{

    $('#'+idSelect).select2();

    $('#'+idSelect).html('');
    var html='<option selected disabled>Selecciona una Cuenta</option>';
    $('#'+idSelect).append(html);

    $.ajax({

        type: 'POST',
        url: 'php/combos_buscar.php',
        dataType:"json", 
        data:{

            'tipoSelect' : 'CUENTAS_BANCOS_SALDOS',
            'idCuentaOrigen':idCuentaOrigen,
            'tipo':tipo
        },
        success: function(data)
        {  
            if(data != 0)
            {
                var arreglo=data;
                for(var i=0;i<arreglo.length;i++)
                {
                    var dato=arreglo[i];
                    var html="<option value="+dato.id+" alt="+dato.id_banco+" alt2="+dato.tipo+" alt3="+dato.id_sucursal+" alt4="+dato.saldo_disponible+">"+dato.cuenta+" ( $ "+ formatearNumero(dato.saldo_disponible) +" )</option>";
                    $('#'+idSelect).append(html);
                }
            }
        },
        error: function (xhr) {
            console.log("muestraCuentasBancosSaldos: "+JSON.stringify(xhr));    
            mandarMensaje('* No se encontró información de Cuentas Bancos');
        }
    });
}

