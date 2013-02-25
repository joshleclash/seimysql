<?php
/**
 * Esta función se encarga de devolver el nombre del mes
 * @param string $Num Número del mes
 * @return string Nombre del mes
 */
function devolverMes($Num){
	switch($Num){
		case "01":
			return "Enero";
		case "02":
			return "Febrero";
		case "03":
			return "Marzo";
		case "04":
			return "Abril";
		case "05":
			return "Mayo";
		case "06":
			return "Junio";
		case "07":
			return "Julio";
		case "08":
			return "Agosto";
		case "09":
			return "Septiembre";
		case "10":
			return "Octubre";
		case "11":
			return "Noviembre";
		case "12":
			return "Diciembre";
	}	
}
/**
 * Esta función se encarga de quitar el contenido HTML de los campos especificados
 * @param integer $SpanInicio Numero de el campo inicial a limpiar
 * @param integer $SpanFin Numero de el campo final a limpiar
 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
 */
function limpiarSpanEst($SpanInicio,$SpanFin){
	$Respuesta = new xajaxResponse('ISO-8859-1');
	$Respuesta->addClear("SpanGrafica","innerHTML");
	for($SpanOpcion=$SpanInicio;$SpanOpcion<=$SpanFin;$SpanOpcion++){
		$Respuesta->addClear("Span".$SpanOpcion,"innerHTML");
	}
	return $Respuesta;
}
$Xajax->registerFunction("limpiarSpanEst");

/**
 * Esta función se encarga de mostrar una lista desplegable con los grupos del docente
 * @param integer $NumDocente Número de identificación del docente
 * @param integer $TipoGrafica Código de la gráfica seleccionada
 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
 */
function cargarGruposGrafica($NumDocente,$TipoGrafica){
	$Respuesta = new xajaxResponse('ISO-8859-1');
	$Respuesta->addClear("SpanGrafica","innerHTML");
	$Conexion=abrirConexion();
	$QueryGrupos=pg_query("SELECT id_grupo as id, nombre_grupo as nom FROM grupo WHERE id_grupo IN (SELECT grupo_id_grupo FROM grupo_usuario WHERE usuario_id_usuario='".$NumDocente."') order by id");
	$NumGrupos=pg_num_rows($QueryGrupos);
	if($NumGrupos>0){
		$Salida="<select name='ComboGrupos' onChange=\"xajax_mostrarGrafica('".$NumDocente."','".$TipoGrafica."',this.value,'')\">";
		$Salida.="<option value=''>(Seleccione grupo)</option>";
		while($VecGrupos=pg_fetch_assoc($QueryGrupos)){
			$Salida.="<option value='".$VecGrupos["id"]."'>".ucwords(strtolower($VecGrupos["nom"]))."</option>";
		}
		$Salida.="</select>";
	}
	else{
		$Salida="No hay grupos disponibles.";
	}
	$Respuesta->addAssign("Span".$TipoGrafica,"innerHTML",$Salida);
	cerrarConexion($Conexion);
	return $Respuesta;
}
$Xajax->registerFunction('cargarGruposGrafica');

/**
 * Esta función se encarga de mostrar una lista desplegable con los mapas del docente
 * @param integer $NumDocente Número de identificación del docente
 * @param integer $TipoGrafica Código de la gráfica seleccionada
 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
 */
function cargarMapasGrafica($NumDocente,$TipoGrafica){
	$Respuesta = new xajaxResponse('ISO-8859-1');
	$Conexion=abrirConexion();
	$Respuesta->addClear("SpanGrafica","innerHTML");
	$QueryMapas=pg_query("SELECT id_mapa_conceptual as id, nombre_mapa as nom FROM mapa_conceptual WHERE usuario_id_usuario = '".$NumDocente."' order by id");
	$NumMapas=pg_num_rows($QueryMapas);
	if($NumMapas>0){
		$Salida="<select name='ComboMapas' onChange=\"xajax_mostrarGrafica('".$NumDocente."','".$TipoGrafica."','',this.value)\">";
		$Salida.="<option value=''>(Seleccione un mapa)</option>";
		while($VecMapas=pg_fetch_assoc($QueryMapas)){
			$Salida.="<option value='".$VecMapas["id"]."'>".ucwords(strtolower($VecMapas["nom"]))."</option>";
		}
		$Salida.="</select>";
	}
	else{
		$Salida="No hay mapas disponibles.";
	}
	$Respuesta->addAssign("Span".$TipoGrafica,"innerHTML",$Salida);
	cerrarConexion($Conexion);
	return $Respuesta;
}
$Xajax->registerFunction('cargarMapasGrafica');

/**
 * Esta función se encarga de mostrar una lista desplegable con los grupos del docente
 * @param integer $NumDocente Número de identificación del docente
 * @param integer $TipoGrafica Código de la gráfica seleccionada
 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
 */
function cargarCombosGrafica($NumDocente,$TipoGrafica){
	$Respuesta = new xajaxResponse('ISO-8859-1');
	$Respuesta->addClear("SpanGrafica","innerHTML");
	$Conexion=abrirConexion();
	$QueryGrupos=pg_query("SELECT id_grupo as id, nombre_grupo as nom FROM grupo WHERE id_grupo IN (SELECT grupo_id_grupo FROM grupo_usuario WHERE usuario_id_usuario='".$NumDocente."') order by id");
	$NumGrupos=pg_num_rows($QueryGrupos);
	if($NumGrupos>0){
		if($TipoGrafica==5){
			$Salida="<select name='ComboGrupos' onChange=\"xajax_cargarMapas('".$NumDocente."','".$TipoGrafica."',this.value)\">";
		}
		else{
			$Salida="<select name='ComboGrupos' onChange=\"xajax_cargarEstudiantes('".$NumDocente."','".$TipoGrafica."',this.value)\">";
		}
		$Salida.="<option value=''>(Seleccione grupo)</option>";
		while($VecGrupos=pg_fetch_assoc($QueryGrupos)){
			$Salida.="<option value='".$VecGrupos["id"]."'>".ucwords(strtolower($VecGrupos["nom"]))."</option>";
		}
		$Salida.="</select>";
		if($TipoGrafica==5){
			$Salida.="&nbsp;<span id='spanMapas'></span>";
		}
		else{
			$Salida.="&nbsp;<span id='spanEstudiante'></span>";
		}
	}
	else{
		$Salida="No hay grupos disponibles.";
	}
	$Respuesta->addAssign("Span".$TipoGrafica,"innerHTML",$Salida);
	cerrarConexion($Conexion);
	return $Respuesta;
}
$Xajax->registerFunction('cargarCombosGrafica');

