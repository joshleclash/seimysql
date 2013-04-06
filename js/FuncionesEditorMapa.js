var contadorcampos=0;
var sumatoria=0;
var hojasactuales=0;
matrizPadre=new Array();
valDurIni="";
valTipoDurIni="";

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
function cargarMapaInicio(){
	nombremapa=document.getElementById('NombreMapa');
	tipoduracion=document.getElementById('TipoIntervaloTiempo');
	tipotematica=document.getElementById('TematicaMapa');
	if(trim(nombremapa.value)==""){
		alert("Escriba un nombre para el mapa conceptual.");
		nombremapa.focus();
	}
	else{
		if(tipotematica.value=="0"){
			alert("Seleccion una tematica.");
			tipotematica.focus();
		}
		else
		{
			if(tipoduracion.value=="0"){
				alert("Defina el intervalo del tiempo del mapa.");
				tipoduracion.focus();
			}
			else{
				if(document.getElementById('NombreTematica')){
					alert("Debe guardar la tematica.");
				}
				else{
					valorduracion=document.getElementById('ValorDuracion').value;
					tematicamapa=document.getElementById('TematicaMapa').value;
					tematica=tematicamapa.split("@");
					document.getElementById("TablaInicial").removeChild(document.getElementById("TablaInicial").firstChild);
					html="<table>";
					html+="<tr><td>Nombre del mapa:&nbsp;<span id='Nombre' onDblClick=\"cargarNombreHoja(this.id);\">"+nombremapa.value+"</span></td></tr>";
					html+="<tr><td>Tem&aacute;tica del mapa:&nbsp;<span id='spanTematica' onDblClick=\"alert('Solo se puede editar en el próximo paso');\">"+tematica[1]+"</span></td></tr>";
					html+="<tr><td>Duraci&oacute;n:&nbsp;<span id='spanDuracion' onDblClick=\"alert('Solo se puede editar en el próximo paso');\">"+valorduracion+"&nbsp;"+tipoduracion.value+"</span></td></tr>";
					html+="<tr><td>Digite el nombre del elemento raiz: <input type='text' name='NomRaiz' id='NomRaiz'></td></tr>";
					html+="<tr><td><button type='button' name='BotonGuardar' onClick=\"validarNombreInicio(document.getElementById('NomRaiz'),'"+nombremapa.value+"','"+valorduracion+"','"+tipoduracion.value+"','"+tematicamapa+"')\">Continuar</button></td></tr>";
					html+="</table>";
					document.getElementById("spaninicio").innerHTML=html;
				}
			}
		}
	}
}
function validarNombreInicio(nomraiz,nombremapa,valorduracion,tipoduracion,tematicamapa){
	if(trim(nomraiz.value)==""){
		alert("Digite un nombre para el elemento raiz");
		nomraiz.focus();
	}
	else{
		tematica=tematicamapa.split("@");
		html="Nombre del mapa:&nbsp;<span id='Nombre' onDblClick=\"cargarNombreHoja(this.id);\">"+nombremapa+"</span><br>";
		html+="Tem&aacute;tica del mapa:&nbsp;<span id='Tematica' onDblClick=\"xajax_cargarComboTematica(this.id,'xajax_cargarEditorMapa','1')\" title='Haga doble click para editar la tematica'>"+tematica[1]+"</span><br>";
		html+="Duraci&oacute;n:&nbsp;<span id='duracion' onDblClick=\"cargarComboDuracion()\" title='Haga doble click para editar'>"+valorduracion+"</span>&nbsp;<span id='spanTipoDuracion' onDblClick=\"cargarComboDuracion()\" title='Haga doble click para editar'>"+tipoduracion+"</span>&nbsp;<a href='javascript:void(0)' id='Vinculo' onClick='cancelarComboDuracion();'></a><input type='hidden' name='TipoIntervaloTiempo' id='TipoIntervaloTiempo' value='"+tipoduracion+"'><input type='hidden' name='txtDuracion' id='txtDuracion' value='"+valorduracion+"'><br>";
		html+="<ul id='Arbol'>";
		html+="<li><input type='hidden' id='Nomen_Raiz' name='Nomen_Raiz' value='1'><span id='NombreRaiz' onDblClick=\"cargarNombreHoja(this.id);\">"+nomraiz.value+"</span>&nbsp;<span id='HojasRaiz'><img id='BotonMenu' src='img/ico_agregar.gif' onClick=\"cargarFormaHojas('HojasRaiz','Raiz');\" title='Haga click aqui para agregar hojas' border='0'/></span>";
		html+="<span id='Raiz'></span>";
		html+="</li></ul><input type='hidden' name='txtTematica' id='txtTematica' value='"+tematica[0]+"'>";
		document.getElementById("spaninicio").innerHTML=html;
		document.getElementById("campoactual").value="Raiz";
	}
}

