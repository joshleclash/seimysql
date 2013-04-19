<?php
	/**
	* Esta funci�n se encarga de mostrar el listado de mapas conceptuales pertinentes al estudiante
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function standAloneMapas(){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$Conexion = abrirConexion();
		$SqlMapa = "SELECT u.id_usuario, gu.grupo_id_grupo FROM usuario u, grupo_usuario gu WHERE ";
		$SqlMapa.= "gu.grupo_id_grupo IN(SELECT grupo_id_grupo FROM grupo_usuario WHERE ";
		$SqlMapa.= "usuario_id_usuario='".$_SESSION["NumIdentidad"]."') ";
		$SqlMapa.= "AND u.id_usuario=gu.usuario_id_usuario ";
		$SqlMapa.= "AND perfil_id_perfil='1';";
		
		$QueryMapa=mysql_query($SqlMapa);
	
		if(!$QueryMapa){
			$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
			return $Respuesta->getXML();
		}
		$Salida = "<fieldset><legend>Standalone - Listado Mapas Conceptuales</legend>";
		$Salida.= "<table align='left' width='100%'>";
		$Salida.= "<tr align='right'><td colspan='6'><a href='javascript:void(0')' onClick='cargarInstruccionesJuego(2)'><img src='img/ico_editar.gif' border='0'>&nbsp;Instrucciones</a></td></tr>";
		$Salida.= "<tr align='left'><th width='30%'>Nombre Mapa</th><th>Tem&aacute;tica</th><th width='15%'>Estado</th><th>Fecha L&iacute;mite</th><th>Docente</th><th>Grupo</th></tr>";
		while($Vec=mysql_fetch_array($QueryMapa)){
			$Id=$Vec[0];
			$Gr=$Vec[1];
			
			$SqlDoc = "SELECT mc.id_mapa_conceptual, mc.nombre_mapa, mc.estado_mapa, mc.fecha_limite FROM mapa_conceptual mc, juego_mapa jm WHERE ";
			$SqlDoc.= "mc.id_mapa_conceptual IN(SELECT mapa_conceptual_id_mapa FROM grupo_mapa_conceptual WHERE ";
			$SqlDoc.= "grupo_id_grupo='".$Gr."') AND ";
			$SqlDoc.= "mc.usuario_id_usuario='".$Id."' AND ";
			$SqlDoc.= "jm.mapa_conceptual_id_mapa_conceptual=mc.id_mapa_conceptual AND ";
			$SqlDoc.= "jm.juego_id_juego IN(SELECT id_juego FROM juego WHERE nombre_juego='StandAlone') AND ";
			$SqlDoc.= "jm.estado_juego_mapa = '1';";
			
			$QueryDoc=mysql_query($SqlDoc);
			
			if(!$QueryDoc){
				$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
				return $Respuesta->getXML();
			}
			if(mysql_num_rows($QueryDoc)!=0){
				while($VecD=mysql_fetch_array($QueryDoc)){
					$IdMapa=$VecD[0];
					$NomMapa=$VecD[1];
					$EstadoMapa=$VecD[2];
					$FechaLimite=$VecD[3];
					//Verifico el estado del mapa
					if($EstadoMapa=="1"){
						$SqlResp = "SELECT * FROM resultado_pregunta WHERE ";
						$SqlResp.= "relacion_concepto_mapa_conceptual_id_mapa_conceptual='".$IdMapa."' AND ";
						$SqlResp.= "usuario_id_usuario='".$_SESSION["NumIdentidad"]."';";
						
						$QueryResp=mysql_query($SqlResp);
						
						if(!$QueryResp){
							$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
							return $Respuesta->getXML();
						}
						if(mysql_num_rows($QueryResp)==0){                                                    
							$LinkIni="<a href='javascript:;' onClick='xajax_traerNodoRaiz(".$IdMapa.");'>";
							$LinkFin="</a>";
							$EstadoMapa="Habilitado";
						}
						else{
							$LinkIni="";
							$LinkFin="";
							$EstadoMapa="Respondido";
						}
					}
					else{
						$LinkIni="";
						$LinkFin="";
						$EstadoMapa="Deshabilitado";
					}
					//nombre del profesor
					$Nombre="";
					$SqlUsu = "SELECT u.id_usuario as id, u.nombre_usuario as nom, 
					u.apellido_usuario as ape, gu.grupo_id_grupo FROM usuario u, grupo_usuario gu WHERE ";
					$SqlUsu.= "gu.grupo_id_grupo = '".$Gr."' ";
					$SqlUsu.= "AND u.id_usuario=gu.usuario_id_usuario ";
					$SqlUsu.= "AND perfil_id_perfil='1' LIMIT 1;";
					$QueryUsu=mysql_query($SqlUsu);
					if($QueryUsu){
						if(mysql_num_rows($QueryUsu)>0){
							$VecUsu=mysql_fetch_array($QueryUsu);
							$Nombre=ucwords(strtolower($VecUsu["ape"]." ".$VecUsu["nom"]));
						}
					}
					//-------------------
					//nombre grupo
					$NomGrupo=mysql_fetch_array(mysql_query("SELECT nombre_grupo as nom FROM grupo WHERE id_grupo='".$Gr."'"));
					//------------
					//definimos tematica
					$Tema=mysql_fetch_array(mysql_query("SELECT t.nombre_tematica as nom FROM tematica t, mapa_conceptual_tematica mct WHERE t.id_tematica=mct.tematica_id_tematica AND mct.mapa_conceptual_id_mapa_conceptual='".$IdMapa."' LIMIT 1;"));
					//--------
					$Salida.= "<tr align='left'><td>".$LinkIni.ucwords($NomMapa).$LinkFin."</td><td>".ucwords(strtolower($Tema["nom"]))."</td><td>".ucwords($EstadoMapa)."</td><td>".$FechaLimite."</td><td>".$Nombre."</td><td>".$NomGrupo["nom"]."</td></tr>";
				}
			}
			else{
				$Salida.="<tr><td>No hay mapas activos &oacute; el juego no se encuentra activo.</td></tr>";
			}
		}
		$Salida.= "</table>";
		$Respuesta->AddAssign("Contenido","innerHTML",$Salida);
		cerrarConexion($Conexion);
		return $Respuesta->getXML();
	}
	$Xajax->registerFunction('standAloneMapas');
	
	/**
	* Esta funci�n se encarga de traer el primer nodo del mapa seleccionado para dar inicio al juego
	* @param integer $IdMap Codigo del mapa
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function traerNodoRaiz($IdMap){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$Conexion=abrirConexion();
		$SqlVerif = "SELECT COUNT(*) FROM relacion;";
		$QueryVerif = mysql_query($SqlVerif);
		if(!$QueryVerif){
			$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
			$Respuesta->AddScriptCall("xajax_standAloneMapas");
			cerrarConexion($Conexion);
			return $Respuesta->getXML();
		}
		$VecVerif=mysql_fetch_array($QueryVerif);
		if($VecVerif[0]<4){
			$Respuesta->AddAlert("No es posible jugar StandAlone debido a que no hay suficientes elementos en el mapa conceptual.\r\nPor favor comun�quese con el docente encargado");
			$Respuesta->AddScriptCall("xajax_standAloneMapas");
			cerrarConexion($Conexion);
			return $Respuesta->getXML();
		}
		$SqlRaiz = "SELECT concepto_id_concepto FROM relacion WHERE ";
		$SqlRaiz.= "concepto_mapa_conceptual_id_mapa_conceptual = '".$IdMap."' AND ";
		$SqlRaiz.= "concepto_id_concepto NOT IN(SELECT id_concepto_hijo FROM relacion WHERE ";
		$SqlRaiz.= "concepto_mapa_conceptual_id_mapa_conceptual='".$IdMap."');";
		$QueryMatriz=mysql_query($SqlRaiz);
		if(!$QueryMatriz){
			$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
			$Respuesta->AddScriptCall("xajax_standAloneMapas");
			cerrarConexion($Conexion);
			return $Respuesta->getXML();
		}
		$Vec=mysql_fetch_array($QueryMatriz);
		reescribirArchivoTemp();
		//traigo de la BD el dato de tiempo
		$SqlTiempoLim = "SELECT duracion_juego FROM juego_mapa WHERE ";
		$SqlTiempoLim.= "juego_id_juego IN(SELECT id_juego FROM juego WHERE nombre_juego='StandAlone' LIMIT 1) AND ";
		$SqlTiempoLim.= "mapa_conceptual_id_mapa_conceptual='".$IdMap."' LIMIT 1;";
		$QueryTiempoLim = mysql_query($SqlTiempoLim);
		if(!$QueryTiempoLim){
			$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
			$Respuesta->AddScriptCall("xajax_standAloneMapas");
			cerrarConexion($Conexion);
			return $Respuesta->getXML();
		}
		$TiempoLim=mysql_fetch_array($QueryTiempoLim);
		$Hora=explode(":",date("H:i:s",mktime(0,0,$TiempoLim[0])));//el 10 es el valor que se debe traer desde la bd
		$Salida = "<fieldset><legend>Jugando: StandAlone</legend>";
		$Salida.= "<table align='center' width='60%'>";
		$Salida.= "<tr><th colspan='2' id='EspacioNivel'>NIVEL</th></tr>";
		$Salida.= "<tr><td>Tiempo Restante: <span id='EspacioTimer'></span></td>";
		$Salida.= "<td align='right'><a href='javascript:;' onClick=\"detenerCrono('xajax_finalizarStandAlone','".$IdMap."');\">Terminar Juego</a></td></tr>";
		$Salida.= "<tr><td colspan='2' id='EspacioPreg'></td></tr>";
		$Salida.= "</table>";
		$Salida.= "</fieldset>";
		$Respuesta->AddAssign("Contenido","innerHTML",$Salida);
		//llamo funcion inicio timer
		$Respuesta->addScriptCall("mostrarCrono","EspacioTimer",$Hora[0],$Hora[1],$Hora[2],"xajax_finalizarStandAlone",$IdMap);
		//inicio la generacion de preguntas
		$Respuesta->AddScriptCall("xajax_generarPreguntas",$IdMap,$Vec["concepto_id_concepto"],0);
		//ya inicio el juego
		$_SESSION["JuegoAbierto"]=1;
		cerrarConexion($Conexion);
		return $Respuesta->getXML();
	}
	$Xajax->registerFunction('traerNodoRaiz');
	
	/**
	* Esta funci�n se encarga de eliminar y crear el archivo temporal con el id del estudiante para el juego
	*/
	function reescribirArchivoTemp(){
		$Archivo = 'temp/'.$_SESSION["NumIdentidad"].'.php';
		if(file_exists($Archivo)){
			unlink($Archivo);
		}
		$Fp = fopen($Archivo, "w+");
		$String = "<?php\r\n";
		$String.= "	\$MatrizF = array();\r\n";
		$String.= "	\$IdMapaF = '';\r\n";
		$String.= "	\$NivelF = '';\r\n";
		$String.= "?>";
		$Write = fputs($Fp, $String);
		fclose($Fp);
	}
	
	/**
	* Esta funci�n se encarga de eliminar el archivo temporal con el id del estudiante para el juego
	*/
	function eliminarArchivoTemp(){
		$Archivo = 'temp/'.$_SESSION["NumIdentidad"].'.php';
		if(file_exists($Archivo)){
			unlink($Archivo);
		}
	}
	
	/**
	* Esta funci�n se encarga de realizar una recursividad por nivel y llevar la sucesion del juego
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function mainStandAlone(){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		include('temp/'.$_SESSION["NumIdentidad"].'.php');
		$VecHijos = verificarPreguntas($MatrizF,$IdMapaF);
		if(is_array($VecHijos)!=1){
			eliminarArchivoTemp();
			$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
			return $Respuesta->getXML();
		}
		if(count($VecHijos)==0){
			//llamo funcion terminacion timer
			$Respuesta->AddScriptCall("detenerCrono","xajax_finalizarStandAlone",$IdMapaF);
			eliminarArchivoTemp();
			return $Respuesta->getXML();
		}
		$VecPadres = filtroPadres($VecHijos,$IdMapaF);
		if(is_array($VecPadres)!=1){
			eliminarArchivoTemp();
			$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
			return $Respuesta->getXML();
		}
		if(count($VecPadres)==0){
			//llamo funcion terminacion timer
			$Respuesta->AddScriptCall("detenerCrono","xajax_finalizarStandAlone",$IdMapaF);
			eliminarArchivoTemp();
			return $Respuesta->getXML();
		}
		reescribirArchivoTemp();
		$Respuesta->AddScriptCall("xajax_generarPreguntas",$IdMapaF,$VecPadres,$NivelF);
		
		return $Respuesta->getXML();
	}
	$Xajax->registerFunction('mainStandAlone');
	
	/**
	* Esta funci�n se encarga de forzar la terminaci�n del juego
	* @param integer $Duracion Tiempo jugado en segundos
	* @param integer $IdMapa C�digo del mapa
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function finalizarStandAlone($Duracion,$IdMapa){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		//Verifico archivo temporal
		$_SESSION["JuegoAbierto"]=0;
		$Archivo = 'temp/'.$_SESSION["NumIdentidad"].'.php';
		if(file_exists($Archivo)){
			include($Archivo);
			$VecHijos = verificarPreguntas($MatrizF,$IdMapaF);
			eliminarArchivoTemp();
		}
		$Conexion=abrirConexion();
		//Traigo los resultados de las preguntas para el usuario y mapa determinados
		$SqlStandAlone = "SELECT valoracion_pregunta FROM resultado_pregunta WHERE ";
		$SqlStandAlone.= "usuario_id_usuario='".$_SESSION["NumIdentidad"]."' AND ";
		$SqlStandAlone.= "relacion_concepto_mapa_conceptual_id_mapa_conceptual='".$IdMapa."';";
		$QueryStandAlone = mysql_query($SqlStandAlone);
		if(!$QueryStandAlone){
			$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
			cerrarConexion($Conexion);
			return $Respuesta->getXML();
		}
		$Total = mysql_num_rows($QueryStandAlone);
		$Correctas = 0;
		while($Resp = mysql_fetch_array($QueryStandAlone)){
			if($Resp[0]=="t"){
				$Correctas++;
			}
		}
		cerrarConexion($Conexion);
		//Envio los resultados de respuestas a la funcion de guardado de la tabla historial_respuesta
		$Respuesta->AddScriptCall("xajax_guardarRespuestasAcertadas",$Correctas,$Total,$Duracion,$IdMapa,"StandAlone","xajax_standAloneMapas");
		return $Respuesta->getXML();
	}
	$Xajax->registerFunction('finalizarStandAlone');
	
	/**
	* Esta funci�n se encarga de verificar si las respuestas son correctas o no (poda si respondi� incorrecto) y almacenar el resultado en la BD
	* @param string[] $MatrizP Matriz que contiene la informaci�n de las respuestas
	* @param integer $IdMapa C�digo del mapa
	* @return string[] $VecHijo Vector que contiene las respuestas
	*/
	function verificarPreguntas($MatrizP,$IdMapa)
	{
		$Conexion=abrirConexion();
		$VecHijo = array();
		for($Indice=0;$Indice<count($MatrizP);$Indice++){
			switch($MatrizP[$Indice]["tipo"]){
				case "R":
					$SqlData = "SELECT nombre_relacion FROM relacion WHERE ";
					$SqlData.= "concepto_id_concepto='".$MatrizP[$Indice]["rta_correcta"][0]."' AND ";
					$SqlData.= "id_concepto_hijo='".$MatrizP[$Indice]["rta_correcta"][1]."' AND ";
					$SqlData.= "concepto_mapa_conceptual_id_mapa_conceptual='".$IdMapa."' LIMIT 1;";
					$EjecutarQuery=mysql_query($SqlData);
					
					if(!$EjecutarQuery){
						return "Error de conexion de la base de datos.";
					}
					else{
						$VecRespCorrecta=mysql_fetch_array($EjecutarQuery);
						if($MatrizP[$Indice]["rta_usuario"]==$VecRespCorrecta[0]){
							$Resp="true";
							$VecHijo[]=$MatrizP[$Indice]["rta_correcta"][1];
						}
						else{
							$Resp="false";
						}
					}
				break;
				case "C":
					if($MatrizP[$Indice]["rta_usuario"]==$MatrizP[$Indice]["rta_correcta"][1]){
						$Resp="true";
						$VecHijo[]=$MatrizP[$Indice]["rta_correcta"][1];
					}
					else{
						$Resp="false";
					}
				break;
			}
			$SqlInsert = "INSERT INTO resultado_pregunta VALUES('".$_SESSION["NumIdentidad"]."','".$IdMapa."','".$MatrizP[$Indice]["rta_correcta"][0]."','".$MatrizP[$Indice]["rta_correcta"][1]."','".$Resp."');";
			$EjecutarInsert=mysql_query($SqlInsert);
			if(!$EjecutarInsert){
				return "Error de conexion de la base de datos.";
			}
		}
		cerrarConexion($Conexion);
		return $VecHijo;
	}
	
	/**
	* Esta funci�n se encarga de determinar si los nuevos nodos son padres
	* @param string[] $VecResCor Vector que contiene la informaci�n de los conceptos
	* @param integer $IdMapa C�digo del mapa
	* @return string[] $VecPadres Vector que contiene los nodos padres
	*/
	function filtroPadres( $VecResCor, $IdMapa )
	{
		$Conexion=abrirConexion();
		$VecPadres = array();
		foreach($VecResCor as $Valor)
		{
			$Consulta = "SELECT concepto_id_concepto
  						 FROM   relacion
						 WHERE  concepto_mapa_conceptual_id_mapa_conceptual = '".$IdMapa."'
						 AND    concepto_id_concepto = '".$Valor."'
						 LIMIT  1;";
			$Resultado = mysql_query( $Consulta );
			if( $Resultado )
			{
				//Si es padre.
				if( mysql_num_rows($Resultado) != 0 )
				{
					//agregar nuevo vec
					$VecPadres[] = $Valor;
				}
			}
			else
			{
				return "Error de conexion de la base de datos.";
			}
		}
		cerrarConexion($Conexion);
		return $VecPadres;
	}
	
	/**
	* Esta funci�n se encarga de generar las preguntas a partir del vector de padres recibido
	* @param integer $Map C�digo del mapa
	* @param string[] $VecConceptos Vector que contiene la informaci�n de los conceptos
	* @param integer $Nivel N�mero que indica el nivel actual
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function generarPreguntas($Map,$VecConceptos,$Nivel){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$Conexion=abrirConexion();
		//defino los arregos que almacenan los datos de las preguntas
		$Respuesta->AddClear("EspacioNivel","innerHTML");
		$DatosVec = array();
		$VecPregImp = array();
		$Nivel++;
		$Salida = "NIVEL ".$Nivel;
		$Respuesta->AddAssign("EspacioNivel","innerHTML",$Salida);
		for($Pos=0;$Pos<count($VecConceptos);$Pos++){
			$QueryPregunta ="SELECT mc.id_mapa_conceptual as Id_Mapa, c.id_concepto as Id_Padre, c.nombre_concepto as Nom_Padre, ";
			$QueryPregunta.="r.id_concepto_hijo as Id_Hijo, r.nombre_relacion as Relacion ";
			$QueryPregunta.="FROM concepto c, mapa_conceptual mc, relacion r ";
			$QueryPregunta.="WHERE mc.id_mapa_conceptual = c.mapa_conceptual_id_mapa_conceptual ";
			$QueryPregunta.="AND mc.id_mapa_conceptual = r.concepto_mapa_conceptual_id_mapa_conceptual ";
			$QueryPregunta.="AND c.id_concepto = r.concepto_id_concepto ";
			$QueryPregunta.="AND mc.id_mapa_conceptual = '".$Map."' ";
			$QueryPregunta.="AND c.id_concepto='".$VecConceptos[$Pos]."';";
			
			$EjecutarQuery=mysql_query($QueryPregunta);
			if(!$EjecutarQuery){
				$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
				cerrarConexion($Conexion);
				return $Respuesta->getXML();
			}
			if(mysql_num_rows($EjecutarQuery)!=0){
				while($VecPregunta=mysql_fetch_array($EjecutarQuery)){
					//traigo el id de mapa, el id y nombre del concepto padre, id concepto hijo y relacion
					$IdMapa=$VecPregunta[0];
					$IdPadre=$VecPregunta[1];
					$NombrePadre=$VecPregunta[2];
					$IdHijo=$VecPregunta[3];
					$Relacion=$VecPregunta[4];
					$QueryNomConceptoHijo ="SELECT nombre_concepto FROM concepto WHERE ";
					$QueryNomConceptoHijo.="id_concepto='".$IdHijo."' AND mapa_conceptual_id_mapa_conceptual='".$IdMapa."' LIMIT 1;";
					$EjecutarQueryNomConceptoHijo=mysql_query($QueryNomConceptoHijo);
					
					if(!$EjecutarQueryNomConceptoHijo){
						$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
						cerrarConexion($Conexion);
						return $Respuesta->getXML();
					}
					if(mysql_num_rows($EjecutarQueryNomConceptoHijo)!=0){
						//traigo el nombreo concepto hijo
						$VecHijo=mysql_fetch_array($EjecutarQueryNomConceptoHijo);
						$TipoPregunta=rand(1,2);
						//aleatoriamente se genera el tipo de pregunta (conpceto/relacion)
						switch ($TipoPregunta){
						case 1:
							//tipo: Relacion
							//almaceno los datos de la pregunta en en vector VecPregImp
							$VecPregImp[] = $IdPadre;
							$VecPregImp[] = $IdHijo;
							$VecPregImp[] = "R";
							$QueryRespuestasAleatorias = "SELECT DISTINCT a.nombre_relacion, RANDOM() FROM relacion a ";
							$QueryRespuestasAleatorias.= "WHERE a.nombre_relacion <> '".$Relacion."' ";
							$QueryRespuestasAleatorias.= "AND a.concepto_mapa_conceptual_id_mapa_conceptual IN(";
							$QueryRespuestasAleatorias.= "	SELECT b.mapa_conceptual_id_mapa_conceptual FROM mapa_conceptual_tematica b ";
							$QueryRespuestasAleatorias.= "	WHERE b.tematica_id_tematica IN(";
							$QueryRespuestasAleatorias.= "		SELECT c.tematica_id_tematica FROM mapa_conceptual_tematica c ";
							$QueryRespuestasAleatorias.= "		WHERE c.mapa_conceptual_id_mapa_conceptual = '".$IdMapa."')) ";
							$QueryRespuestasAleatorias.= "ORDER BY RANDOM() LIMIT 3;";
							$EjecutarQueryRespuestasAleatorias=mysql_query($QueryRespuestasAleatorias);
							if(!$EjecutarQueryRespuestasAleatorias){
								$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
								cerrarConexion($Conexion);
								return $Respuesta->getXML();
							}
							//traigo 3 nombres de relacion aleatorios de la BD
							//asigno a la primera posicion del vector VecRespuestas la opcion de relacion correcta
							$TotalRand = 3-(mysql_num_rows($EjecutarQueryRespuestasAleatorias));
							$VecRespuestas[0]=$Relacion;
							$Posicion=1;
							//asigno los otros 3 nombres de relacion aleatorios
							while($VecRespuestasAleatoriasQuery=mysql_fetch_array($EjecutarQueryRespuestasAleatorias)){
								$Posicion++;
								$VecRespuestas[$Posicion]=$VecRespuestasAleatoriasQuery[0];
							}
							if($TotalRand>0){
								$VecTempString = array();
								foreach($VecRespuestas as $A){
									$VecTempString[] = "'".$A."'";
								}
								$StringTempResp = implode(",",$VecTempString);
								$QueryRespuestasAleatorias1 = "SELECT DISTINCT nombre_relacion, RANDOM() FROM relacion ";
								$QueryRespuestasAleatorias1.= "WHERE nombre_relacion NOT IN(".$StringTempResp.") ";
								$QueryRespuestasAleatorias1.= "ORDER BY RANDOM() LIMIT ".$TotalRand.";";
								$EjecutarQueryRespuestasAleatorias1 = mysql_query($QueryRespuestasAleatorias1);
								if(!$EjecutarQueryRespuestasAleatorias1){
									$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
									cerrarConexion($Conexion);
									return $Respuesta->getXML();
								}
								while($VecRespuestasAleatoriasQuery1=mysql_fetch_array($EjecutarQueryRespuestasAleatorias1)){
									$Posicion++;
									$VecRespuestas[$Posicion]=$VecRespuestasAleatoriasQuery1[0];
								}
							}
							//reorganizo aleatoriamente el vector de respuestas
							shuffle($VecRespuestas);
							//asigno al vector VecResp el codigo HTML (radio button) con los datos del vector VecRespuestas
							for($P=0;$P<count($VecRespuestas);$P++){
								if($P==0){
									$VecResp[$P]="<input type='radio' name='0' checked value='".$VecRespuestas[$P]."'>".ucwords(strtolower($VecRespuestas[$P]))."<br>";
								}
								else{
									$VecResp[$P]="<input type='radio' name='0' value='".$VecRespuestas[$P]."'>".ucwords(strtolower($VecRespuestas[$P]))."<br>";
								}
							}
							//ingreso los radio buttons en un blockquote
							$Opciones ="<blockquote>";
							while (list(, $Resp) = each ($VecResp)) {
								$Opciones.=$Resp;
							}
							$Opciones.="</blockquote>";
							//Escribo el enunciado de la pregunta
							$Pregunta ="&iquest;Qu&eacute; relaci&oacute;n hay entre '".ucwords(strtolower($NombrePadre))."' y '".ucwords(strtolower($VecHijo[0]))."'?";
							//adiciono el blockquite con los radio buttons
							$Pregunta.=$Opciones;
							//desinstancio los arreglos usados para las respuestas
							unset($VecRespuestas);
							unset($VecResp);
							unset($VecTempString);
							break;
						case 2:
							//tipo: Concepto
							//almaceno los datos de la pregunta en en vector VecPregImp
							$VecPregImp[] = $IdPadre;
							$VecPregImp[] = $IdHijo;
							$VecPregImp[] = "C";
							$QueryRespuestasAleatorias = "SELECT DISTINCT a.nombre_concepto, a.id_concepto, RANDOM() FROM concepto a ";
							$QueryRespuestasAleatorias.= "WHERE a.mapa_conceptual_id_mapa_conceptual IN(";
							$QueryRespuestasAleatorias.= "	SELECT b.mapa_conceptual_id_mapa_conceptual FROM mapa_conceptual_tematica b ";
							$QueryRespuestasAleatorias.= "	WHERE b.tematica_id_tematica IN(";
							$QueryRespuestasAleatorias.= "		SELECT c.tematica_id_tematica FROM mapa_conceptual_tematica c ";
							$QueryRespuestasAleatorias.= "		WHERE c.mapa_conceptual_id_mapa_conceptual = '".$IdMapa."')) ";
							$QueryRespuestasAleatorias.= "AND a.id_concepto NOT IN('".$IdPadre."','".$IdHijo."') ";
							$QueryRespuestasAleatorias.= "AND a.id_concepto NOT IN(";
							$QueryRespuestasAleatorias.= "	SELECT d.id_concepto_hijo FROM relacion d ";
							$QueryRespuestasAleatorias.= "	WHERE d.concepto_mapa_conceptual_id_mapa_conceptual = '".$IdMapa."' ";
							$QueryRespuestasAleatorias.= "	AND d.concepto_id_concepto = '".$IdPadre."') ";
							$QueryRespuestasAleatorias.= "ORDER BY RANDOM() LIMIT 3;";
							$EjecutarQueryRespuestasAleatorias=mysql_query($QueryRespuestasAleatorias);
							if(!$EjecutarQueryRespuestasAleatorias){
								$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
								cerrarConexion($Conexion);
								return $Respuesta->getXML();
							}
							$TotalRand = 3-(mysql_num_rows($EjecutarQueryRespuestasAleatorias));
							//traigo 3 nombres de concepto aleatorios de la BD
							//asigno al primer registro de la matriz VecRespuestas la opcion de relacion correcta y el id correspondiente
							$VecRespuestas[0][0]=$IdHijo;
							$VecRespuestas[0][1]=$VecHijo[0];
							$Posicion=1;
							//asigno los otros 3 nombres de concepto e ids aleatorios
							while($VecRespuestasAleatoriasQuery=mysql_fetch_array($EjecutarQueryRespuestasAleatorias)){
								$Posicion++;
								$VecRespuestas[$Posicion][0]=$VecRespuestasAleatoriasQuery[1];
								$VecRespuestas[$Posicion][1]=$VecRespuestasAleatoriasQuery[0];
							}
							if($TotalRand>0){
								$VecTempRespuesta = array();
								foreach($VecRespuestas as $IdHijoAleatorio){
									$VecTempRespuesta[] = "'".$IdHijoAleatorio[0]."'";
								}
								$StringTempResp = implode(",",$VecTempRespuesta);
								$QueryRespuestasAleatorias1 = "SELECT DISTINCT a.nombre_concepto, a.id_concepto, RANDOM() FROM concepto a ";
								$QueryRespuestasAleatorias1.= "WHERE a.id_concepto NOT IN(".$StringTempResp.") ";
								$QueryRespuestasAleatorias1.= "AND a.id_concepto NOT IN(";
								$QueryRespuestasAleatorias1.= "	SELECT b.id_concepto_hijo FROM relacion b ";
								$QueryRespuestasAleatorias1.= "	WHERE b.concepto_mapa_conceptual_id_mapa_conceptual = '".$IdMapa."' ";
								$QueryRespuestasAleatorias1.= "	AND b.concepto_id_concepto = '".$IdPadre."') ";
								$QueryRespuestasAleatorias1.= "ORDER BY RANDOM() LIMIT ".$TotalRand.";";
								$EjecutarQueryRespuestasAleatorias1 = mysql_query($QueryRespuestasAleatorias1);
								if(!$EjecutarQueryRespuestasAleatorias1){
									$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
									cerrarConexion($Conexion);
									return $Respuesta->getXML();
								}
								while($VecRespuestasAleatoriasQuery1=mysql_fetch_array($EjecutarQueryRespuestasAleatorias1)){
									$Posicion++;
									$VecRespuestas[$Posicion][0]=$VecRespuestasAleatoriasQuery1[1];
									$VecRespuestas[$Posicion][1]=$VecRespuestasAleatoriasQuery1[0];
								}
							}
							//reorganizo aleatoriamente la matriz de respuestas
							shuffle($VecRespuestas);
							//asigno al vector VecResp el codigo HTML (radio button) con los datos de la matriz VecRespuestas
							for($P=0;$P<count($VecRespuestas);$P++){
								if($P==0){
									$VecResp[$P]="<input type='radio' name='0' checked value='".$VecRespuestas[$P][0]."'>".ucwords(strtolower($VecRespuestas[$P][1]))."<br>";
								}
								else{
									$VecResp[$P]="<input type='radio' name='0' value='".$VecRespuestas[$P][0]."'>".ucwords(strtolower($VecRespuestas[$P][1]))."<br>";
								}
							}
							//ingreso los radio buttons en un blockquote
							$Opciones ="<blockquote>";
							while (list(, $Resp) = each ($VecResp)) {
								$Opciones.=$Resp;
							}
							$Opciones.="</blockquote>";
							//Escribo el enunciado de la pregunta
							$Pregunta ="&iquest;".ucwords(strtolower($NombrePadre))." ".ucwords(strtolower($Relacion))." [_____________]?";
							//adiciono el blockquite con los radio buttons
							$Pregunta.=$Opciones;
							//desinstancio los arreglos usados para las respuestas
							unset($VecTempRespuesta);
							unset($VecRespuestas);
							unset($VecResp);
							break;
						}
						//adiciono al vector de datos de pregunta el HTML de la misma
						$VecPregImp[] = $Pregunta;
						//Guardo todo el vector dentro de MatrizPreg
						$MatrizPreg[] = $VecPregImp;
						//limpiamos el vector VecPregImp
						$VecPregImp = array();
					}
					else{
						$Salida.= "No se han encontrado resultados coincidentes para el concepto especificado.<br><br>";
					}
				}
			}
			else{
				$Salida.= "No se han encontrado resultados coincidentes para el mapa y concepto especificados<br><br>";
			}
		}
		//reorganizo aleatoriamente la MatrizPreg
		shuffle($MatrizPreg);
		//llamo la funcion mostrarPregunta para que muestre 1 a 1 las preguntas de la MatrizPreg
		$Respuesta->AddScriptCall("xajax_mostrarPregunta",$MatrizPreg,$Nivel,$IdMapa,1);
		cerrarConexion($Conexion);
		
		return $Respuesta->getXML();
	}
	$Xajax->registerFunction('generarPreguntas');
	
	/**
	* Esta funci�n se encarga de mostrar las preguntas una a una del nivel (recursivo)
	* @param string[] $VecPregImp Vector que contiene la informaci�n de las preguntas
	* @param integer $Nivel N�mero que muestra el nivel actual
	* @param integer $IdMapa C�digo del mapa
	* @param integer $Indice Posicion actual
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function mostrarPregunta($VecPregImp,$Nivel,$IdMapa,$Indice){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$Respuesta->AddClear("EspacioPreg","innerHTML");
		//Verifico si ha terminado las preguntas
		if($Indice==0){
			$Respuesta->AddScriptCall("xajax_mainStandAlone");
			return $Respuesta->getXML();
		}
		$VecPreg = array();
		$Valor = true;
		for($C=0;$C<count($VecPregImp);$C++){
			$VecTemp = $VecPregImp[$C];
			if($VecPregImp[$C]!="" and $Valor==true){
				$Valor = false;
				$Dato = $VecTemp[0]."�".$VecTemp[1]."�".$VecTemp[2];
				$Preg = $Indice.". ".$VecTemp[3];
				$VecPreg[$C] = "";
			}
			elseif($VecPregImp[$C]==""){
				$VecPreg[$C] = "";
			}
			else{
				$VecPreg[$C] = $VecTemp[0]."�".$VecTemp[1]."�".$VecTemp[2]."�".$VecTemp[3];
			}
		}
		$Salida = "<table cellspacing='0' cellpadding='0' align='center' width='100%'>";
		$Salida.= "<tr align='center'><td colspan='2'>";
		$Salida.= "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0' width='500' height='220' align='middle'>";
		$Salida.= "<param name='movie' value='media/animacionStandAlone.swf'>";
		$Salida.= "<param name='quality' value='high'>";
		$Salida.= "<embed align='middle' src='media/animacionStandAlone.swf' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='500' height='220'>";
		$Salida.= "</embed></object>";
		$Salida.= "</td></tr>";
		$Salida.= "<tr valign='top'><td align='left'>";
		$Salida.= "<h5>Contesta la pregunta para rescatar al rehen.</h5>";
		$Salida.= "</td>";
		$Salida.= "<td align='right'>";
		$Salida.= "<h5>Total Preguntas: ".count($VecPregImp)."</h5>";
		$Salida.= "</td></tr>";
		$Salida.= "<tr align='justify'><td colspan='2'>";
		$Salida.= "<form id='FormularioPregunta' name='FormularioPregunta'>";
		$Salida.= $Preg;
		$VecPreg = implode("@",$VecPreg);
		$VecPreg = str_replace('"',"�",$VecPreg);
		$VecPreg = str_replace("'","|",$VecPreg);
		$Salida.= "<div align='center'><input type='button' name='Continuar' id='Continuar' value='Continuar' onClick=\"xajax_escribirArchivo('".$VecPreg."','".$Dato."',xajax.getFormValues(this.form.name),".$IdMapa.",".$Nivel.",".$Indice.");\"></div>";
		$Salida.= "</form>";
		$Salida.= "</td></tr></table>";
		$Respuesta->AddAssign("EspacioPreg","innerHTML",$Salida);
		return $Respuesta->getXML();
	}
	$Xajax->registerFunction('mostrarPregunta');
	
	/**
	* Esta funci�n se encarga de escribir los datos de las respuestas anteriores asi como de la respuesta actual en el archivo temporal
	* @param string[] $Matriz Vector que contiene la informaci�n de las preguntas
	* @param string[] $VecDatos N�mero que muestra el nivel actual
	* @param string $Rta Cadena que contiene la respuesta
	* @param integer $IdMap C�digo del mapa
	* @param integer $Nivel N�mero que indica el nivel actual
	* @param integer $Ind
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function escribirArchivo($Matriz,$VecDatos,$Rta,$IdMap,$Nivel,$Ind){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$Matriz = str_replace("|","'",$Matriz);
		$Martiz = str_replace("�",'"',$Matriz);
		$Matriz = explode("@",$Matriz);
		$VecDatos = explode("�",$VecDatos);
		for($I=0;$I<count($Matriz);$I++){
			if($Matriz[$I]!=""){
				$Vector = explode("�",$Matriz[$I]);
				$Matriz[$I] = $Vector;
			}
		}
		$Archivo = 'temp/'.$_SESSION["NumIdentidad"].'.php';
		include($Archivo);
		$IndiceM = count($MatrizF);
		$MatrizF[$IndiceM]["tipo"] = $VecDatos[2];
		$MatrizF[$IndiceM]["rta_correcta"] = array($VecDatos[0],$VecDatos[1]);
		$MatrizF[$IndiceM]["rta_usuario"] = $Rta[0];
		$Fp = fopen($Archivo, "w+");
		$String = "<?php\r\n";
		for($I=0;$I<count($MatrizF);$I++){
			$String.= "	\$MatrizF[".$I."]['tipo'] = '".$MatrizF[$I]["tipo"]."';\r\n";
			$VecTemporal = $MatrizF[$I]["rta_correcta"];
			$String.= "	\$MatrizF[".$I."]['rta_correcta'] = array('".$VecTemporal[0]."','".$VecTemporal[1]."');\r\n";
			$String.= "	\$MatrizF[".$I."]['rta_usuario'] = '".$MatrizF[$I]["rta_usuario"]."';\r\n\r\n";
		}
		$String.= "	\$IdMapaF = '".$IdMap."';\r\n";
		$String.= "	\$NivelF = '".$Nivel."';\r\n";
		$String.= "?>";
		$Write = fputs($Fp, $String);
		fclose($Fp);
		if(count($Matriz)==$Ind){
			$Ind=0;
		}
		else{
			$Ind++;
		}
		//(recursivo) vuelvo a llamar la funcion de mostrado de preguntas
		$Respuesta->AddScriptCall("xajax_mostrarPregunta",$Matriz,$Nivel,$IdMap,$Ind);
		return $Respuesta->getXML();
	}
	$Xajax->registerFunction('escribirArchivo');
?>