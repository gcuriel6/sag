$(document).ready(function()
	{
	var dialogo = '<center><div style="top:30%;" class="modal fade" id="modal_alerta" role="dialog"><div class="moda-dialog  modal-sm"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h5 class="modal-title" >Mensaje de Sistema</h5></div><div class="modal-body"></div></div></div></div></center';
	$('body').append(dialogo);
	$("#modal_alerta").modal({'show':false});
	
});

function mandarMensaje(mensaje){
    	$("#modal_alerta .modal-body").html("<center><h4>"+mensaje+"</h4></center>");
    	$("#modal_alerta").modal("show");
    }
 function mandarMensajeError(mensaje){
    	$("#modal_alerta .modal-body").html("<center><h4 class='text-danger'>"+mensaje+"</h4></center>");
    	$("#modal_alerta").modal("show");
    }  