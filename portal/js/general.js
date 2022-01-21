$(document).ready(function(){
		
		$('.fecha').datepicker({
		    format: "dd/mm/yyyy",
		    autoclose: true,
		    changeMonth: true,
	        changeYear: true
		});
		
	
		
	function formatoNumero(numero) {
		numero = numero.toString();
		if (numero.indexOf('.') != -1) 
		{
			var num = numero.split('.');
			var aux = num[1];
			if (aux.length > 2) 
			{
				aux = aux.substr(0,2);
			}
	
			var nuevo = num[0] + '.' + aux;
			//alert(nuevo);
			return nuevo;
		} 
		else
		{
			numero =numero+'.00'; 
			return numero+ " " + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "1,");
		}
	}
		
			
});
