function cargarInstruccionesJuego(tipojuego){
	switch(tipojuego){
		case 1:
			html="<fieldset>";
			html+="<legend>Juegos - Sopa de Letras - Antes de Jugar</legend>";
			html+="<table width='100%'>";
			html+="<tr>";
			html+="<td><div align='justify'>En el juego <i>Sopa de Letras</i>, el jugador debe encontrar algunas de las palabras clave del mapa que seleccion&oacute;. Aqui no se muestra el listado de palabras a buscar, por lo tanto, el jugador debe tener algun conocimiento del tema para poder resolver el juego.<br><br>Para poder seleccionar una palabra, se debe hacer click en la primera letra de la misma, luego se desplaza el <i>mouse</i> sobre las letras siguientes y se hace click en la &uacute;ltima letra de la palabra. Esto se debe realizar en el estricto orden de la misma, ya que si se selecciona al rev&eacute;s o en desorden, no quedar&aacute; seleccionada. Si selecciona una palabra correcta, dicha palabra quedar&aacute; coloreada, en caso contrario, no quedar&aacute; coloreada.<br><br>NOTA: El no seguir estas instrucciones podr&iacute;a generar inconvenientes en el desarrollo del juego.";
			html+="</div></td></tr>";
			html+="<tr>";
			html+="<td height='10'></td>";
			html+="</tr>";
			html+="<tr align='center'><td><button type='button' name='botonVolver' onClick='xajax_sopaLetrasMapas()'>Volver</button></td></tr>";
			html+="</table>";
			html+="</fieldset>";
			document.getElementById("Contenido").innerHTML=html;
		break;
		case 2:
			html="<fieldset>";
			html+="<legend>Juegos - StandAlone - Antes de Jugar</legend>";
			html+="<table width='100%'>";
			html+="<tr>";
			html+="<td><div align='justify'>En el juego <i>StandAlone</i>, el jugador representa a un soldado que debe rescatar rehenes. Para lograr dicho objetivo, debe responder unas preguntas de multiple opci&oacute;n con &uacute;nica respuesta basadas en el mapa conceptual que haya seleccionado y con el conocimiento previo que tenga en el tema. El juego esta dividido en varios niveles con diferente cantidad de preguntas por nivel.";
			html+="</div></td></tr>";
			html+="<tr>";
			html+="<td height='10'></td>";
			html+="</tr>";
			html+="<tr align='center'><td><button type='button' name='botonVolver' onClick='xajax_standAloneMapas()'>Volver</button></td></tr>";
			html+="</table>";
			html+="</fieldset>";
			document.getElementById("Contenido").innerHTML=html;
		break;
	}
}