/**
 * Esta función se encarga de mostrar una lista desplegable con los estudiantes del docente segun grupo
 * @param integer $NumDocente Número de identificación del docente
 * @param integer $TipoGrafica Código de la gráfica seleccionada
 * @param integer $IdGrupo Código del grupo seleccionado
 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
 */
function cargarEstudiantes($NumDocente,$TipoGrafica,$IdGrupo){
	$Respuesta = new xajaxResponse('ISO-8859-1');
	$Respuesta->addClear("SpanGrafica","innerHTML");
	if($IdGrupo==""){
		$Respuesta->addAlert("Debe seleccionar un grupo.");
		$Respuesta->addClear("spanEstudiante","innerHTML");
	}
	else{
		$Conexion=abrirConexion();
		$QueryEst=pg_query("SELECT id_usuario as id, nombre_usuario as nom, apellido_usuario as ape FROM usuario WHERE id_usuario IN (SELECT usuario_id_usuario FROM grupo_usuario WHERE grupo_id_grupo='".$IdGrupo."' AND usuario_id_usuario<>'".$NumDocente."') order by id");
		$NumEst=pg_num_rows($QueryEst);
		if($NumEst>0){
			if($TipoGrafica==5 || $TipoGrafica==6){
				$Salida="<select name='ComboEst' onChange=\"xajax_cargarMapas('".$NumDocente."','".$TipoGrafica."','".$IdGrupo."',this.value)\">";
			}
			else{
				$Salida="<select name='ComboEst' onChange=\"xajax_mostrarGrafica('".$NumDocente."','".$TipoGrafica."','".$IdGrupo."','',this.value)\">";
			}
			$Salida.="<option value=''>(Seleccione estudiante)</option>";
			while($VecEst=pg_fetch_assoc($QueryEst)){
				$Salida.="<option value='".$VecEst["id"]."'>".ucwords(strtolower($VecEst["ape"]." ".$VecEst["nom"]))."</option>";
			}
			$Salida.="</select>";
			if($TipoGrafica==5 || $TipoGrafica==6){
				$Salida.="&nbsp;<span id='spanMapas'></span>";
			}
		}
		else{
			$Salida="No hay estudiantes en este grupo.";
		}
		$Respuesta->addAssign("spanEstudiante","innerHTML",$Salida);
		cerrarConexion($Conexion);
	}
	return $Respuesta;
}
$Xajax->registerFunction('cargarEstudiantes');

/**
 * Esta función se encarga de mostrar una lista desplegable con los mapas de un grupo seleccionado
 * @param integer $NumDocente Número de identificación del docente
 * @param integer $TipoGrafica Código de la gráfica seleccionada
 * @param integer $IdGrupo Código del grupo seleccionado
 * @param integer $IdEstudiante Número de identificación del estudiante
 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
 */
function cargarMapas($NumDocente,$TipoGrafica,$IdGrupo,$IdEstudiante=""){
	$Respuesta = new xajaxResponse('ISO-8859-1');
	$Respuesta->addClear("SpanGrafica","innerHTML");
	if($IdGrupo=="" && $TipoGrafica==5){
		$Respuesta->addAlert("Debe seleccionar un mapa.");
		$Respuesta->addClear("spanMapas","innerHTML");
		return $Respuesta;
	}
	if($IdEstudiante=="" && $TipoGrafica==6){
		$Respuesta->addAlert("Debe seleccionar un estudiante.");
		$Respuesta->addClear("spanMapas","innerHTML");
		return $Respuesta;
	}
	if($IdGrupo=="" && $TipoGrafica==6){
		$Respuesta->addAlert("Debe seleccionar un grupo.");
		$Respuesta->addClear("spanEstudiante","innerHTML");
	}
	else{
		$Conexion=abrirConexion();
		$QueryMapas=pg_query("SELECT id_mapa_conceptual as id, nombre_mapa as nom FROM mapa_conceptual WHERE id_mapa_conceptual IN (SELECT mapa_conceptual_id_mapa FROM grupo_mapa_conceptual WHERE grupo_id_grupo='".$IdGrupo."') order by id");
		$NumMapas=pg_num_rows($QueryMapas);
		if($NumMapas>0){
			$Salida="<select name='ComboMapas' onChange=\"xajax_mostrarTablaReportes('".$NumDocente."','".$TipoGrafica."','".$IdGrupo."','".$IdEstudiante."',this.value)\">";
			$Salida.="<option value=''>(Seleccione un mapa)</option>";
			while($VecMapas=pg_fetch_assoc($QueryMapas)){
				$Salida.="<option value='".$VecMapas["id"]."'>".ucwords(strtolower($VecMapas["nom"]))."</option>";
			}
			$Salida.="</select>";
		}
		else{
			$Salida="No hay mapas disponibles.";
		}
		$Respuesta->addAssign("spanMapas","innerHTML",$Salida);
		cerrarConexion($Conexion);
	}
	return $Respuesta;
}
$Xajax->registerFunction('cargarMapas');

/**
 * Esta función se encarga de mostrar una lista desplegable con los tiempos para graficar resultados
 * @param integer $NumDocente Número de identificación del docente
 * @param integer $TipoGrafica Código de la gráfica seleccionada
 * @param integer $IdGrupo Código del grupo seleccionado
 * @param integer $IdEstudiante Número de identificación del estudiante
 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
 */
