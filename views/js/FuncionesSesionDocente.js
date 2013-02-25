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

function mostrarPerfil(Nombre,Apellido,Perfil,Correo){
	Html="<fieldset>";
	Html+="<legend>Mi Perfil</legend>";
	Html+="<table>\r\n";
	Html+="<tr>\r\n";
	Html+="<td>Nombres:</td><td>"+Nombre+"</td>\r\n";
	Html+="</tr>\r\n";
	Html+="<tr>\r\n";
	Html+="<td>Apellidos:</td><td>"+Apellido+"</td>\r\n";
	Html+="</tr>\r\n";
	Html+="<tr>\r\n";
	Html+="<td>Perfil:</td><td>"+Perfil+"</td>\r\n";
	Html+="</tr>\r\n";
	Html+="<tr>\r\n";
	Html+="<td>Correo electr&oacute;nico:</td><td>"+Correo+"</td>\r\n";
	Html+="</tr>\r\n";
	Html+="<tr>\r\n";
	Html+="<td colspan='2'><a href='javascript:void(0)' onClick=\"cambiarClave();\">Cambiar contrase&ntilde;a</a></td>\r\n";
	Html+="</tr>\r\n";
	Html+="<tr>\r\n";
	Html+="<td colspan='2'><span id='SpanClave'></span></td>\r\n";
	Html+="</tr>\r\n";
	Html+="</table>\r\n";
	Html+="</fieldset>";
	document.getElementById("Contenido").innerHTML=Html;
}

function cambiarClave(){
	Html="<table>\r\n";
	Html+="<tr>\r\n";
	Html+="<td>Contrase&ntilde;a anterior:</td><td><input type='password' name='ClaveAnterior' id='ClaveAnterior'></td>\r\n";
	Html+="</tr>\r\n";
	Html+="<tr>\r\n";
	Html+="<td>Contrase&ntilde;a nueva:</td><td><input type='password' name='ClaveNueva' id='ClaveNueva'></td>\r\n";
	Html+="</tr>\r\n";
	Html+="<tr>\r\n";
	Html+="<td>Confirmar contrase&ntilde;a:</td><td><input type='password' name='ClaveNuevaDos' id='ClaveNuevaDos'></td>\r\n";
	Html+="</tr>\r\n";
	Html+="<tr>\r\n";
	Html+="<td colspan='2'><button type='button' name='Cambiar' id='Cambiar' onClick='verificarClaves();'>Cambiar Contrase&ntilde;a</button></td>\r\n";
	Html+="</tr>\r\n";
	Html+="</table>\r\n";
	document.getElementById("SpanClave").innerHTML=Html;
}

function verificarClaves(){
	ClaveAnt=document.getElementById("ClaveAnterior");
	ClaveUno=document.getElementById("ClaveNueva");
	ClaveDos=document.getElementById("ClaveNuevaDos");
	if(trim(ClaveUno.value)==""){
		alert("Por favor, digite la clave nueva");
		ClaveUno.focus();
	}
	else{
		if(trim(ClaveDos.value)==""){
			alert("Por favor, confirme la clave nueva");
			ClaveDos.focus();
		}
		else{
			if(ClaveUno.value!=ClaveDos.value){
				alert("La clave de confirmación no coincide con la digitada. Por favor, verifique e intente de nuevo.");
				ClaveUno.value="";
				ClaveDos.value="";
				ClaveUno.focus();
			}
			else{
				xajax_cambiarContrasena
(ClaveAnt.value, ClaveUno.value);
			}
		}
	}	
}

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

function validarRegistroEst(Formulario){
	var Filtro = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if(Formulario.IdUsuario.value.length==0){
		alert("Asegúrese de ingresar el Documento de Identidad del Estudiante.");
		Formulario.IdUsuario.focus();
	}
	else if(Formulario.NombreUsuario.value.length==0){
		alert("Asegúrese de ingresar los Nombres del Estudiante.");
		Formulario.NombreUsuario.focus();
	}
	else if(Formulario.ApellidoUsuario.value.length==0){
		alert("Asegúrese de ingresar los Apellidos del Estudiante.");
		Formulario.ApellidoUsuario.focus();
	}
	else if(Formulario.CorreoUsuario.value.length==0){
		alert("Asegúrese de ingresar el Correo del Estudiante.");
		Formulario.CorreoUsuario.focus();
	}
	else if(!Filtro.test(Formulario.CorreoUsuario.value)){
		alert("Asegúrese de ingresar un Correo válido.\nEj: nombre@dominio.com");
		Formulario.CorreoUsuario.focus();
	}
	else{
		xajax_registrarEstudiante(xajax.getFormValues(Formulario));
	}
}

