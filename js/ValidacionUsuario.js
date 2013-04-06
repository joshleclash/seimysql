function trim(cadena){
	for(i=0; i<cadena.length; )
	{
		if(cadena.charAt(i)==" ")
			cadena=cadena.substring(i+1, cadena.length);
		else
			break;
	}

	for(i=cadena.length-1; i>=0; i=cadena.length-1)
	{
		if(cadena.charAt(i)==" ")
			cadena=cadena.substring(0,i);
		else
			break;
	}
	return cadena;
}

function verificaTecla(Evt,Form){
	Evt = (Evt) ? Evt : event
	var CharCode = (Evt.which) ? Evt.which : Evt.keyCode
	if(CharCode==13)
	{
		validarFormaIngreso(Form);
	}
}

function validarFormaIngreso(Forma){
	if(navigator.appName!="Microsoft Internet Explorer"){
		Forma=document.forms["FormaIngreso"];
	}
	if(trim(Forma.IdUsuario.value)=="" || isNaN(Forma.IdUsuario.value)==true){
		alert("Por favor, ingrese su documento de identidad.");
		Forma.IdUsuario.focus();
	}
	else{
		if(trim(Forma.Clave.value)==""){
			alert("Por favor, digite su clave");
			Forma.Clave.focus();
		}
		else{
			xajax_ingresarAplicativo(Forma.IdUsuario.value, Forma.Clave.value);
			//Forma.submit();	
		}
	}
}