function cargarTiempo($NumDocente,$TipoGrafica,$IdGrupo,$IdEstudiante){
	$Respuesta = new xajaxResponse('ISO-8859-1');
	$Respuesta->addClear("SpanGrafica","innerHTML");
	if($IdEstudiante==""){
		$Respuesta->addAlert("Debe seleccionar un estudiante.");
		$Respuesta->addClear("SpanTiempo","innerHTML");
	}
	else{
		$Salida="<select name='ComboTiempo' onChange=\"xajax_mostrarGrafica('".$NumDocente."','".$TipoGrafica."','".$IdGrupo."','','".$IdEstudiante."',this.value)\">";
		$Salida.="<option value=''>(Seleccione tiempo)</option>";
		$Salida.="<option value='mensual'>Mensual</option>";
		$Salida.="<option value='trimestral'>Trimestral</option>";
		$Salida.="<option value='semestral'>Semestral</option>";
		$Salida.="</select>";
		$Respuesta->addAssign("SpanTiempo","innerHTML",$Salida);
	}
	return $Respuesta;
}
$Xajax->registerFunction('cargarTiempo');

/**
 * Esta función se encarga de mostrar el grafico estadisticos segun los datosa proporcionados
 * @param integer $NumDocente Número de identificación del docente
 * @param integer $TipoGrafica Código de la gráfica seleccionada
 * @param integer $IdGrupo Código del grupo seleccionado
 * @param integer $IdMapa Código del mapa seleccionado
 * @param integer $IdEstudiante Número de identificación del estudiante
 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
 */
