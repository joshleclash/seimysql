indicador=false;
campoFila="";
campoColumna="";
fila="";
columna="";
contadorCuadro=0;
contadorCampos=0;
vecCamposUsados=new Array();
vecPalabra=new Array();
palabrasCorrectas=0;
mapa="";
function colorearCampo(cuadro){
	ind=false;
	vectorId=cuadro.split("_");
	if(vectorId[0]==campoFila){
		document.getElementById(cuadro).style.backgroundColor="#FFCC66";
		for(x in vecPalabra){
			if(vecPalabra[x]==cuadro){
				ind=false;
				break;
			}
			else{
				ind=true;
			}
		}
		if(ind==true){
			vecPalabra[contadorCuadro]=cuadro;
		}
	}
	else{
		if(vectorId[1]==campoColumna){
			document.getElementById(cuadro).style.backgroundColor="#FFCC66";
			for(x in vecPalabra){
				if(vecPalabra[x]==cuadro){
					ind=false;
					break;
				}
				else{
					ind=true;
				}
			}
			if(ind==true){
				vecPalabra[contadorCuadro]=cuadro;
			}
		}
	}
}
function interpretarDireccionPalabra(id){
	if(indicador==true){
		vectorId=id.split("_");
		switch(contadorCuadro){
			case 0:
				case 1:
					fila=vectorId[0];
					columna=vectorId[1];
			break;
			case 2:
				if(fila==vectorId[0]){
					campoFila=fila;
				}
				else{
					if(columna==vectorId[1]){
						campoColumna=columna;
					}
				}	
			break;
			default:
			break;
		}
		colorearCampo(id);
		contadorCuadro++;
	}
	else{
		campoFila="";
		campoColumna="";
		fila="";
		columna="";
		contadorCuadro=0;
		vecPalabra=new Array();
	}
}
function cambiarIndicador(id){
	if(indicador==false){
		indicador=true;
		vecPalabra[contadorCuadro]=id;
		interpretarDireccionPalabra(id);
	}
	else{
		indicador=false;
		armarPalabra();
	}
}

function armarPalabra(){
	palabra="";
	pal="";
	pal1="";
	indicadorpalabra=false;
	indicadorgeneral=false;
	idpalabra=0;
	for(i in vecPalabra){
		if(vecPalabra[i]!=""){
			if(document.getElementById(vecPalabra[i]).innerHTML=="&nbsp;"){
				palabra+=" ";
			}
			else{
				palabra+=document.getElementById(vecPalabra[i]).innerHTML;
			}			
		}
	}
	//hay que validar primero si el los id ya fueron usados
	for(i in vecPalabra){
		for(vcu in vecCamposUsados){
			pal=vecCamposUsados[vcu].join(",");
			//alert("primero: "+pal+" - "+vecPalabra[i]);
			if(pal.indexOf(vecPalabra[i])==-1){
				indicadorgeneral=false;
			}
			else{
				indicadorgeneral=true;
				break;
			}
		}
		if(indicadorgeneral==true){
			break;
		}
	}
	if(indicadorgeneral==false){
		//alert(palabra);
		for(vpg in vectorPalabrasGeneral){
			//alert(palabra+" - "+vectorPalabrasGeneral[vpg]);
			if(palabra!=vectorPalabrasGeneral[vpg]){
				indicadorpalabra=false;
			}
			else{
				indicadorpalabra=true;
				idpalabra=vpg;
				break;
			}
		}
		if(indicadorpalabra==false){
			for(i in vecPalabra){
				if(vecPalabra[i]!=""){
					document.getElementById(vecPalabra[i]).style.backgroundColor="";
				}
			}
		}
		else{
			vecCamposUsados[vecCamposUsados.length]=vecPalabra;
			palabrasCorrectas++;
			//document.getElementById("span_"+idpalabra).innerHTML="<img src='img/check.gif' border='0'>";
			document.getElementById("puntuacion").innerHTML=palabrasCorrectas;
			if(palabrasCorrectas==(vectorPalabrasGeneral.length-1)){
				//document.getElementById("letreroFin").innerHTML="JUEGO TERMINADO.";
				//detener cronometro
				detenerCrono("obtenerResultadosSopa",mapa);
			}
		}
	}
	else{
		//sumacamposusados=0;
		//aqui lo que se debe hacer es buscar el id dentro de los id usados uno por uno
		for(i in vecPalabra){
			if(vecPalabra[i]!=""){
				for(vcu in vecCamposUsados){
					pal1=vecCamposUsados[vcu].join(",");
					//alert("segundo: "+pal1+" - "+vecPalabra[i]);
					if(pal1.indexOf(vecPalabra[i])==-1){
						document.getElementById(vecPalabra[i]).style.backgroundColor="";
					}
					else{
						document.getElementById(vecPalabra[i]).style.backgroundColor="#FFCC66";
						break;
					}
				}
			}
		}
	}
	vecPalabra=new Array();
}

function obtenerResultadosSopa(tiempo,idmapa){
	xajax_guardarRespuestasAcertadas(palabrasCorrectas,vectorPalabrasGeneral.length-1,tiempo,idmapa,"Sopa Letras","xajax_sopaLetrasMapas");
}