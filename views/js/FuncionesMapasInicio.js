tiempoinicialmap="";
function mostrarCombosTiempoMap(id,idmapa,estado){
	tiempoinicialmap=document.getElementById(id).innerHTML;
	html="<form name='combostiempo' id='combostiempo'>";
	html+="<select name='TipoTiempoMap' id='TipoTiempoMap' onChange='xajax_comboDuracionMapas(this.value)'>";
	html+="<option value='0'>(Seleccione un tipo)</option>";
	html+="<option value='Horas'>Horas</option>";
	html+="<option value='Dias'>Dias</option>";
	html+="<option value='Meses'>Meses</option>";
	html+="</select>";
	html+="<br><span id='SpanCombosMap'></span>";
	html+="<button type='button' name='boton' onClick=\"xajax_guardarTiempoMapa(xajax.getFormValues('combostiempo'),'"+id+"','"+idmapa+"','"+estado+"')\">Guardar</button>";
	html+="<button type='button' name='boton' onClick=\"ocultarCombosTiempoMap('"+id+"')\">Cancelar</button>";
	html+="</form>";
	document.getElementById(id).innerHTML=html;
}

function ocultarCombosTiempoMap(id){
	document.getElementById(id).innerHTML=tiempoinicialmap;
}

function cargarFormaTematica(valor,campo,funcion,tipocombo,campodestino){
	if(valor=="-1"){
		document.getElementById(campo).innerHTML="<input type='text' id='NombreTematica' name='NombreTematica' maxlength='50'\"><button type='button' onClick=\"validarTematica(document.getElementById('NombreTematica').value,'"+funcion+"')\">Guardar</button><button type='button' onClick=\""+funcion+"()\">Cancelar</button>";
	}
	else{
		tematica=valor.split("@");
		//alert(campodestino+" "+tipocombo);
		if(tipocombo==1){
			document.getElementById(campodestino).innerHTML=tematica[1];
			document.getElementById("txtTematica").value=tematica[0];
		}
	}
}

function validarTematica(valor,funcion){
	if(trim(valor)==""){
		eval(funcion+"();");
	}
	else{
		if(confirm("¿Está seguro de guardar la tematica '"+valor+"'?")==true){
			//aqui hay que llevar a la funcion que hace el guardado de la tematica
			xajax_guardarTematica(valor,funcion);
		}
	}
}