function CargarFormaEstudiante(Docente,Grupo){
	Html="<form name='FormaEst'>\r\n";
	Html+="<table>\r\n";
	Html+="<tr align='center'>";
	Html+="<td>Documento de Identidad:&nbsp;&nbsp;";
	Html+="<input type='text' name='IdUsuario' id='IdUsuario' size='29' onkeypress='return numeros(event);'>";
	Html+="</td>";
	Html+="</tr>";
	Html+="<tr align='center'>";
	Html+="<td>Nombres:&nbsp;";
	Html+="<input type='text' name='NombreUsuario' id='NombreUsuario' size='45' onkeypress='return noNumeros(event);'>";
	Html+="</td>";
	Html+="</tr>";
	Html+="<tr align='center'>";
	Html+="<td>Apellidos:&nbsp;";
	Html+="<input type='text' name='ApellidoUsuario' id='ApellidoUsuario' size='45' onkeypress='return noNumeros(event);'>";
	Html+="</td>";
	Html+="</tr>";
	Html+="<tr align='center'>";
	Html+="<td>Correo:&nbsp;&nbsp;&nbsp;&nbsp;";
	Html+="<input type='text' name='CorreoUsuario' id='CorreoUsuario' size='45' onkeypress='return correoPermitido(event);'>";
	Html+="</td>";
	Html+="</tr>";
	Html+="<tr align='center'>";
	Html+="<td><input type='button' onClick='validarRegistroEst(this.form);' value='Registrar'>&nbsp;&nbsp;&nbsp;&nbsp;";
	Html+="<input type='reset' value='Limpiar Campos'>";
	Html+="</td>";
	Html+="</tr>";
	Html+="</table>\r\n";
	Html+="<input type='hidden' name='IdDocente' value='"+Docente+"'>\r\n";
	Html+="<input type='hidden' name='IdGrupo' value='"+Grupo+"'>\r\n";
	Html+="</form>\r\n";
	document.getElementById("SpanEst").innerHTML=Html;
}

function verificarGrupo(Documento,Forma){
	mapas=new Array();
	cont=0;
	if(navigator.appName!="Microsoft Internet Explorer"){
		Forma=document.forms["FormaGrupo"];
	}
	NomGrupo=Forma.NombreGrupo;
	if(trim(NomGrupo.value)==""){
		alert("Por favor, escriba un nombre para el grupo.");
		NomGrupo.focus();	
	}
	else{
		for(i=0;i<Forma.length;i++){
			if(Forma.elements[i].type=="checkbox"){
				if(Forma.elements[i].checked==true){
					mapas[cont]=Forma.elements[i].id;
					cont++;
				}
			}
		}
		if(mapas.length==0){
			alert("Debe seleccionar un mapa conceptual para asociar al grupo.");
		}
		else{
			cadenamapa=mapas.join(",");
			xajax_guardarGrupo(Documento,xajax.getFormValues(Forma),cadenamapa);
		}
	}
}

function verificarGrupoMapa(Documento,Grupo,Forma){
	mapas=new Array();
	cont=0;
	for(i=0;i<Forma.length;i++){
		if(Forma.elements[i].type=="checkbox"){
			if(Forma.elements[i].checked==true){
				mapas[cont]=Forma.elements[i].id;
				cont++;
			}
		}
	}
	if(mapas.length==0){
		alert("Debe seleccionar un mapa conceptual para asociar al grupo.");
	}
	else{
		cadenamapa=mapas.join(",");
		xajax_actualizarGrupo(Documento,xajax.getFormValues(Forma),cadenamapa,Grupo);
	}
}

function validarFormaMapa(Forma){
	if(navigator.appName!="Microsoft Internet Explorer"){
		Forma=document.forms["FormaMapa"];
	}
	if(Forma.IdTipoMapa.value==""){
		alert("Seleccione el tipo de mapa.");
		Forma.IdTipoMapa.focus();
	}
	else{
		if(Forma.TematicaMapa.value=="0"){
			alert("Por favor, seleccione un temática para subir.");	
		}
		else
		{
			if(trim(Forma.ArchivoMapa.value)==""){
				alert("Por favor, seleccione un archivo para subir.");	
			}
			else{
				if(Forma.NombreTematica){
					alert("Escriba una tematica o haga click sobre el cuadro de texto y luego haga click en cualquier parte del documento.");
				}
				else{
					if(Forma.TipoIntervaloTiempo.value=="0"){
						alert("Por favor, seleccione un intervalo de tiempo.");	
						Forma.TipoIntervaloTiempo.focus();
					}
					else{
						Forma.submit();
					}
				}
			}
		}
	}
}

function confirmarActivacionMapa(id,estado,letrero){
	if(letrero==1){
		textoletrero="\n\nADVERTENCIA:\nSi hace click en Aceptar, NO PODRÁ VOLVER A EDITAR EL MAPA CONCEPTUAL.\nSi aún desea hacer cambios en el mapa, haga click en Cancelar.";
	}
	else{
		textoletrero="";
	}
	if(confirm("¿Está seguro de querer activar el mapa?"+textoletrero)==true){
		if(letrero!=1){
			mostrarCombosTiempoMap('Duracion_'+id,id,estado);
		}
		else{
			xajax_establecerEstadoMapa(id,estado);
		}
	}
}

function confirmarDesactivacionMapa(id,estado){
	if(confirm("¿Está seguro de querer desactivar el mapa?")==true){
		xajax_establecerEstadoMapa(id,estado);
	}
}

function confirmarEliminarGrupo(documento,grupo){
	if(confirm("¿Está seguro de eliminar el grupo?\n\nADVERTENCIA: Si hace click en Aceptar, SE ELIMINARAN TODOS LOS ESTUDIANTES RELACIONADOS CON EL GRUPO SELECCIONADO.\nSi no está seguro, haga click en Cancelar")==true){
		xajax_eliminarGrupo(documento,grupo);
	}
}

function confirmarEliminarEstudiante(documento,grupo,docente){
	if(confirm("¿Está seguro de eliminar este estudiante?")==true){
		xajax_eliminarEstudiante(documento,grupo,docente);
	}
}

function confirmarEliminarMapa(documento,grupo){
	if(confirm("¿Está seguro de eliminar el mapa?")==true){
		xajax_eliminarMapa(documento,grupo);
	}
}