function mostrarGrafica($NumDocente,$TipoGrafica,$IdGrupo,$IdMapa,$IdEstudiante=""){
	$Respuesta = new xajaxResponse('ISO-8859-1');
	$Respuesta->addClear("SpanGrafica","innerHTML");
	//$Respuesta->addAlert($IdGrupo." ".$TipoGrafica);
	if($IdGrupo=="" && $TipoGrafica>1 && $TipoGrafica!=3){
		$Respuesta->addAlert("Debe seleccionar un grupo.");
		return $Respuesta;
	}
	if($IdEstudiante=="" && $TipoGrafica==4){
		$Respuesta->addAlert("Debe seleccionar un estudiante.");
		return $Respuesta;
	}
	$Conexion=abrirConexion();
	$VecLineas=array();
	$MatrizLineas=array();
	$VecSerieHorizontal=array();
	$Indicador=true;
	switch($TipoGrafica){
		case 1:
			//configurar series
			//vertical
			/*for($i=0;$i<=100;$i+=20){
				$VecSerieVertical[]=$i;
			}*/
			//horizontal
			$Mapas=pg_query("SELECT id_mapa_conceptual as id, nombre_mapa as nom FROM mapa_conceptual WHERE usuario_id_usuario='".$NumDocente."' ORDER BY id");
			if($Mapas){
				if(pg_num_rows($Mapas)>0){
					while($vm=pg_fetch_assoc($Mapas)){
						$VecSerieHorizontal[]=$vm["id"]."@".ucwords(strtolower($vm["nom"]));
					}
					$ContGrupos=0;
					//primero debo buscar todos los grupos para medir su rendimiento
					$QueryGrupos=pg_query("SELECT id_grupo as id, nombre_grupo as nom FROM grupo WHERE id_grupo IN (SELECT grupo_id_grupo FROM grupo_usuario WHERE usuario_id_usuario='".$NumDocente."') ORDER BY id");
					if($QueryGrupos){
						$NumGrupos=pg_num_rows($QueryGrupos);
						if($NumGrupos>0){
							while($VecGrupos=pg_fetch_assoc($QueryGrupos)){
								$VecLineas[$ContGrupos]=$VecGrupos["id"]."@".ucwords(strtolower($VecGrupos["nom"]));
								//ahora buscamos los mapas de ese grupo
								$QueryMapas=pg_query("SELECT id_mapa_conceptual as idmapa, nombre_mapa as mapa FROM mapa_conceptual WHERE id_mapa_conceptual IN (SELECT mapa_conceptual_id_mapa FROM grupo_mapa_conceptual WHERE grupo_id_grupo='".$VecGrupos["id"]."')");
								if($QueryMapas){
									$NumMapas=pg_num_rows($QueryMapas);
									if($NumMapas>0){
										$ContMapas=0;
										while($VecMapas=pg_fetch_assoc($QueryMapas)){
											$Promedio=0;
											//ahora traemos los resultados de cada mapa de la tabla historial_juego_respuesta
											$QueryRes=pg_query("SELECT respuestas_acertadas as rtas FROM historial_juego_respuesta WHERE juego_mapa_mapa_conceptual_id_mapa_conceptual='".$VecMapas["idmapa"]."' AND usuario_id_usuario IN (SELECT usuario_id_usuario FROM grupo_usuario WHERE grupo_id_grupo='".$VecGrupos["id"]."' AND usuario_id_usuario <> '".$NumDocente."')");
											if($QueryRes){
												$NumRtas=pg_num_rows($QueryRes);
												if($NumRtas>0){
													while($VecRtas=pg_fetch_assoc($QueryRes)){
														$vr=explode("/",$VecRtas["rtas"]);
														$Promedio+=floor(($vr[0]/$vr[1])*100);
													}
													$Promedio=$Promedio/$NumRtas;
												}
											}
											$MatrizLineas[$ContGrupos][$ContMapas]=$VecMapas["idmapa"]."@".$Promedio;
											$ContMapas++;
										}
									}
								}
								$ContGrupos++;
							}	
						}
						else{
							$Respuesta->addAlert("No hay grupos registrados. Dirijase a Mis Grupos e ingrese un grupo.");
							$Indicador=false;
						}
					}
				}
				else{
					$Respuesta->addAlert("No hay mapas conceptuales registrados. Dirijase a Mis Mapas Conceptuales e ingrese un mapa conceptual.");
					$Indicador=false;
				}
				if($Indicador!==false){
					/*$Respuesta->addAlert(print_r($VecLineas,true));
					$Respuesta->addAlert(print_r($MatrizLineas,true));
					$Respuesta->addAlert(print_r($VecSerieHorizontal,true));*/
					//$RutaGrafica=crearGrafica(1,$VecLineas,$MatrizLineas,$VecSerieHorizontal,$VecSerieVertical);
					$RutaGrafica=crearGrafica(1,$VecLineas,$MatrizLineas,$VecSerieHorizontal);
					//$Respuesta->addAlert(print_r($RutaGrafica,true));
					$Salida="<fieldset>";
					$Salida.="<span align='right'><a href='".$RutaGrafica."' target='_blank'><img src='img/ico_guardar.gif' border='0' title='Haga click aqui para descargar la imagen'></a></span>";
					$Salida.="<img src='".$RutaGrafica."' border='0'>";
					$Salida.="</fieldset>";
					$Respuesta->addAssign("SpanGrafica","innerHTML",$Salida);
				}
				else{
					$Respuesta->addClear("SpanGrafica","innerHTML");
				}
			}
		break;
		case 2:
			if($IdGrupo!=""){
				$Mapas=pg_query("SELECT id_mapa_conceptual as id, nombre_mapa as nom FROM mapa_conceptual WHERE usuario_id_usuario='".$NumDocente."' ORDER BY id");
				if($Mapas){
					if(pg_num_rows($Mapas)>0){
						while($vm=pg_fetch_assoc($Mapas)){
							$VecSerieHorizontal[]=$vm["id"]."@".$vm["nom"];
						}
						$ContGrupos=0;
						//primero debo buscar todos los grupos para medir su rendimiento
						$QueryGrupos=pg_query("SELECT id_usuario as id, nombre_usuario as nom, apellido_usuario	as ape FROM usuario WHERE id_usuario IN (SELECT usuario_id_usuario FROM grupo_usuario WHERE grupo_id_grupo='".$IdGrupo."' AND usuario_id_usuario <> '".$NumDocente."') order by id");
						if($QueryGrupos){
							$NumGrupos=pg_num_rows($QueryGrupos);
							if($NumGrupos>0){
								//$Respuesta->addAlert($NumGrupos);
								while($VecGrupos=pg_fetch_assoc($QueryGrupos)){
									$VecLineas[$ContGrupos]=$VecGrupos["id"]."@".$VecGrupos["nom"]."@".$VecGrupos["ape"];
									//ahora buscamos los mapas de ese grupo
									$QueryMapas=pg_query("SELECT id_mapa_conceptual as idmapa, nombre_mapa as mapa FROM mapa_conceptual WHERE id_mapa_conceptual IN (SELECT mapa_conceptual_id_mapa FROM grupo_mapa_conceptual WHERE grupo_id_grupo='".$IdGrupo."')");
									if($QueryMapas){
										$NumMapas=pg_num_rows($QueryMapas);
										if($NumMapas>0){
											$ContMapas=0;
											while($VecMapas=pg_fetch_assoc($QueryMapas)){
												$Promedio=0;
												//ahora traemos los resultados de cada mapa de la tabla historial_juego_respuesta
												$QueryRes=pg_query("SELECT respuestas_acertadas as rtas FROM historial_juego_respuesta WHERE juego_mapa_mapa_conceptual_id_mapa_conceptual='".$VecMapas["idmapa"]."' AND usuario_id_usuario='".$VecGrupos["id"]."'");
												if($QueryRes){
													$NumRtas=pg_num_rows($QueryRes);
													if($NumRtas>0){
														while($VecRtas=pg_fetch_assoc($QueryRes)){
															$vr=explode("/",$VecRtas["rtas"]);
															$Promedio+=floor(($vr[0]/$vr[1])*100);
														}
														$Promedio=$Promedio/$NumRtas;
													}
												}
												$MatrizLineas[$ContGrupos][$ContMapas]=$VecMapas["idmapa"]."@".$Promedio;
												$ContMapas++;
											}
										}
									}
									$ContGrupos++;
								}	
							}
							else{
								$Respuesta->addAlert("No hay estudiantes registrados en ese grupo. Dirijase a Mis Grupos, seleccione un grupo e ingrese a sus estudiantes.");
								$Indicador=false;
							}
						}
					}
					else{
						$Respuesta->addAlert("No hay mapas conceptuales registrados. Dirijase a Mis Mapas Conceptuales e ingrese un mapa conceptual.");
						$Indicador=false;
					}
					if($Indicador!==false){
						$RutaGrafica=crearGrafica(2,$VecLineas,$MatrizLineas,$VecSerieHorizontal);
						$Salida="<fieldset>";
						$Salida.="<span align='right'><a href='".$RutaGrafica."' target='_blank'><img src='img/ico_guardar.gif' border='0' title='Haga click aqui para descargar la imagen'></a></span>";
						$Salida.="<img src='".$RutaGrafica."' border='0'>";
						$Salida.="</fieldset>";
						$Respuesta->addAssign("SpanGrafica","innerHTML",$Salida);
					}
					else{
						$Respuesta->addClear("SpanGrafica","innerHTML");
					}
				}
			}
			else{
				$Respuesta->addClear("SpanGrafica","innerHTML");
				$Respuesta->addAlert("Debe seleccionar un grupo.");
			}
		break;
		case 3:
			if($IdMapa!=""){
				$ContGrupos=0;
				//traemos todos los grupos que se relacionen con ese mapa y que los grupos pertenezcan al usuario
				$QueryGrupo=pg_query("SELECT id_grupo as id, nombre_grupo as nom FROM grupo WHERE id_grupo IN (SELECT grupo_id_grupo FROM grupo_mapa_conceptual WHERE mapa_conceptual_id_mapa='".$IdMapa."' AND grupo_id_grupo IN (SELECT grupo_id_grupo FROM grupo_usuario WHERE usuario_id_usuario='".$NumDocente."'))");
				if($QueryGrupo){
					if(pg_num_rows($QueryGrupo)>0){
						while($VecGrupo=pg_fetch_assoc($QueryGrupo)){
							//almacenamos en la serie horizontal
							$VecSerieHorizontal[$ContGrupos]=$VecGrupo["id"]."@".$VecGrupo["nom"];
							$Promedio=0;
							//de cada grupo traigo los resultados de cada estudiante
							$QueryEst=pg_query("SELECT respuestas_acertadas as rtas FROM historial_juego_respuesta WHERE juego_mapa_mapa_conceptual_id_mapa_conceptual='".$IdMapa."' AND usuario_id_usuario IN (SELECT usuario_id_usuario FROM grupo_usuario WHERE grupo_id_grupo='".$VecGrupo["id"]."')");
							if($QueryEst){
								$NumRtas=pg_num_rows($QueryEst);
								if($NumRtas>0){
									while($VecEst=pg_fetch_assoc($QueryEst)){
										$vr=explode("/",$VecEst["rtas"]);
										$Promedio+=floor(($vr[0]/$vr[1])*100);
									}
									$Promedio=$Promedio/$NumRtas;
								}
							}
							$MatrizLineas[$ContGrupos]=$Promedio;
							$ContGrupos++;
						}
					}
					else{
						$Respuesta->addAlert("Este mapa no se encuentra asociado con algún grupo. Por favor, dirijase a Mis Grupos y vinculelo con algún grupo disponible.");
						$Indicador=false;
					}
					if($Indicador!==false){
						//$Respuesta->addAlert(print_r($VecLineas,true));
						//$Respuesta->addAlert(print_r($MatrizLineas,true));
						//$Respuesta->addAlert(print_r($VecSerieHorizontal,true));
						//$RutaGrafica=crearGrafica(1,$VecLineas,$MatrizLineas,$VecSerieHorizontal,$VecSerieVertical);
						$RutaGrafica=crearGrafica(3,$VecLineas,$MatrizLineas,$VecSerieHorizontal);
						//$Respuesta->addAlert(print_r($RutaGrafica,true));
						$Salida="<fieldset>";
						$Salida.="<span align='right'><a href='".$RutaGrafica."' target='_blank'><img src='img/ico_guardar.gif' border='0' title='Haga click aqui para descargar la imagen'></a></span>";
						$Salida.="<img src='".$RutaGrafica."' border='0'>";
						$Salida.="</fieldset>";
						$Respuesta->addAssign("SpanGrafica","innerHTML",$Salida);
					}
					else{
						$Respuesta->addClear("SpanGrafica","innerHTML");
					}
				}
			}
			else{
				$Respuesta->addClear("SpanGrafica","innerHTML");
				$Respuesta->addAlert("Debe seleccionar un mapa.");
			}
		break;
		case 4:
			$VecSecHor=array();
			$QueryMeses=pg_query("SELECT distinct (to_char(fecha_realizacion,'YYYY-MM')) as fecha FROM historial_juego_respuesta WHERE usuario_id_usuario='".$IdEstudiante."' AND juego_mapa_mapa_conceptual_id_mapa_conceptual IN (SELECT mapa_conceptual_id_mapa FROM grupo_mapa_conceptual WHERE grupo_id_grupo='".$IdGrupo."')");
			if($QueryMeses){
				if(pg_num_rows($QueryMeses)>0){
					while($VecMes=pg_fetch_assoc($QueryMeses)){
						$Promedio=0;
						$Vm=explode("-",$VecMes["fecha"]);
						$VecSerieHorizontal[]=devolverMes($Vm[1])." - ".$Vm[0];
						$QueryRtas=pg_query("SELECT respuestas_acertadas as rtas FROM historial_juego_respuesta WHERE usuario_id_usuario='".$IdEstudiante."' AND to_char(fecha_realizacion, 'YYYY-MM-DD') like '".$VecMes["fecha"]."-%'");
						$NumRtas=pg_num_rows($QueryRtas);
						if($NumRtas>0){
							while($VecRtas=pg_fetch_assoc($QueryRtas)){
								$vr=explode("/",$VecRtas["rtas"]);
								$Promedio+=floor(($vr[0]/$vr[1])*100);
							}
							$Promedio=$Promedio/$NumRtas;
						}
						$MatrizLineas[]=$Promedio;
					}
				}
				else{
					$Respuesta->addAlert("El estudiante no ha utilizado los juegos o no existen mapas conceptuales asociados con este grupo.");
					$Indicador=false;
				}
				if($Indicador!==false){
					//$Respuesta->addAlert(print_r($VecLineas,true));
					//$Respuesta->addAlert(print_r($MatrizLineas,true));
					//$Respuesta->addAlert(print_r($VecSecHor,true));
					//$RutaGrafica=crearGrafica(1,$VecLineas,$MatrizLineas,$VecSerieHorizontal,$VecSerieVertical);
					$RutaGrafica=crearGrafica(4,$VecLineas,$MatrizLineas,$VecSerieHorizontal);
					//$Respuesta->addAlert(print_r($RutaGrafica,true));
					$Salida="<fieldset>";
					$Salida.="<span align='right'><a href='".$RutaGrafica."' target='_blank'><img src='img/ico_guardar.gif' border='0' title='Haga click aqui para descargar la imagen'></a></span>";
					$Salida.="<img src='".$RutaGrafica."' border='0'>";
					$Salida.="</fieldset>";
					$Respuesta->addAssign("SpanGrafica","innerHTML",$Salida);
				}
				else{
					$Respuesta->addClear("SpanGrafica","innerHTML");
				}
			}
		break;
	}
	cerrarConexion($Conexion);
	return $Respuesta;
}
$Xajax->registerFunction('mostrarGrafica');