/*function cargarTextoDescriptivo(id,iddestino){
	html="<textarea id='textodesc' name='textodesc' onBlur=\"mostrarTextoDescriptivo('"+id+"','"+iddestino+"',this.id)\"></textarea>";
	document.getElementById(id).innerHTML=html;
	document.getElementById('textodesc').focus();
}

function mostrarTextoDescriptivo(idinicial,iddestino,id){
	if(document.getElementById(id).innerHTML==""){
		document.getElementById(iddestino).innerHTML="No hay texto descriptivo";
	}
	else{
		document.getElementById(iddestino).innerHTML=document.getElementById(id).innerHTML;
	}
	document.getElementById(idinicial).innerHTML="<img src='img/ico_editar.gif' border='0' onClick=\"cargarTextoDescriptivo(this.id,'TextoDescRaiz')\" title='Haga click aqui para agregar un texto descriptivo'>";
}

function mostrarSpanTextoDesc(idguia,id){
	document.getElementById(id).style.top=document.getElementById(idguia).style.top;
	document.getElementById(id).style.left=document.getElementById(idguia).style.left;
	document.getElementById(id).style.visibility="visible";
}

function ocultarSpanTextoDesc(id){
	document.getElementById(id).style.visibility="hidden";
}*/

function cargarComboDuracion(){
	//estas variables sirven para cuando se da cancelar
	valDurIni=document.getElementById("duracion").innerHTML;
	valTipoDurIni=document.getElementById("spanTipoDuracion").innerHTML;
	document.getElementById("TipoIntervaloTiempo").value="";
	document.getElementById("txtDuracion").value="";
	html="<select name='comboTipoDuracion' onChange='xajax_comboDuracion(this.value,1);'>";
	html+="<option value='Horas'>Horas</option>";
	html+="<option value='Dias'>Dias</option>";
	html+="<option value='Meses'>Meses</option>";
	html+="</select>";
	document.getElementById("spanTipoDuracion").innerHTML=html;
	xajax_comboDuracion('Horas',1);
	document.getElementById("Vinculo").innerHTML="Cancelar";
}

function mostrarValoresDuracion(){
	document.getElementById("TipoIntervaloTiempo").value=document.getElementById("comboTipoDuracion").value;
	document.getElementById("txtDuracion").value=document.getElementById("ValorDuracion").value;
	document.getElementById("duracion").innerHTML=document.getElementById("ValorDuracion").value;
	document.getElementById("spanTipoDuracion").innerHTML=document.getElementById("comboTipoDuracion").value;
	document.getElementById("Vinculo").innerHTML="";
	valDurIni="";
	valTipoDurIni="";
}

function cancelarComboDuracion(){
	document.getElementById("TipoIntervaloTiempo").value=valTipoDurIni;
	document.getElementById("txtDuracion").value=valDurIni;
	document.getElementById("duracion").innerHTML=valDurIni;
	document.getElementById("spanTipoDuracion").innerHTML=valTipoDurIni;
	document.getElementById("Vinculo").innerHTML="";
	valDurIni="";
	valTipoDurIni="";
}

function crearMatriz(nombre){
	eval("matr_"+nombre+"=new Array();");
}

function cargarNombreHoja(id){
	valor=document.getElementById(id).innerHTML;
	if(valor=="[Concepto]"){
		valor="";
	}
	html="<input type='text' id='nombrehoja' maxlength='100' value='"+valor+"' onBlur=\"mostrarNombreHoja('"+id+"',this.id);\">";
	document.getElementById(id).innerHTML=html;
	document.getElementById("BotonGuardarMapa").disabled="disabled";
}

function mostrarNombreHoja(id,campo){
	if(document.getElementById(campo).value==""){
		document.getElementById(id).innerHTML="[Concepto]";
	}
	else{
		document.getElementById(id).innerHTML=document.getElementById(campo).value;
	}
	document.getElementById(id).focus();
	document.getElementById("BotonGuardarMapa").disabled="";
}

function cargarNombreRelacion(id){
	valor=document.getElementById(id).innerHTML;
	if(valor=="[Relacion]"){
		valor="";
	}
	html="<input type='text' id='nombrerel' maxlength='100' value='"+valor+"' onBlur=\"mostrarNombreRelacion('"+id+"',this.id);\">";
	document.getElementById(id).innerHTML=html;
	document.getElementById("BotonGuardarMapa").disabled="disabled";
}

