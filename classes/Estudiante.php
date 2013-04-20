<?php
	/**
	 * Esta funci�n se encarga de mostrar los mapas conceptuales que el estudiante aun no ha jugado
	 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	 */
	function recordatorioEstudiante(){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$Conexion = abrirConexion();
		$Respuesta->AddAssign("Contenido","innerHTML","&nbsp;");
		$Salida = "";
		
		$SqlRec = "SELECT a.id_mapa_conceptual, a.nombre_mapa, a.fecha_limite FROM mapa_conceptual a ";
		$SqlRec.= "WHERE a.id_mapa_conceptual IN(";
		$SqlRec.= "		SELECT b.mapa_conceptual_id_mapa FROM grupo_mapa_conceptual b ";
		$SqlRec.= "		WHERE b.grupo_id_grupo IN(";
		$SqlRec.= "				SELECT c.grupo_id_grupo FROM grupo_usuario c ";
		$SqlRec.= "				WHERE c.usuario_id_usuario = '".$_SESSION["NumIdentidad"]."'))";
		$SqlRec.= "AND a.id_mapa_conceptual IN(";
		$SqlRec.= "		SELECT d.mapa_conceptual_id_mapa_conceptual FROM juego_mapa d ";
		$SqlRec.= "		WHERE d.estado_juego_mapa <> '0')";
		$SqlRec.= "AND a.estado_mapa = '1';";
		//echo $SqlRec;
		$QueryRec = mysql_query($SqlRec);
	
		if(!$QueryRec){
			$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
			return $Respuesta->getXML();
		}
		$Salida.= "<fieldset><legend>Inicio</legend>";
		$Salida.= "<table width='85%' align='center'>";
		$Salida.= "<tr align='right'><td><a href='javascript:;' onClick='xajax_rankingEstudiante();'>Ver Mi Ranking</a></td></tr>";
		$Salida.= "<tr><th>RECORDATORIOS<br><br></th></tr>";
		if(mysql_num_rows($QueryRec)==0){
			$Salida.= "<tr><th>No hay recordatorios.</th></tr>";
		}
		else{
			while($VecMap=mysql_fetch_array($QueryRec)){
				$SqlVerif = "SELECT juego_mapa_juego_id_juego FROM historial_juego_respuesta ";
				$SqlVerif.= "WHERE juego_mapa_mapa_conceptual_id_mapa_conceptual = '".$VecMap[0]."' ";
				$SqlVerif.= "AND usuario_id_usuario = '".$_SESSION["NumIdentidad"]."';";
				$QueryVerif = mysql_query($SqlVerif);
	
				if(!$QueryVerif){
					$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
					return $Respuesta->getXML();
				}
				if(mysql_num_rows($QueryVerif)<2){
					$Salida.= "<tr><td align='justify'>A continuaci&oacute;n se enlistan tanto los mapas conceptuales como juegos en los que no has participado.<br><br></td></tr>";
					$Salida.= "<tr><td>";
					$Salida.= "<table align='center' width='100%' border='1' style='border-collapse:collapse;'>";
					$Salida.= "<tr style='background-color:#FFCC66;' align='left' valign='top'><th width='25%' align='left'>Mapa:</th><td>".$VecMap[1]."</td>";
					$Salida.= "<tr align='left' valign='top'><th align='left'>Juegos <span style='font-size:10px;'>(Disponibles)</span> :</th><td>";
					if(mysql_num_rows($QueryVerif)==0){
						$SqlJuego = "SELECT nombre_juego FROM juego;";
						$QueryJuego = mysql_query($SqlJuego);
		
						if(!$QueryJuego){
							$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
							return $Respuesta->getXML();
						}
						while($NomJuego=mysql_fetch_array($QueryJuego)){
							$Salida.= $NomJuego[0]."<br>";
						}
					}
					else{
						while($VecJuego=mysql_fetch_array($QueryVerif)){
							$SqlJuego = "SELECT nombre_juego FROM juego WHERE id_juego <> '".$VecJuego[0]."';";
							$QueryJuego = mysql_query($SqlJuego);
		
							if(!$QueryJuego){
								$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
								return $Respuesta->getXML();
							}
							while($NomJuego=mysql_fetch_array($QueryJuego)){
								$Salida.= $NomJuego[0]."<br>";
							}
						}
					}
					
					$Salida.= "</td></tr>";
					$Salida.= "</table><br><br>";
					$Salida.= "</td></tr>";
				}
				else{
					$Salida.= "<tr><th>No hay recordatorios.</th></tr>";
				}
			}
		}
		$Salida.= "</table>";
		$Salida.= "</td></tr>";
		$Salida.= "</fieldset>";
		cerrarConexion($Conexion);
		$Respuesta->AddAssign("Contenido","innerHTML",$Salida);
		return $Respuesta->getXML();
	}
	$Xajax->registerFunction('recordatorioEstudiante');
	
	/**
	 * Esta funci�n se encarga de mostrar el score del estudiante para todos los grupos a los que pertenece con un porcentaje que determina su posicion en la tabla
	 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	 */
	function rankingEstudiante(){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$Conexion = abrirConexion();
		$Respuesta->AddAssign("Contenido","innerHTML","&nbsp;");
		$Salida = "";
		
		$SqlJuego = "SELECT * FROM juego;";
		$QueryJuego = mysql_query($SqlJuego);
		if(!$QueryJuego){
			$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
			return $Respuesta->getXML();
		}
		$Salida.= "<fieldset><legend>Inicio</legend>";
		$Salida.= "<table width='95%' align='center'>";
		if(mysql_num_rows($QueryJuego)==0){
			$Salida.= "<tr align='right'><td><a href='javascript:;' onClick='xajax_recordatorioEstudiante();'>Ver Recordatorios</a></td></tr>";
			$Salida.= "<tr><th>TABLAS RANKING POR JUEGO<br><br></th></tr>";
			$Salida.= "<tr align='center'><td>No se han encontrado juegos.</td></tr>";
		}
		else{
			$Salida.= "<tr align='right'><td colspan='".mysql_num_rows($QueryJuego)."'><a href='javascript:;' onClick='xajax_recordatorioEstudiante();'>Ver Recordatorios</a></td></tr>";
			$Salida.= "<tr><th colspan='".mysql_num_rows($QueryJuego)."'>TABLAS RANKING POR JUEGO<br><br></th></tr>";
			$Salida.= "<tr><td colspan='".mysql_num_rows($QueryJuego)."' align='justify'>A continuaci&oacute;n se muestran las tablas de ranking por juego para todos los mapas conceptuales del(os) grupo(s) del estudiante.<br><br></td></tr>";
			$Salida.= "<tr valign='top'>";
			while($VecJuego=mysql_fetch_array($QueryJuego)){
				$Vacios = array();
				$Rank = array();
				$Pos1 = 0;
				$Pos2 = 0;
				$SqlEst = "SELECT DISTINCT a.usuario_id_usuario, b.nombre_usuario, b.apellido_usuario FROM grupo_usuario a, usuario b ";
				$SqlEst.= "WHERE b.perfil_id_perfil IN(";
				$SqlEst.= "	SELECT c.id_perfil FROM perfil c ";
				$SqlEst.= "	WHERE c.nombre_perfil = '".$_SESSION["PerfilUsuario"]."' LIMIT 1) ";
				$SqlEst.= "AND a.usuario_id_usuario = b.id_usuario ";
				$SqlEst.= "AND a.grupo_id_grupo IN(";
				$SqlEst.= "	SELECT d.grupo_id_grupo FROM grupo_usuario d ";
				$SqlEst.= "	WHERE d.usuario_id_usuario = '".$_SESSION["NumIdentidad"]."') ";
				$SqlEst.= "ORDER BY a.usuario_id_usuario;";
				$QueryEst = mysql_query($SqlEst);
				if(!$QueryEst){
					$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
					return $Respuesta->getXML();
				}
				if(mysql_num_rows($QueryEst)==0){
					$Salida.= "<td>No se han encontrado estudiantes.</td>";
				}
				else{
					$Salida.= "<td width='50%'>";
					$Salida.= "<table border='1' width='95%' align='center' style='border-collapse:collapse;'>";
					$Salida.= "<tr><th colspan='4'>Juego ".ucwords(strtolower($VecJuego[0]))."</th></tr>";
					$Salida.= "<tr><th>Puesto</th><th>Estudiante</th><th>Valoraci&oacute;n (%)</th><th>Total Mapas</th></tr>";
					while($VecEst=mysql_fetch_array($QueryEst)){
						$SqlRank = "SELECT a.respuestas_acertadas, a.duracion_real FROM historial_juego_respuesta a ";
						$SqlRank.= "WHERE a.usuario_id_usuario = '".$VecEst[0]."' ";
						$SqlRank.= "AND a.juego_mapa_juego_id_juego = '".$VecJuego[1]."';";
						$QueryRank = mysql_query($SqlRank);
						if(!$QueryRank){
							$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
							return $Respuesta->getXML();
						}
						if(mysql_num_rows($QueryRank)==0){
							$Vacios[$Pos1]["val"] = 0;
							$Vacios[$Pos1]["nom"] = $VecEst[2]." ".$VecEst[1];
							$Vacios[$Pos1]["map"] = 0;
							if($VecEst[0]==$_SESSION["NumIdentidad"]){
								$Vacios[$Pos1]["color"] = " style='background-color:#FFCC66;'";
							}
							else{
								$Vacios[$Pos1]["color"] = "";
							}
							$Vacios[$Pos1]["dur"] = 0;
							$Pos1++;
						}
						else{
							$Acumulado = 0;
							$Duracion = 0;
							while($VecRank=mysql_fetch_array($QueryRank)){
								$VecResp = explode("/",$VecRank[0]);
								$Acumulado+= $VecResp[0] / $VecResp[1];
								$Duracion+= $VecRank[1];
							}
							$Valoracion = ($Acumulado / mysql_num_rows($QueryRank))*100;
							$Duracion = $Duracion / mysql_num_rows($QueryRank);
							$Rank[$Pos2]["val"] = round($Valoracion,2);
							$Rank[$Pos2]["nom"] = $VecEst[2]." ".$VecEst[1];
							$Rank[$Pos2]["map"] = mysql_num_rows($QueryRank);
							if($VecEst[0]==$_SESSION["NumIdentidad"]){
								$Rank[$Pos2]["color"] = " style='background-color:#FFCC66;'";
							}
							else{
								$Rank[$Pos2]["color"] = "";
							}
							$Rank[$Pos2]["dur"] = $Duracion;
							$Pos2++;
						}
					}
					for($I = 0; $I < count($Rank); $I++){
						for($J = 0; $J < (count($Rank)-1); $J++){
							if($Rank[$J]["val"] < $Rank[$J+1]["val"] || ($Rank[$J]["val"] == $Rank[$J+1]["val"] && $Rank[$J]["dur"] > $Rank[$J+1]["dur"])){
								$Auxiliar["val"] = $Rank[$J]["val"];
								$Auxiliar["nom"] = $Rank[$J]["nom"];
								$Auxiliar["map"] = $Rank[$J]["map"];
								$Auxiliar["color"] = $Rank[$J]["color"];
								$Auxiliar["dur"] = $Rank[$J]["dur"];
								
								$Rank[$J]["val"] = $Rank[$J+1]["val"];
								$Rank[$J]["nom"] = $Rank[$J+1]["nom"];
								$Rank[$J]["map"] = $Rank[$J+1]["map"];
								$Rank[$J]["color"] = $Rank[$J+1]["color"];
								$Rank[$J]["dur"] = $Rank[$J+1]["dur"];
								
								$Rank[$J+1]["val"] = $Auxiliar["val"];
								$Rank[$J+1]["nom"] = $Auxiliar["nom"];
								$Rank[$J+1]["map"] = $Auxiliar["map"];
								$Rank[$J+1]["color"] = $Auxiliar["color"];
								$Rank[$J+1]["dur"] = $Auxiliar["dur"];
							}
						}
					}
					$PosicionFinal = 0;
					foreach($Rank as $Ordenado){
						$PosicionFinal++;
						$Salida.= "<tr align='center' ".$Ordenado["color"].">";
						$Salida.= "<td>".$PosicionFinal."</td>";
						$Salida.= "<td align='left'>".ucwords(strtolower($Ordenado["nom"]))."</td>";
						$Salida.= "<td>".$Ordenado["val"]."</td>";
						$Salida.= "<td>".$Ordenado["map"]."</td></tr>";
					}
					foreach($Vacios as $OrdenadoV){
						$PosicionFinal++;
						$Salida.= "<tr align='center' ".$OrdenadoV["color"].">";
						$Salida.= "<td>".$PosicionFinal."</td>";
						$Salida.= "<td align='left'>".ucwords(strtolower($OrdenadoV["nom"]))."</td>";
						$Salida.= "<td>".$OrdenadoV["val"]."</td>";
						$Salida.= "<td>".$OrdenadoV["map"]."</td></tr>";
					}
					$Salida.= "</table></td>";
				}
				unset($Rank);
				unset($Vacios);
			}
			$Salida.= "</tr>";
		}
		$Salida.= "</table>";
		cerrarConexion($Conexion);
		$Respuesta->AddAssign("Contenido","innerHTML",$Salida);
		return $Respuesta->getXML();
	}
	$Xajax->registerFunction('rankingEstudiante');
?>