/**
 * Esta función se encarga de generar la imagen del grafico segun los datos proporcionados
 * @param integer $TipoGrafica Código de la gráfica seleccionada
 * @param string[] $VecLineas Vector que contiene informacion sobre cada linea de una grafica
 * @param integer[] $MatrizLineas Matriz que contiene los valores a mostrar en la grafica
 * @param string[] $VecSerieHorizontal Vector que contiene los titulos del eje X en la grafica
 * @return $NomArchivo Ruta donde se encuentra la grafica creada
 */
function crearGrafica($TipoGrafica,$VecLineas,$MatrizLineas,$VecSerieHorizontal){
	// Standard inclusions      
	 include("lib/pChart.1.26e/pChart/pData.class");   
	 include("lib/pChart.1.26e/pChart/pChart.class"); 
	switch($TipoGrafica){
		case 1:
			case 2:  
			// Dataset definition 
			 $DataSet = new pData;
			 //lineas
			 $VecMapas=array("");
			 for($Linea=0;$Linea<count($VecLineas);$Linea++){
				$Puntos=array(0);
				$Vl=explode("@",$VecLineas[$Linea]);
				if($TipoGrafica==1){
					$DataSet->SetSerieName($Vl[1],"".$Vl[0]);
				}
				elseif($TipoGrafica==2){
					$DataSet->SetSerieName($Vl[2]." ".$Vl[1],"".$Vl[0]);
				}
				
				 for($i=0;$i<count($VecSerieHorizontal);$i++){
					$Vsh=explode("@",$VecSerieHorizontal[$i]);
					for($m=0;$m<count($MatrizLineas[$Linea]);$m++){
						$Ml=explode("@",$MatrizLineas[$Linea][$m]);
						if($Vsh[0]==$Ml[0]){
							$ValorPunto=$Ml[1];
							break;
						}
						else{
							$ValorPunto=0;
						}
					}
					$Puntos[]=$ValorPunto;
				 }
				 $DataSet->AddPoint($Puntos,"".$Vl[0]);
				 $DataSet->AddSerie("".$Vl[0]);
			 }
			 //return $Vl;
			 foreach($VecSerieHorizontal as $vs){
				$NomSerie=explode("@",$vs);
				$VecMapas[]=$NomSerie[1];
			 }
			 $DataSet->AddPoint($VecMapas,"Mapas");
			 $DataSet->SetAbsciseLabelSerie("Mapas");			
			// Initialise the graph
			 $Test = new pChart(700,230);
			 $Test->setFontProperties("lib/pChart.1.26e/Fonts/tahoma.ttf",10);
			 $Test->setGraphArea(40,30,680,200);
			 $Test->setFixedScale(0,100);//me permite establecer la escala, segun maximo y minimo
			 $Test->drawGraphArea(252,252,252);
			 $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),10,150,150,150,TRUE,0,0);
			 $Test->drawGrid(4,TRUE,230,230,230,255);

			 // Draw the line graph
			 $Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());
			 $Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,255,255,255);

			 // Finish the graph
			 $Test->setFontProperties("lib/pChart.1.26e/Fonts/tahoma.ttf",10);
			 $Test->drawLegend(65,35,$DataSet->GetDataDescription(),255,255,255);
			if($TipoGrafica==1){
				$Test->drawTitle(60,22,"Progreso de grupos con respecto a los mapas",50,50,50,585);
			}
			elseif($TipoGrafica==2){
				$Test->drawTitle(60,22,"Progreso de los estudiantes por grupo con respecto a mapas",50,50,50,585);
			}
			 
			//definimos el nombre del archivo
			$arch=glob("img/Est".$TipoGrafica."_*.png");
			foreach($arch as $ar){
				unlink($ar);
			}
			$NomArchivo="img/Est".$TipoGrafica."_".rand(0,999999999).".png";
			//unlink($NomArchivo);
			 $Test->Render($NomArchivo);
			 //$Test->Stroke()
		break;
		case 3:
			// Dataset definition 
			 $DataSet = new pData;
			 //lineas
			 if(count($VecSerieHorizontal)==1){
				$VecMapas=array("");
				$Puntos=array(0);
			 }
			 elseif(count($VecSerieHorizontal)>1){
				$VecMapas=array();
				$Puntos=array();
			 }
			 
			 for($Barra=0;$Barra<count($VecSerieHorizontal);$Barra++){
				//nombre
				$NomHoriz=explode("@",$VecSerieHorizontal[$Barra]);
				$VecMapas[]=$NomHoriz[1];
				//promedio
				$Puntos[]=$MatrizLineas[$Barra];
			 }
			 $DataSet->SetSerieName("Promedio (%)","Promedios");
			 $DataSet->AddPoint($Puntos,"Promedios");
			 $DataSet->AddSerie("Promedios");
			 $DataSet->AddPoint($VecMapas,"Grupos");
			 $DataSet->SetAbsciseLabelSerie("Grupos");
			// Initialise the graph
			  $Test = new pChart(700,230);
			  $Test->setFontProperties("lib/pChart.1.26e/Fonts/tahoma.ttf",10);
			  $Test->setGraphArea(40,30,680,200);
			  $Test->drawFilledRoundedRectangle(7,7,693,223,5,240,240,240);
			  $Test->drawRoundedRectangle(5,5,695,225,5,230,230,230);
			 $Test->setFixedScale(0,100);//me permite establecer la escala, segun maximo y minimo
			  $Test->drawGraphArea(252,252,252);
			  $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),10,150,150,150,TRUE,0,0,TRUE);
			 $Test->drawGrid(4,TRUE,230,230,230,255);
			  // Draw the bar graph
			  $Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE);
			   // Finish the graph
			  $Test->setFontProperties("lib/pChart.1.26e/Fonts/tahoma.ttf",8);
			  $Test->drawLegend(65,35,$DataSet->GetDataDescription(),255,255,255);
			  $Test->setFontProperties("lib/pChart.1.26e/Fonts/tahoma.ttf",10);
			  $Test->drawTitle(50,22,"Comparación de grupos por mapa",50,50,50,585);
			 
			//definimos el nombre del archivo
			$arch=glob("img/Est".$TipoGrafica."_*.png");
			foreach($arch as $ar){
				unlink($ar);
			}
			$NomArchivo="img/Est".$TipoGrafica."_".rand(0,999999999).".png";
			//unlink($NomArchivo);
			 $Test->Render($NomArchivo);
		break;
		case 4:
			// Dataset definition 
			 $DataSet = new pData;
			 //lineas
			 $VecMapas=array("");
			 $Puntos=array(0);
			 for($Curva=0;$Curva<count($VecSerieHorizontal);$Curva++){
				$VecMapas[]=$VecSerieHorizontal[$Curva];
				//promedio
				$Puntos[]=$MatrizLineas[$Curva];
			 }
			 $VecMapas[]="";
			 $Puntos[]=0;
			 //return $Puntos;
			 $DataSet->SetSerieName("Promedio (%)","Promedios");
			 $DataSet->AddPoint($Puntos,"Promedios");
			 $DataSet->AddSerie("Promedios");
			 $DataSet->AddPoint($VecMapas,"Fechas");
			 $DataSet->SetAbsciseLabelSerie("Fechas");			
			// Initialise the graph
			 $Test = new pChart(700,300);
			 $Test->setFontProperties("lib/pChart.1.26e/Fonts/tahoma.ttf",10);
			 $Test->setGraphArea(40,30,680,200);
			 $Test->setFixedScale(0,100);//me permite establecer la escala, segun maximo y minimo
			 $Test->drawGraphArea(252,252,252);
			 $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),10,150,150,150,TRUE,20,0);
			 $Test->drawGrid(4,TRUE,230,230,230,255);

			 // Draw the line graph
			  //$Test->drawFilledCubicCurve($DataSet->GetData(),$DataSet->GetDataDescription(),.1,50);
			  $Test->drawCubicCurve($DataSet->GetData(),$DataSet->GetDataDescription());

			 // Finish the graph
			 $Test->setFontProperties("lib/pChart.1.26e/Fonts/tahoma.ttf",10);
			 $Test->drawLegend(65,35,$DataSet->GetDataDescription(),255,255,255);
			 $Test->drawTitle(60,22,"Progreso de grupos con respecto a los mapas",50,50,50,585);
			
			//definimos el nombre del archivo
			$arch=glob("img/Est".$TipoGrafica."_*.png");
			foreach($arch as $ar){
				unlink($ar);
			}
			$NomArchivo="img/Est".$TipoGrafica."_".rand(0,999999999).".png";
			//unlink($NomArchivo);
			 $Test->Render($NomArchivo);
			 //$Test->Stroke()
		break;
	}
	return $NomArchivo;
}