function mostrarNombreRelacion(id,campo){
	if(document.getElementById(campo).value==""){
		document.getElementById(id).innerHTML="[Relacion]";
	}
	else{
		document.getElementById(id).innerHTML=document.getElementById(campo).value;
	}
	document.getElementById(id).focus();
	document.getElementById("BotonGuardarMapa").disabled="";
}

function cargarFormaHojas(id,campo){
	html="<input type='text' id='NumHojas' maxlength='1' onBlur=\"generarHojas('"+id+"',this.id,document.getElementById('campoactual').value);\" onKeyUp=\"generarHojas('"+id+"',this.id,document.getElementById('campoactual').value);\">";
	document.getElementById(id).innerHTML=html;
	document.getElementById('NumHojas').focus();
	document.getElementById("campoactual").value=campo;
	document.getElementById("BotonGuardarMapa").disabled="disabled";
}


function generarHojas(idinicial,idtexto,campo){
	numhoj=document.getElementById(idtexto).value;
	//aqui la idea es que lleve un consecutivo de cada hoja
	contador=0;
	if(campo=="Raiz"){
		contadorcampos=0;
		nuevocampo="";
		document.getElementById(idinicial).innerHTML="<img id='BotonMenu' src='img/ico_agregar.gif' onClick=\"cargarFormaHojas('"+idinicial+"','Raiz');\" title='Haga click aqui para agregar hojas' border='0' style='cursor:pointer;'/>";
	}
	else{
		contadorcampos=matrizPadre.length;
		nuevocampo=campo+"_";
		document.getElementById(idinicial).innerHTML="<img id='BotonMenu' src='img/ico_agregar.gif' onClick=\"cargarFormaHojas('"+idinicial+"','"+campo+"');\" title='Haga click aqui para agregar hojas' border='0' style='cursor:pointer;'/>&nbsp;<img id='BotonMenu' src='img/ico_eliminar.gif' onClick=\"eliminarHoja('"+campo+"');\" title='Haga click aqui para eliminar la hoja' border='0'/>";
	}
	//validamos que sea un numero
	if(trim(numhoj)!=""){
		if(isNaN(numhoj)==true){
			alert("El valor digitado debe ser un número");
		}
		else{
			if(numhoj<=0){
				alert("El valor digitado debe estar entre 1 y 9");
			}
			else{
				html="<ul id='Arbol'>";
				matrizPadre[contadorcampos]=campo;
				crearMatriz(campo);
				for(i=1;i<=numhoj;i++){
					contadorcampos++;
					contador++;
					eval("matr_"+campo+"[i]=nuevocampo+contador;");
					html+="<li id='li_"+nuevocampo+contador+"'>";
					html+="<span class='Relacion' id='relacion_"+nuevocampo+contador+"' title='Haga doble click aqui para editar la relación' onDblClick=\"cargarNombreRelacion(this.id);\">[Relacion]</span>&nbsp;--&#187;&nbsp;";
					html+="<span class='Concepto' id='nom_"+nuevocampo+contador+"' title='Haga doble click aqui para editar el concepto' onDblClick=\"cargarNombreHoja(this.id)\">[Concepto]</span>&nbsp;<span id='menu_"+nuevocampo+contador+"'><img id='BotonMenu' src='img/ico_agregar.gif' onClick=\"cargarFormaHojas('menu_"+nuevocampo+contador+"','"+nuevocampo+contador+"');\" title='Haga click aqui para agregar hojas' border='0'>&nbsp;<img id='BotonMenu' src='img/ico_eliminar.gif' onClick=\"eliminarHoja('"+nuevocampo+contador+"');\" title='Haga click aqui para eliminar la hoja' border='0'/></span>";
					html+="<span id='"+nuevocampo+contador+"'></span>";
					//html+="<span class='TextoDesc' id='texto_"+nuevocampo+contador+"' title='Haga doble click aqui para editar el texto descriptivo' onDblClick=\"cargarNombreHoja(this.id)\">[Concepto]</span>&nbsp;<span id='menu_"+nuevocampo+contador+"'><img id='BotonMenu' src='img/ico_agregar.gif' onClick=\"cargarFormaHojas('menu_"+nuevocampo+contador+"','"+nuevocampo+contador+"');\" title='Haga click aqui para agregar hojas' border='0'>&nbsp;<img id='BotonMenu' src='img/ico_eliminar.gif' onClick=\"eliminarHoja('"+nuevocampo+contador+"');\" title='Haga click aqui para eliminar la hoja' border='0'/></span>";
					html+="</li>";
				}
				html+="</ul>";
				document.getElementById(campo).innerHTML=html;
			}
		}	
	}
	//habilito el boton de Guardar Mapa
	document.getElementById("BotonGuardarMapa").disabled="";
}

