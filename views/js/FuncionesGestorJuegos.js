tiempoinicial="";
function mostrarCombosTiempo(id,idmapa,idjuego){
	tiempoinicial=document.getElementById(id).innerHTML;
	html="<form name='combostiempo' id='combostiempo'>";
	html+="Horas:&nbsp;<select name='horas' id='horas'>";
	for(h=0;h<=23;h++){
		html+="<option value='"+h+"'>"+h+"</option>";
	}
	html+="</select>";
	html+="&nbsp;Minutos:&nbsp;<select name='minutos' id='minutos'>";
	for(m=1;m<=59;m++){
		html+="<option value='"+m+"'>"+m+"</option>";
	}
	html+="</select>";
	html+="<button type='button' name='boton' onClick=\"xajax_guardarTiempoJuego(xajax.getFormValues('combostiempo'),'"+id+"','"+idmapa+"','"+idjuego+"')\">Guardar</button>";
	html+="<button type='button' name='boton' onClick=\"ocultarCombosJuego('"+id+"')\">Cancelar</button>";
	html+="</form>";
	document.getElementById(id).innerHTML=html;
}

function ocultarCombosJuego(id){
	document.getElementById(id).innerHTML=tiempoinicial;
}

function mostrarComboEstado(id,idmapa,idjuego){
	html="<form name='comboestado' id='comboestado'>";
	html+="<select name='estado' id='estado'  onChange=\"xajax_guardarEstadoJuego(xajax.getFormValues('comboestado'),'"+id+"','"+idmapa+"','"+idjuego+"')\">";
	html+="<option value='-1'>(Seleccione)</option>";
	html+="<option value='0'>Inactivo</option>";
	html+="<option value='1'>Activo</option>";
	html+="</select>";
	html+="</form>";
	/*html+="<button type='button' name='boton' onClick=\"xajax_guardarTiempoJuego(xajax.getFormValues('combostiempo'),'"+id+"','"+idmapa+"','"+idjuego+"')\">Guardar</button>";
	html+="<button type='button' name='boton' onClick=\"ocultarCombosJuego('"+id+"')\">Cancelar</button>";*/
	document.getElementById(id).innerHTML=html;
}

function mostrarComboStatus(id,idmapa,idjuego){
	html="<select name='status' id='status'  onChange=\"xajax_guardarStatusJuego(this.value,'"+id+"','"+idmapa+"','"+idjuego+"')\">";
	html+="<option value='-1'>(Seleccione)</option>";
	html+="<option value='0'>No</option>";
	html+="<option value='1'>Si</option>";
	html+="</select>";
	document.getElementById(id).innerHTML=html;
}