/**
 * Esta función se encarga de mostrar un reporte estadistico segun los datos proporcionados
 * @param integer $NumDocente Número de identificación del docente
 * @param integer $TipoGrafica Código de la gráfica seleccionada
 * @param integer $IdGrupo Código del grupo seleccionado
 * @param integer $IdEstudiante Número de identificación del estudiante
  * @param integer $IdMapa Código del mapa seleccionado
 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
 */
function mostrarTablaReportes($NumDocente,$TipoGrafica,$IdGrupo,$IdEstudiante="",$IdMapa){
	$Respuesta = new xajaxResponse('ISO-8859-1');
	$Respuesta->addClear("SpanGrafica","innerHTML");
	if($IdMapa==""){
		$Respuesta->addAlert("Debe seleccionar un mapa.");
		return $Respuesta;
	}
	$Conexion=abrirConexion();
	$VecNombresConceptos=array();
	$VecResultados=array();
	if($TipoGrafica==5){
		//PRIMERO HAY QUE TRAER CONCEPTO POR CONCEPTO DE LA TABLA RELACION Y AHI SI SE HACE LA CONSULTA SIGUIENTE
		$QueryConceptos=pg_query("SELECT concepto_id_concepto as padre, id_concepto_hijo as hijo, nombre_relacion as relacion FROM relacion WHERE concepto_mapa_conceptual_id_mapa_conceptual='".$IdMapa."' order by padre");
		if($QueryConceptos){
			if(pg_num_rows($QueryConceptos)>0){
				while($VecConcepto=pg_fetch_assoc($QueryConceptos)){
					$Promedio=0;
					$ContadorRtas=0;
					//traemos los nombres de los conceptos
					$VecPadre=pg_fetch_assoc(pg_query("SELECT nombre_concepto as nom FROM concepto WHERE id_concepto='".$VecConcepto["padre"]."' AND mapa_conceptual_id_mapa_conceptual = '".$IdMapa."'"));
					$VecHijo=pg_fetch_assoc(pg_query("SELECT nombre_concepto as nom FROM concepto WHERE id_concepto='".$VecConcepto["hijo"]."' AND mapa_conceptual_id_mapa_conceptual = '".$IdMapa."'"));
					$VecNombresConceptos[]=$VecPadre["nom"]." ".$VecConcepto["relacion"]." ".$VecHijo["nom"];
					//ahora se revisa la puntuacion en la tabla resultado_pregunta
					$QueryRta=pg_query("SELECT valoracion_pregunta as rta FROM resultado_pregunta WHERE relacion_concepto_id_concepto='".$VecConcepto["padre"]."' AND relacion_id_concepto_hijo='".$VecConcepto["hijo"]."' AND relacion_concepto_mapa_conceptual_id_mapa_conceptual='".$IdMapa."' AND usuario_id_usuario IN (SELECT usuario_id_usuario FROM grupo_usuario WHERE grupo_id_grupo='".$IdGrupo."')");
					//$Respuesta->addAlert("SELECT valoracion_pregunta as rta FROM resultado_pregunta WHERE relacion_concepto_id_concepto='".$VecConcepto["padre"]."' AND relacion_id_concepto_hijo='".$VecConcepto["hijo"]."' AND usuario_id_usuario IN (SELECT usuario_id_usuario FROM grupo_usuario WHERE grupo_id_grupo='".$IdGrupo."')");
					//como es de grupo hay que sacar del grupo el promedio
					if($QueryRta){
						$NumRtas=pg_num_rows($QueryRta);
						//$Respuesta->addAlert($NumRtas);
						if($NumRtas>0){
							while($VecRta=pg_fetch_assoc($QueryRta)){
								//$Respuesta->addAlert($VecRta["rta"]);
								if($VecRta["rta"]=="t"){
									$ContadorRtas++;
								}
							}
							$Promedio=round(($ContadorRtas/$NumRtas)*100,2);
						}
						$VecResultados[]=$Promedio;
					}
				}
				
				ob_start();
				?>
				<br>
				<table width="100%" align="center" border='1' style="border-collapse:collapse">
				<tr>
				<td colspan="2">
				<?php
					$VecTotales=pg_fetch_assoc(pg_query("select count(distinct r.usuario_id_usuario) as respreg, count(distinct gu.usuario_id_usuario) as grupousu from resultado_pregunta r, grupo_usuario gu WHERE gu.grupo_id_grupo='".$IdGrupo."' AND gu.usuario_id_usuario <> '".$NumDocente."' AND r.relacion_concepto_mapa_conceptual_id_mapa_conceptual='".$IdMapa."'"));
					echo "<b>Estudiantes que respondieron el juego Standalone:&nbsp;".$VecTotales["respreg"]." de ".$VecTotales["grupousu"]."</b>";
					
				?>
				</td>
				</tr>
				<tr>
					<th>Proposici&oacute;n</th><th>Efectividad (%)</th>
				</tr>
				<?php
					for($Vnc=0;$Vnc<count($VecNombresConceptos);$Vnc++){
						echo "<tr>";
						echo "<td>".$VecNombresConceptos[$Vnc]."</td><td>".$VecResultados[$Vnc]."</td>";
						echo "</tr>";
					}
				?>
				</table>
				<?php
				$Salida=ob_get_contents();
				ob_end_clean();
				$Respuesta->addAssign("SpanGrafica","innerHTML",$Salida);
			}
			else{
				$Respuesta->addAlert("Este mapa no se encuentra asociado con algún grupo. Por favor, dirijase a Mis Grupos y vinculelo con algún grupo disponible.");
			}
		}
			
	}
	elseif($TipoGrafica==6){
		$ContadorRtas=0;
		$ContadorNoRta=0;
		//PRIMERO HAY QUE TRAER CONCEPTO POR CONCEPTO DE LA TABLA RELACION Y AHI SI SE HACE LA CONSULTA SIGUIENTE
		$QueryConceptos=pg_query("SELECT concepto_id_concepto as padre, id_concepto_hijo as hijo, nombre_relacion as relacion FROM relacion WHERE concepto_mapa_conceptual_id_mapa_conceptual='".$IdMapa."' order by padre");
		if($QueryConceptos){
			if(pg_num_rows($QueryConceptos)>0){
				while($VecConcepto=pg_fetch_assoc($QueryConceptos)){
					//traemos los nombres de los conceptos
					$VecPadre=pg_fetch_assoc(pg_query("SELECT nombre_concepto as nom FROM concepto WHERE id_concepto='".$VecConcepto["padre"]."' AND mapa_conceptual_id_mapa_conceptual = '".$IdMapa."'"));
					$VecHijo=pg_fetch_assoc(pg_query("SELECT nombre_concepto as nom FROM concepto WHERE id_concepto='".$VecConcepto["hijo"]."' AND mapa_conceptual_id_mapa_conceptual = '".$IdMapa."'"));
					$VecNombresConceptos[]=$VecPadre["nom"]." ".$VecConcepto["relacion"]." ".$VecHijo["nom"];
					//ahora se revisa la puntuacion en la tabla resultado_pregunta
					$QueryRta=pg_query("SELECT valoracion_pregunta as rta FROM resultado_pregunta WHERE relacion_concepto_id_concepto='".$VecConcepto["padre"]."' AND relacion_concepto_mapa_conceptual_id_mapa_conceptual='".$IdMapa."' AND relacion_id_concepto_hijo='".$VecConcepto["hijo"]."' AND usuario_id_usuario = '".$IdEstudiante."'");
					//$Respuesta->addAlert("SELECT valoracion_pregunta as rta FROM resultado_pregunta WHERE relacion_concepto_id_concepto='".$VecConcepto["padre"]."' AND relacion_id_concepto_hijo='".$VecConcepto["hijo"]."' AND usuario_id_usuario IN (SELECT usuario_id_usuario FROM grupo_usuario WHERE grupo_id_grupo='".$IdGrupo."')");
					//como es de grupo hay que sacar del grupo el promedio
					if($QueryRta){
						$NumRtas=pg_num_rows($QueryRta);
						//$Respuesta->addAlert($NumRtas);
						if($NumRtas>0){
							$VecRta=pg_fetch_assoc($QueryRta);
							if($VecRta["rta"]=="t"){
								$ContadorRtas++;
							}
							$VecResultados[]=$VecRta["rta"];
							$ContadorNoRta++;
						}
						else{
							$VecResultados[]="n";
						}
					}
				}
				
				ob_start();
				?>
				<br>
				<table width="100%" align="center" border='1' style="border-collapse:collapse">
				<tr>
				<td colspan="2">
				<?php
					echo "<b>Proposiciones resueltas correctamente:&nbsp;".$ContadorRtas."</b><br>";
					echo "<b>Proposiciones resueltas:&nbsp;".$ContadorNoRta."</b><br>";
					echo "<b>Total de proposiciones:&nbsp;".count($VecNombresConceptos)."</b>";
				?>
				</td>
				</tr>
				<tr>
					<th>Proposici&oacute;n</th><th>Respuesta</th>
				</tr>
				<?php
					for($Vnc=0;$Vnc<count($VecNombresConceptos);$Vnc++){
						echo "<tr>";
						echo "<td>".$VecNombresConceptos[$Vnc]."</td>";
						echo "<td align='center'>";
						switch($VecResultados[$Vnc]){
							case "t":
								echo "<img src='img/ico_check.png' border='0'>";
							break;
							case "f":
								echo "<img src='img/ico_eliminar.gif' border='0'>";
							break;
							case "n":
								echo "No Respondi&oacute;";
							break;
						}
						echo "</td>";
						echo "</tr>";
					}
				?>
				</table>
				<?php
				$Salida=ob_get_contents();
				ob_end_clean();
				$Respuesta->addAssign("SpanGrafica","innerHTML",$Salida);
			}
			else{
				$Respuesta->addAlert("Este mapa no se encuentra asociado con algún grupo. Por favor, dirijase a Mis Grupos y vinculelo con algún grupo disponible.");
			}
		}
			
	}
	
	cerrarConexion($Conexion);
	return $Respuesta;
}
$Xajax->registerFunction('mostrarTablaReportes');
?>