function obtenerDatosMapa(){
	conceptos=1;
	relaciones=0;
	if(matrizPadre==0){
		alert("Ingrese por lo menos una hoja al mapa conceptual");
	}
	else{
		//alert(matrizPadre);
		html="<form name='formamapa' id='formamapa'>";
		html+="<input type='hidden' name='TipoDuracion' value='"+document.getElementById("TipoIntervaloTiempo").value+"'>";
		html+="<input type='hidden' name='ValorDuracion' value='"+document.getElementById("txtDuracion").value+"'>";
		html+="<input type='hidden' name='Tematica' value='"+document.getElementById("txtTematica").value+"'>";
		html+="<input type='hidden' name='ValorRaiz' value='"+document.getElementById("NombreRaiz").innerHTML+"'>";
		html+="<input type='hidden' name='CadenaPadres' value='"+matrizPadre+"'>";
		for(cont in matrizPadre){
			padre=matrizPadre[cont];
			eval("vectorPadre=matr_"+padre+";");
			html+="<input type='hidden' name='Hijos_"+padre+"' value='"+vectorPadre+"'>";
			for(contPadre in vectorPadre){
				if(vectorPadre[contPadre]!=""){
					valor=document.getElementById("nom_"+vectorPadre[contPadre]).innerHTML;
					relacion=document.getElementById("relacion_"+vectorPadre[contPadre]).innerHTML;
					html+="<input type='hidden' name='Valor_Nodo_"+vectorPadre[contPadre]+"' value='"+relacion+"@"+valor+"'>";
					conceptos++;
				}
			}
		}
		relaciones=conceptos-1;
		html+="<input type='hidden' name='DatosMapa' value='1,"+document.getElementById("Nombre").innerHTML+","+conceptos+","+relaciones+",0'>";
		html+="</form>";
		document.getElementById("formamatrices").innerHTML=html;
		//modificar para que sea enviado a una funcion XAJAX con getFormValues
		//document.forms["formamapa"].submit();
		xajax_recibirDatosMapa(xajax.getFormValues("formamapa"),null,0);
	}
}
function eliminarHoja(id){
	if(confirm("¿Está seguro de querer eliminar esta hoja?")==true){
		hoja=document.getElementById("li_"+id);
		if(!hoja){
			alert("La hoja seleccionada no existe.");
		}
		else{
			nom=id.replace("li_","");
			eliminarOtrasHojas(nom);
			padre=hoja.parentNode;
			//hacemos superpadre por que padre es un <UL> y no tiene id y necesitamos el id del <SPAN>
			superpadre=padre.parentNode;
			//ahora eliminamos la hoja del vector en el que se encuentra, o sea, de su padre
			eval("vectorPad=matr_"+superpadre.id+";");
			for(cont in vectorPad){
				if(nom==vectorPad[cont]){
					vectorPad.splice(cont,1);
					break;
				}
			}
			padre.removeChild(hoja);
		}
	}
}

function eliminarOtrasHojas(nom){
	for(indPadre in matrizPadre){
		if(nom==matrizPadre[indPadre]){
			eval("vectorPad=matr_"+nom+";");
			matrizPadre.splice(indPadre,1);
			indPadre--;
			for(h in vectorPad){
				eliminarOtrasHojas(vectorPad[h]);
			}
			//matrizPadre[indPadre]="";
			break;
		}
	}
}

