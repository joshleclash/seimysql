<?php
	/**
	* Esta funci�n se encarga de guardar las respuestas acertadas de un juego
	* @param integer $RtasCorrectas N�mero de respuestas correctas 
	* @param integer $TotalPreg Total de preguntas
	* @param integer $Tiempo Tiempo que demor� en responder en segundos 
	* @param integer $IdMapa C�digo del mapa 
	* @param integer $IdJuego C�digo del juego 
	* @param string $FuncionReenvio Cadena que contiene la funci�n que debe ser llamada despues de guardar las respuestas
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function guardarRespuestasAcertadas($RtasCorrectas,$TotalPreg,$Tiempo,$IdMapa,$TipoJuego,$FuncionReenvio){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$Conexion = abrirConexion();
		if($TotalPreg=="0"){
			$Respuesta->addAlert("Juego finalizado por el usuario.");
			$Respuesta->addScriptCall($FuncionReenvio);
		}
		else{
			$QueryJuego=mysql_query("SELECT id_juego as id FROM juego WHERE nombre_juego='".$TipoJuego."'");
			if(!$QueryJuego){
				$Respuesta->addAlert("Hubo un error al guardar el resultado. Intente de nuevo m�s tarde");
			}
			else{
				$VecJuego=mysql_fetch_array($QueryJuego);
				$QueryResultado="INSERT INTO historial_juego_respuesta VALUES('".$VecJuego["id"]."','".$IdMapa."','".$_SESSION["NumIdentidad"]."','".$Tiempo."','".date("Y-m-d")."','".$RtasCorrectas."/".$TotalPreg."');";
				if(!mysql_query($QueryResultado)){
					$Respuesta->addAlert("Hubo un error al guardar el historial. Intente de nuevo m�s tarde");
				}
				else{
					$Juego=mysql_fetch_array(mysql_query("SELECT mostrar_status as status FROM juego_mapa WHERE mapa_conceptual_id_mapa_conceptual='".$IdMapa."' AND juego_id_juego='".$VecJuego["id"]."';"));
					if($Juego["status"]=='1'){
						$Texto="\n\nSTATUS FINAL: ".$RtasCorrectas." de ".$TotalPreg."";
					}
					else{
						$Texto="";
					}
					//ya termin� el juego
					$_SESSION["JuegoAbierto"]=0;
					$Respuesta->addAlert("Ha terminado el juego ".$TipoJuego."".$Texto);
					//$Respuesta->addAlert($FuncionReenvio);
					$Respuesta->addScriptCall($FuncionReenvio);
				}
			}
		}
		return $Respuesta;
	}
	$Xajax->registerFunction("guardarRespuestasAcertadas");
?>