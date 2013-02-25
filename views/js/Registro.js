function noNumeros(Evento)
{
	Tecla = (document.all) ? Evento.keyCode : Evento.which;
    if (Tecla==0) return true;
	if (Tecla==8) return true;
	Patron =/[a-zA-ZÑñÁÉÍÓÚáéíóú\s]/;
    Te = String.fromCharCode(Tecla);
    return Patron.test(Te);
}

function numeros(Evento)
{
	Tecla = (document.all) ? Evento.keyCode : Evento.which;
    if (Tecla==0) return true;
	if (Tecla==8) return true;
    Patron =/\d/;
    Te = String.fromCharCode(Tecla);
    return Patron.test(Te);
}

function correoPermitido(Evento){
	Tecla = (document.all) ? Evento.keyCode : Evento.which;
    if (Tecla==0) return true;
	if (Tecla==8) return true;
	Patron =/[\w@.-]/;
    Te = String.fromCharCode(Tecla);
    return Patron.test(Te);
}

function validarRegistro(Formulario){
	var Filtro = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if(Formulario.IdUsuario.value.length==0){
		alert("Asegúrese de ingresar su Documento de Identidad.");
		Formulario.IdUsuario.focus();
	}
	else if(Formulario.NombreUsuario.value.length==0){
		alert("Asegúrese de ingresar sus Nombres.");
		Formulario.NombreUsuario.focus();
	}
	else if(Formulario.ApellidoUsuario.value.length==0){
		alert("Asegúrese de ingresar sus Apellidos.");
		Formulario.ApellidoUsuario.focus();
	}
	else if(Formulario.CorreoUsuario.value.length==0){
		alert("Asegúrese de ingresar su Correo.");
		Formulario.CorreoUsuario.focus();
	}
	else if(!Filtro.test(Formulario.CorreoUsuario.value)){
		alert("Asegúrese de ingresar un Correo válido.\nEj: nombre@dominio.com");
		Formulario.CorreoUsuario.focus();
	}
	else{
		xajax_registrarDocente(xajax.getFormValues(Formulario));
	}
}