function generarHojasEditadas(idinicial,campo,vectorNomHijo,vectorRelHijo,estadomapa){
	numhoj=vectorNomHijo.length-1;
	//aqui la idea es que lleve un consecutivo de cada hoja
	contador=0;
	if(campo=="Raiz"){
		contadorcampos=0;
		nuevocampo="";
		if(estadomapa==0){
			document.getElementById(idinicial).innerHTML="<img id='BotonMenu' src='img/ico_agregar.gif' onClick=\"cargarFormaHojas('"+idinicial+"','Raiz');\" title='Haga click aqui para agregar hojas' border='0' style='cursor:pointer;'/>";
		}
	}
	else{
		contadorcampos=matrizPadre.length;
		nuevocampo=campo+"_";
		if(estadomapa==0){
			document.getElementById(idinicial).innerHTML="<img id='BotonMenu' src='img/ico_agregar.gif' onClick=\"cargarFormaHojas('"+idinicial+"','"+campo+"');\" title='Haga click aqui para agregar hojas' border='0' style='cursor:pointer;'/>&nbsp;<img id='BotonMenu' src='img/ico_eliminar.gif' onClick=\"eliminarHoja('"+campo+"');\" title='Haga click aqui para eliminar la hoja' border='0'/>";
		}	
	}
	//validamos que sea un numero
	if(trim(numhoj)!=""){
		if(isNaN(numhoj)==true){
			alert("El valor digitado debe ser un número");
		}
		else{
			if(numhoj<=0){
				alert("El valor digitado debe estar entre 1 y 9");
			}
			else{
				html="<ul id='Arbol'>";
				matrizPadre[contadorcampos]=campo;
				crearMatriz(campo);
				for(i=1;i<=numhoj;i++){
					contadorcampos++;
					contador++;
					eval("matr_"+campo+"[i]=nuevocampo+contador;");
					html+="<li id='li_"+nuevocampo+contador+"'>";
					//relacion
					html+="<span class='Relacion' id='relacion_"+nuevocampo+contador+"'";
					if(estadomapa==0){
						html+=" onDblClick=\"cargarNombreRelacion(this.id);\" title='Haga doble click aqui para editar la relación'";
					}
					html+=">"+vectorRelHijo[i]+"</span>&nbsp;--&#187;&nbsp;";
					//concepto
					html+="<span class='Concepto' id='nom_"+nuevocampo+contador+"'";
					if(estadomapa==0){
						html+=" onDblClick=\"cargarNombreHoja(this.id);\"  title='Haga doble click aqui para editar el concepto'";
					}
					html+=">"+vectorNomHijo[i]+"</span>&nbsp;";
					if(estadomapa==0){
						html+="<span id='menu_"+nuevocampo+contador+"'><img id='BotonMenu' src='img/ico_agregar.gif' onClick=\"cargarFormaHojas('menu_"+nuevocampo+contador+"','"+nuevocampo+contador+"');\" title='Haga click aqui para agregar hojas' border='0'>&nbsp;<img id='BotonMenu' src='img/ico_eliminar.gif' onClick=\"eliminarHoja('"+nuevocampo+contador+"');\" title='Haga click aqui para eliminar la hoja' border='0'/></span>";
					}
					html+="<span id='"+nuevocampo+contador+"'></span>";
					html+="</li>";
				}
				html+="</ul>";
				document.getElementById(campo).innerHTML=html;
			}
		}	
	}
	//habilito el boton de Guardar Mapa
	document.getElementById("BotonGuardarMapa").disabled="";
}

function obtenerDatosMapaEditado(idmapa){
	conceptos=1;
	relaciones=0;
	if(matrizPadre==0){
		alert("Ingrese por lo menos una hoja al mapa conceptual");
	}
	else{
		html="<form name='formamapaeditado' id='formamapaeditado'>";
		html+="<input type='hidden' name='TipoDuracion' value='"+document.getElementById("TipoIntervaloTiempo").value+"'>";
		html+="<input type='hidden' name='ValorDuracion' value='"+document.getElementById("txtDuracion").value+"'>";
		html+="<input type='hidden' name='Tematica' value='"+document.getElementById("txtTematica").value+"'>";
		html+="<input type='hidden' name='ValorRaiz' value='"+document.getElementById("NombreRaiz").innerHTML+"'>";
		html+="<input type='hidden' name='CadenaPadres' value='"+matrizPadre+"'>";
		for(cont in matrizPadre){
			padre=matrizPadre[cont];
			eval("vectorPadre=matr_"+padre+";");
			html+="<input type='hidden' name='Hijos_"+padre+"' value='"+vectorPadre+"'>";
			for(contPadre in vectorPadre){
				if(vectorPadre[contPadre]!=""){
					contadorconceptos=0;
					valor=document.getElementById("nom_"+vectorPadre[contPadre]).innerHTML;
					relacion=document.getElementById("relacion_"+vectorPadre[contPadre]).innerHTML;
					html+="<input type='hidden' name='Valor_Nodo_"+vectorPadre[contPadre]+"' value='"+relacion+"@"+valor+"'>";
					contadorconceptos++;
					conceptos++;
				}
			}
		}
		relaciones=conceptos-1;
		//HAY QUE OBTENER LA INFORMACION DEL MAPA QUE TENIA
		html+="<input type='hidden' name='DatosMapa' value='1,"+document.getElementById("Nombre").innerHTML+","+conceptos+","+relaciones+",0'>";
		html+="</form>";
		document.getElementById("formamatrices").innerHTML=html;
		//modificar para que sea enviado a una funcion XAJAX con getFormValues
		//document.forms["formamapa"].submit();
		xajax_recibirDatosMapa(xajax.getFormValues("formamapaeditado"),idmapa,1);
	}
}