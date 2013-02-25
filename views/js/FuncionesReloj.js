hora=0;
minuto=0;
segundo=0;
textoh="";
textom="";
textos="";
timeOut="";
tiempototal=0;

function mostrarCrono(id,hh,mm,ss,funcion,idmapa){
	segundo=ss;
	minuto=mm;
	hora=hh;
	//alert(segundo+" "+minuto+" "+hora);
	if(segundo<0){
		segundo=59;
		minuto--;
		if(minuto<0){
			minuto=59;
			hora--;
		}
	}

	if(segundo<10){
		textos="0"+segundo;
	}
	else{
		textos=""+segundo;
	}
	if(minuto<10){
		textom="0"+minuto;
	}
	else{
		textom=""+minuto;
	}
	if(hora<10){
		textoh="0"+hora;
	}
	else{
		textoh=""+hora;
	}
	horaImprimible = textoh + " : " + textom + " : " + textos
	document.getElementById(id).innerHTML = horaImprimible;
	if(segundo==0 && minuto==0 && hora==0){
		//tiempototal=0;
		detenerCrono(funcion,idmapa);
	}
	else{
		segundo--;
		tiempototal++;
		timeOut=setTimeout("mostrarCrono('"+id+"',"+hora+","+minuto+","+segundo+",'"+funcion+"','"+idmapa+"')",1000);
	}
}

function detenerCrono(funcion,idmapa){
	clearTimeout(timeOut);
	tiempo=tiempototal;
	tiempototal=0;
	if(idmapa==""){
		eval(funcion+"("+tiempo+");");
	}
	else{
		eval(funcion+"("+tiempo+",'"+idmapa+"');");
	}
}