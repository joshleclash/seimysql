horatotal=0;
mintotal=0;
segtotal=0;
timeOuttotal="";

function iniciarCronometroTotal(hh,mm,ss){
	segtotal=ss;
	mintotal=mm;
	horatotal=hh;
	if(segtotal>59){
		segtotal=0;
		mintotal++;
		if(mintotal>59){
			mintotal=0;
			horatotal++;
		}
	}
	/*if(segundo==0 && minuto==0 && hora==0){
		detenerCronometroMapa();
	}*/
	/*else{
	}*/
	//if(horatotal==2){
	if(horatotal==2){
		xajax_refrescarEstadoMapa();
		horatotal=0;
		mintotal=0;
		segtotal=0;
	}
	segtotal++;
	timeOuttotal=setTimeout("iniciarCronometroTotal("+horatotal+","+mintotal+","+segtotal+")",1000);
}

function detenerCronometroTotal(){
	clearTimeout(timeOuttotal);
}