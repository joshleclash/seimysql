<?php
	$MatrizConcepto=array();
	$Contador=0;
	$PadreActual=0;
	$VectorNumUsados=array();
	$NivelMapa=1;
	//Funcion para . Recibe $PathArchivo y el id del tipo de mapa.
	/**
	* Esta funci�n se encarga de leer el archivo exportable de Knowledge Master
	* @param string $NombreArchivo Ruta del archivo exportable de KM
	* @param integer $TipoMapa C�digo del tipo de mapa
	* @param integer $Duracion Tiempo limite del mapa en segundos 
	* @param integer $Tematica C�digo de la tematica del mapa
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function interpretarMapaConceptual($NombreArchivo, $TipoMapa, $Duracion, $Tematica)
	{
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$archivo = file($NombreArchivo); 
		$Lineas = count($archivo); 
		$LineaVersion = $archivo[0];
		if (strpos($LineaVersion,"v. 13.0")===false)
		{
			if(file_exists($NombreArchivo)){
				unlink($NombreArchivo);
			}
			$Respuesta->AddAlert("El archivo subido es incorrecto. Favor utilizar la version 13.0 del Knowledge Master.");
		}
		else
		{
			$LineaConceptos=$archivo[4];
			$LineaRelaciones=$archivo[5];
			$LineaNombreMapa=$archivo[2];
			//Leo el nombre del mapa conceptual.
			list($Resto, $TempNombreMapa) = explode(': "',$LineaNombreMapa,2);
			list($NombreMapa,$Resto) = explode('" (',$TempNombreMapa);
			//Leo la cantidad de conceptos.
			list($Resto,$Conceptos) = explode(": ",$LineaConceptos);
			//Leo la cantidad de relaciones.
			list($Resto,$Relaciones) = explode(": ",$LineaRelaciones);
			$ContConcepto=0;
			for($Cont=11;$Cont<$Lineas-4;$Cont++)
			{
				$Concepto[$ContConcepto]["TextoDesc"]="";
				$ContEspacios=0;
				$VecTemp=str_split($archivo[$Cont]);
				while( strcmp($VecTemp[$ContEspacios]," ")== 0 )
				{
					$ContEspacios++;
				}
				//verificar si es numero o letra la siguiente posision.
				if( is_numeric( $VecTemp[$ContEspacios] ) )
				{
					$Concepto[$ContConcepto]["EspaciosPre"]=$ContEspacios;
					if($Cont==11)
					{
						list($Resto,$ConcetoUno)=explode("1", $archivo[$Cont]);
						$Concepto[$ContConcepto]["NumConcepto"]=1;
						$Concepto[$ContConcepto]["NomConcepto"]=$ConcetoUno;
						$Concepto[$ContConcepto]["RelacionUp"]="";
						$Concepto[$ContConcepto]["NumRelacionUp"]="";
					}
					else
					{
						//Leer hasta el "<" y coger la relacion. Toca comparar los espacios hasta q dependa o sea el proximo.
						$archivo[$Cont]=ltrim($archivo[$Cont]);
						$archivo[$Cont]=rtrim($archivo[$Cont]);
						list($NumConRelacion,$NomConcepto)=explode(">", $archivo[$Cont]);
						list($NumConcepto,$Relacion)=explode("<",$NumConRelacion);
						$ContConceptoTemp = $ContConcepto-1;
						while(($Concepto[$ContConcepto]["EspaciosPre"]-3) != $Concepto[$ContConceptoTemp]["EspaciosPre"])
						{
							$ContConceptoTemp--;
						}
						$Concepto[$ContConcepto]["NumConcepto"]=$NumConcepto;
						$Concepto[$ContConcepto]["NomConcepto"]=$NomConcepto;
						$Concepto[$ContConcepto]["RelacionUp"]=$Relacion;
						$Concepto[$ContConcepto]["NumRelacionUp"]=$Concepto[$ContConceptoTemp]["NumConcepto"];
					}
					$ContConcepto++;
				}
				//entonces es Letra.
				else
				{
						$Concepto[$ContConcepto-1]["TextoDesc"].=$archivo[$Cont];
						$Concepto[$ContConcepto-1]["TextoDesc"].=" ";
				}
			}
			$InfoGeneralConcepto["TipoMapa"]=$TipoMapa;
			$InfoGeneralConcepto["EstadoMapa"]="0";
			$InfoGeneralConcepto["Conceptos"]=$Conceptos;
			$InfoGeneralConcepto["Relaciones"]=$Relaciones;
			$InfoGeneralConcepto["NombreMapa"]=$NombreMapa;
			$Tema=explode("@",$Tematica);
			$RtaMapa=guardarMapaConceptual($Concepto,$InfoGeneralConcepto,$Duracion,$Tema[0]);
			if($RtaMapa===true)
			{
				$Respuesta->addAlert("El archivo ha sido subido con �xito.");
				$Respuesta->addScript("xajax_cargarListadoMapa();");
			}
			else
			{
				if(file_exists($NombreArchivo)){
					unlink($NombreArchivo);
				}
				$Respuesta->addAlert($RtaMapa);
			}
		}
		return $Respuesta;
	}
	$Xajax->registerFunction('interpretarMapaConceptual');
	
	/**
	* Esta funci�n se encarga de guardar los datos del mapa conceptual en la base de datos, tanto desde Knowledge Master como del editor
	* @param string[] $Concepto Matriz que contiene informacion sobre todos los conceptos y relaciones de un mapa
	* @param string[] $InfoGeneralConcepto Vector que contiene informaci�n general del mapa
	* @param integer $Duracion Tiempo limite del mapa en segundos 
	* @param integer $Tematica C�digo de la tematica del mapa
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function guardarMapaConceptual($Concepto,$InfoGeneralConcepto,$Duracion,$Tematica)
        {
            
		$components=  getComponents();
		if($components!=false)
		{
			$NumIdentidad = $_SESSION["_User"]->identificacion;
			$ConsultaIdMP="SELECT idMapaConceptual FROM mapaconceptual WHERE nombreMapa = '".$InfoGeneralConcepto['NombreMapa']."' 
					   AND idUsuario = ".$NumIdentidad.";";
			$Today=$components->getDate('America/Bogota',"Y-m-d H:i:s");
			$NowDate = getdate(strtotime($Today));
			$DateLimit = date("Y-m-d H:i:s", mktime( ($NowDate["hours"]+$Duracion), ($NowDate["minutes"]),($NowDate["seconds"]),($NowDate["mon"]),($NowDate["mday"]),($NowDate["year"])));
			$ResultadoIdMP=$components->__executeQuery($ConsultaIdMP,$components->getConnect());   
			if(mysql_affected_rows($components->getConnect())==0)
			{
                            
				$InsercionMP="INSERT INTO mapaconceptual
                                                (idUsuario, idTipoMapa, nombreMapa, totalConceptos, totalRelaciones, estadoMapa, duracionMapa, fechaInicio, fechaLimite)
                                                VALUES (".$NumIdentidad.",".$InfoGeneralConcepto['TipoMapa'].",'".$InfoGeneralConcepto['NombreMapa']."',".$InfoGeneralConcepto['Conceptos'].",".$InfoGeneralConcepto['Relaciones'].",'".$InfoGeneralConcepto['EstadoMapa']."','".$Duracion."','".$Today."','".$DateLimit."');";
                                if($components->__executeQuery($InsercionMP,$components->getConnect()))
				{
					$ConsultaIdMP="SELECT idMapaConceptual FROM mapaconceptual WHERE nombreMapa = '".trim($InfoGeneralConcepto['NombreMapa'])."' 
						   AND idUsuario = ".$NumIdentidad.";";
                                        
					$ResultadoIdMP=$components->__executeQuery($ConsultaIdMP,$components->getConnect());
					$IdMP=mysql_fetch_array($ResultadoIdMP);
					//Consulta del ID poniendo todos los parametros o solo nombre del mapa.
					foreach( $Concepto as $Clave=>$Vector )
					{
						//CARACTERES ESPECIALES �y CON TILDE, ETC NO ACEPTA.
						$InsercionConcepto="INSERT INTO concepto 
                                                (nombreConcepto, textoConcepto, idMapaConceptual)     
                                                VALUES('".trim($Vector['NomConcepto'])."',
						'".trim($Vector['NumConcepto'])."',".$IdMP['idMapaConceptual'].")";
						if(!$components->__executeQuery($InsercionConcepto,$components->getConnect()))
						{
							return "Insercion a concepto fallo.";
						}
					}
                                        $ConsultaConcepto="SELECT idConcepto FROM concepto
										WHERE idMapaConceptual=".$IdMP['idMapaConceptual'].";";
					$ResultadoQuery=$components->__executeQuery($ConsultaConcepto,$components->getConnect());
					$ResultadoVector=  mysql_fetch_array($ResultadoQuery);
					foreach($ResultadoVector as $Indice => $Valor )
					{
                                            	foreach($Concepto as $Clave => $Vector)
						{
                                                    	if(trim(@$Vector["NumConcepto"])==@$Valor["idConcepto"] && $Clave > 0)
							{
								//Si son iguales hacer la insercion de la tabla relacion. 
								//Campos($IdMP,$Valor,$Concepto['NumRelacionUp'],$Concepto['RelacionUp'])
								$InsercionRelacion="INSERT INTO relacion 
                                                                    
								VALUES(".$IdMP['idMapaConceptual'].",'".trim($Vector['NumRelacionUp'])."','".trim($Vector['NumConcepto'])."',
								'".trim($Vector['RelacionUp'])."');";
                                                                if(!$components->__executeQuery($InsercionRelacion,$components->getConnect()))
								{
									return "No sirvio la insercion de relacion";
								}
							}
						}
					}
										//insercion de la tematica
					$InsertarTematica="INSERT INTO mapa_conceptual_tematica VALUES('".$Tematica."','".$IdMP['idMapaConceptual']."')";
					if(!$components->__executeQuery($InsertarTematica,$components->getConnect())){
						return "No hay juegos para insertar";
					}

				}
				else
				{
					return "La insercion de mapa conceptual fallo.";
				}
			}
			else
			{
				return "El nombre del mapa ya existe. Por favor cambielo e intente de nuevo.";
			}
		}
		else
		{
			return "La conexion fallo.";
		}
		return true;
	}	
	
	/**
	* Esta funci�n se encarga de mostrar la interfaz para crear mapas conceptuales subiendo el archivo de KM
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function cargarFormaMapa(){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$components= getComponents();
		$Salida="<form method='post' name='FormaMapa' enctype='multipart/form-data' action='subirmapa.php' target='Puente'>";
		$Salida.="<table width='100%'>";
		$Salida.="<tr><td>Tipo de mapa:</td><td>";
		$Salida.="<select name='IdTipoMapa'>";
		$Salida.="<option value=''>(Seleccione un tipo)</option>";
		$QueryTipoMapa=$components->__executeQuery("SELECT id_tipo_mapa as id, nombre_tipo_mapa as nombre FROM tipo_mapa;",$components->getConnect());
		if($QueryTipoMapa){
			$NumTipoMapa=  mysql_affected_rows($components->getConnect());
			if($NumTipoMapa>0){
				while($VecTipoMapa=  mysql_fetch_array($QueryTipoMapa)){
					$Salida.="<option value='".$VecTipoMapa["id"]."'>".$VecTipoMapa["nombre"]."</option>";
				}
			}
		}
		$Salida.="</select>";
		$Salida.="</td></tr>";
		//Tematica
		$Salida.="<tr><td>Tem&aacute;tica del mapa:</td><td id='Tematica'></span>";
		$Salida.="</td></tr>";
		//--------------------------------------------------
		$Salida.="<tr><td>Intervalo Tiempo</td><td>";
		$Salida.="<select id='TipoIntervaloTiempo' name='TipoIntervaloTiempo' onChange='xajax_comboDuracion(this.value,0);'>";
		$Salida.="<option value='0'>(Seleccione una opci&oacute;n)</option>";
		$Salida.="<option value='Horas'>Horas</option>";
		$Salida.="<option value='Dias'>Dias</option>";
		$Salida.="<option value='Meses'>Meses</option>";
		$Salida.="</select>";
		$Salida.="</td></tr>";
		$Salida.="<tr><td>Duraci&oacute;n</td><td id='duracion'>";
		$Salida.="</td></tr>";
		$Salida.="<tr><td>";
		$Salida.="Seleccione el archivo a subir:";
		$Salida.="</td></tr>";
		$Salida.="<tr><td>";
		$Salida.="<input type='file' name='ArchivoMapa' id='ArchivoMapa'>";
		$Salida.="</td></tr>";
		$Salida.="<tr><td>";
		$Salida.="<button type='button' name='BotonMapa' onClick='validarFormaMapa(this.form)'>Subir archivo</button>";
		$Salida.="</td></tr>";
		$Salida.="</table>";
		$Salida.="</form>";
		cerrarConexion($components->getConnect());
		$Respuesta->addAssign("ContenidoMapa","innerHTML",$Salida);
		$Respuesta->addScriptCall("xajax_cargarComboTematica","Tematica",'xajax_cargarFormaMapa','2');
		return $Respuesta;
	}
	$Xajax->registerFunction('cargarFormaMapa');
	
	/**
	* Esta funci�n se encarga de guardar la tematica creada por el docente
	* @param string $NomTematica Nombre de la tem�tica
	* @param string $Funcion Cadena que contiewne la funcion a la cual debe llamarse despu�s de guardar la tematica
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function guardarTematica($NomTematica,$Funcion){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$components=  getComponents();
                $InsertarTematica="INSERT INTO tematica
                                    (nombreTematica)            
                                    VALUES ('".$NomTematica."');";
		if(!$components->__executeQuery($InsertarTematica,$components->getConnect())){
			$Respuesta->addAlert("Hubo un error al guardar la tem�tica.");
		}
		else{
			$Respuesta->addAlert("Tem�tica guardada con �xito.");
		}
		$Respuesta->addScriptCall($Funcion);
		cerrarConexion($components->getConnect());
		return $Respuesta;
	}
	$Xajax->registerFunction('guardarTematica');
	
	/**
	* Esta funci�n se encarga de mostrar el listado de mapas conceptuales cuando se hace click en Mis Mapas Conceptuales
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function cargarListadoMapa(){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$components=  getComponents();
		$NumIdentidad = $_SESSION["NumIdentidad"];
		$QueryMapasDocente=$components->__executeQuery("SELECT idMapaConceptual as id, nombreMapa as nombre, estadoMapa as estado, fechaLimite as feclim FROM mapaconceptual WHERE idUsuario='".$NumIdentidad."';",$components->getConnect());
		if($QueryMapasDocente)
		{
			$NumMapasDocente=  mysql_affected_rows($components->getConnect());
			$Salida="<fieldset>";
			$Salida.="<legend>Mis Mapas Conceptuales</legend>";
			//menu superior
			$Salida.="<fieldset>";
			$Salida.="<table width='100%' border='0'>";
			$Salida.="<tr>";
			$Salida.="<th><a href='javascript:void(0);' onClick=\"xajax_cargarListadoMapa();\">Ver mapas</a></th><th><a href='javascript:void(0);' onClick=\"xajax_cargarEditorMapa();\">Crear mapa</a></th><th><a href='javascript:void(0);' onClick=\"xajax_cargarFormaMapa();\">Importar mapa</a></th>";
			$Salida.="</tr>";
			$Salida.="</table>";
			$Salida.="</fieldset>";
			//muestro los mapas conceptuales
			$Salida.="<span id='ContenidoMapa'>";
			$Salida.="<table width='100%'>";
			if($NumMapasDocente>0){
				$Salida.="<tr><th align='left'>Nombre Mapa</th><th align='left'>Opciones</th><th align='left'>Fecha L&iacute;mite</th><th align='left'>Tipo Mapa</th></tr>";
				//$Salida.="<tr>";
				while($VectorMapas=  mysql_fetch_array($QueryMapasDocente)){
					$Salida.="<tr>";
					$Salida.="<td>";
					if($VectorMapas["estado"]=="0"){
						$Salida.="<a href='javascript:void(0);' onClick=\"confirmarEliminarMapa('".$NumIdentidad."','".$VectorMapas["id"]."');\"><img src='img/ico_eliminar.gif' border='0'></a>&nbsp;";
					}
					$Salida.="<a href='javascript:void(0);' onClick=\"xajax_mostrarMapa('".$VectorMapas["id"]."');\">".$VectorMapas["nombre"]."</a></td>";
					//en estas opciones se incluye, eliminar el mapa, modificar algunos datos, parecido al phpmyadmin
					$Salida.="<td>";
					switch($VectorMapas["estado"]){
						case "0":
							$Salida.="Estado actual:&nbsp;Inactivo&nbsp;<a href='javascript:void(0);' onClick=\"confirmarActivacionMapa('".$VectorMapas["id"]."','1',1)\">Activar</a>";
						break;
						case "1":
							$Salida.="Estado actual:&nbsp;Activo&nbsp;<a href='javascript:void(0);' onClick=\"confirmarDesactivacionMapa('".$VectorMapas["id"]."','2')\">Desactivar</a>";
						break;
						case "2":
							$Salida.="Estado actual:&nbsp;Inactivo&nbsp;<a href='javascript:void(0);' onClick=\"confirmarActivacionMapa('".$VectorMapas["id"]."','1',0)\">Activar</a>";
						break;
					}
					$Salida.="</td>";
					$Salida.="<td><span id='Duracion_".$VectorMapas["id"]."'>".$VectorMapas["feclim"]."</span></td>";
                                        $rs = $components->__executeQuery("SELECT tm.nombreTipoMapa as nom FROM tipomapa tm, mapaconceptual mc 
					WHERE tm.idTipoMapa=mc.idTipoMapa AND mc.idMapaConceptual='".$VectorMapas["id"]."'",$components->getConnect());
					$TipoMapa=  mysql_fetch_array($rs);
					if($TipoMapa){
						$Salida.="<td>".$TipoMapa["nom"]."</td>";
					}
					$Salida.="</tr>";
				}
			}
			else{
				$Salida.="<tr><td>No hay mapas disponibles.</td></tr>";
			}
			$Salida.="</table>";
			$Salida.="</span>";
			$Salida.="</fieldset>";
			$Respuesta->addAssign("Contenido","innerHTML",$Salida);
		}
		else{
			$Respuesta->addAlert("Hubo un error al cargar los mapas conceptuales. Intente de nuevo m�s tarde");
		}
		cerrarConexion($components->getConnect());
		return $Respuesta;
	}
	$Xajax->registerFunction("cargarListadoMapa");
	
	/**
	* Esta funci�n se encarga de eliminar el mapa segun el docente
	* @param integer $IdDocente N�mero de identificacion del docente
	* @param integer $IdMapa C�digo del mapa
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function eliminarMapa($IdDocente,$IdMapa){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$Conexion=abrirConexion();
		$Query="DELETE FROM mapa_conceptual WHERE id_mapa_conceptual='".$IdMapa."' AND usuario_id_usuario='".$IdDocente."';";
		if(!pg_query($Query)){
			$Respuesta->addAlert("Hubo un error al eliminar el mapa. Int�ntelo de nuevo m�s tarde.");
		}
		else{
			$Respuesta->addAlert("Mapa eliminado con �xito.");
			$Respuesta->addScriptCall("xajax_cargarListadoMapa");
		}
		cerrarConexion($Conexion);
		return $Respuesta;
	}
	$Xajax->registerFunction("eliminarMapa");
	
	/**
	* Esta funci�n se encarga de mostrar la interfaz para crear el mapa a traves del editor
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function cargarEditorMapa(){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$components=  getComponents();
		$Salida="<table width='100%' border='0' id='TablaInicial'>";
		$Salida.="<tr id='Primero'>";
		$Salida.="<td>";
		$Salida.="Escriba un nombre para el mapa: <input type='text' id='NombreMapa' name='NombreMapa' size='10' maxlength='30'>";
		$Salida.="</td>";
		$Salida.="</tr>";
		//tipo de mapa
		$Salida.="<tr><td>Tipo de mapa:&nbsp;Jer&aacute;rquico";
		$Salida.="</td></tr>";
		//Tematica
		$Salida.="<tr><td>Tem&aacute;tica del mapa:&nbsp;<span id='Tematica'></span>";
		$Salida.="</td></tr>";
		//--------------------------------------------------
		$Salida.="<tr id='FilaDuracion'><td>Intervalo Tiempo:&nbsp;";
		$Salida.="<select id='TipoIntervaloTiempo' name='TipoIntervaloTiempo' onChange='xajax_comboDuracion(this.value,0);'>";
		$Salida.="<option value='0'>(Seleccione una opci&oacute;n)</option>";
		$Salida.="<option value='Horas'>Horas</option>";
		$Salida.="<option value='Dias'>Dias</option>";
		$Salida.="<option value='Meses'>Meses</option>";
		$Salida.="</select>";
		$Salida.="</td></tr>";
		$Salida.="<tr><td>Duraci&oacute;n:&nbsp;<span id='duracion'></span>";
		$Salida.="</td></tr>";
		$Salida.="<tr id='Segundo'>";
		$Salida.="<td>
		<button type='button' onClick=\"cargarMapaInicio();\">Iniciar mapa</button>
		</td>
		</tr>
		</table>
		<table width='100%' border='0'>
		<tr>
		<td>
		<span id='spaninicio'></span>
		</td>
		</tr>
		<tr>
		<td>
		<button type='button' id='BotonGuardarMapa' onClick='obtenerDatosMapa()' disabled='disabled'>Guardar mapa</button>
		</td>
		</tr>
		</table>
		<input type='hidden' name='campoactual' id='campoactual' value=''>
		<span id='formamatrices'></span>";
		$Respuesta->addAssign("ContenidoMapa","innerHTML",$Salida);
		$Respuesta->addScriptCall("xajax_cargarComboTematica","Tematica",'xajax_cargarEditorMapa','2');
		cerrarConexion($components->getConnect());
		return $Respuesta;
	}
	$Xajax->registerFunction("cargarEditorMapa");
	
	/**
	* Esta funci�n se encarga de una lista desplegable con las tematicas disponibles
	* @param string $CampoDestino Campo HTML donde se va a mostrar la lista desplegable
	* @param string $Funcion Cadena que contiene la funcion a la cual debe llamarse despu�s de seleccionar la tematica
	* @param string $TipoCombo Cadena que contiene el tipo de combo segun como se vaya a mostrar la tematica
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function cargarComboTematica($CampoDestino,$Funcion,$TipoCombo){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$components=  getComponents();
		//Tematica
		$Salida="<span id='CampoTematica'>";
		$Salida.="<select name='TematicaMapa' id='TematicaMapa' onChange=\"cargarFormaTematica(this.value,'CampoTematica','".$Funcion."','".$TipoCombo."','".$CampoDestino."');\">";
		$Salida.="<option value='0'>(Seleccione una tem&aacute;tica)</option>";
		$QueryTematica=$components->__executeQuery("SELECT idTematica as id, nombreTematica as nom FROM tematica",$components->getConnect());
		if($QueryTematica){
			if(mysql_affected_rows($components->getConnect())>0){
				while($VecTematica=  mysql_fetch_array($QueryTematica)){
					$Salida.="<option value='".$VecTematica["id"]."@".$VecTematica["nom"]."'>".$VecTematica["nom"]."</option>";
				}
			}
		}
		$Salida.="<option value='-1'>[Agregar nueva tem�tica...]</option>";
		$Salida.="</select></span>";
		$Respuesta->addAssign($CampoDestino,"innerHTML",$Salida);
		cerrarConexion($components->getConnect());
		return $Respuesta;
	}
	$Xajax->registerFunction("cargarComboTematica");
	
	/**
	* Esta funci�n se encarga de establecer el estado del mapa del docente
	* @param integer $IdMapa C�digo del mapa
	* @param integer $EstadoNuevo Estado nuevo del mapa
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function establecerEstadoMapa($IdMapa, $EstadoNuevo)
	{
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$Conexion=abrirConexion();
		$NumIdentidad = $_SESSION["NumIdentidad"];
		$ActualizacionEstadoMapa="UPDATE mapa_conceptual SET estado_mapa = ".$EstadoNuevo." WHERE id_mapa_conceptual = ".$IdMapa.";";
		if(!pg_query($ActualizacionEstadoMapa))
		{
			$Respuesta->AddAlert("La actualizacion del estado del mapa fallo. Intente mas tarde.");
		}
		else{
			$Respuesta->addScript("xajax_cargarListadoMapa();");
		}
		cerrarConexion($Conexion);
		return $Respuesta;
	}
	$Xajax->registerFunction('establecerEstadoMapa');
	
	/**
	* Esta funci�n se encarga de crear una lista desplegable de duracion
	* @param string $Tipo Tipo de intervalo de tiempo
	* @param string $Funcion Cadena que contiene una funcion 
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function comboDuracion($Tipo,$Funcion)
	{
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$Evento="";
		if($Funcion==1){
			$Evento=" onChange=\"mostrarValoresDuracion()\"";
		}
		$Salida="<select name='ValorDuracion' id='ValorDuracion'".$Evento.">";
		if($Tipo == "Horas")
		{
			for( $i=1;$i<24;$i++ )
			{
				$Salida.="<option value='".$i."'>".$i."</option>";
			}
		}
		
		if($Tipo == "Dias")
		{
			for( $i=1;$i<=31;$i++ )
			{
				$Salida.="<option value='".$i."'>".$i."</option>";
			}
		}
		
		if($Tipo == "Meses")
		{
			for( $i=1;$i<=12;$i++ )
			{
				$Salida.="<option value='".$i."'>".$i."</option>";
			}
		}
		if($Tipo=="0")
		{
			$Respuesta->addClear("duracion","innerHTML");
			return $Respuesta;
		}
		$Respuesta->addAssign("duracion","innerHTML",$Salida);
		
		return $Respuesta;
	}
	$Xajax->registerFunction('comboDuracion');
	
	/**
	* Esta funci�n se encarga de crear una lista desplegable de duracion
	* @param string $Tipo Tipo de intervalo de tiempo
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function comboDuracionMapas($Tipo)
	{
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$Salida="<select name='ValorDuracionMap' id='ValorDuracionMap'>";
		if($Tipo == "Horas")
		{
			for( $i=1;$i<24;$i++ )
			{
				$Salida.="<option value='".$i."'>".$i."</option>";
			}
		}
		
		if($Tipo == "Dias")
		{
			for( $i=1;$i<=31;$i++ )
			{
				$Salida.="<option value='".$i."'>".$i."</option>";
			}
		}
		
		if($Tipo == "Meses")
		{
			for( $i=1;$i<=12;$i++ )
			{
				$Salida.="<option value='".$i."'>".$i."</option>";
			}
		}
		if($Tipo=="0")
		{
			$Respuesta->addClear("SpanCombosMap","innerHTML");
			return $Respuesta;
		}
		$Respuesta->addAssign("SpanCombosMap","innerHTML",$Salida);
		
		return $Respuesta;
	}
	$Xajax->registerFunction('comboDuracionMapas');
	
	/**
	* Esta funci�n se encarga de buscar hijos de un nodo o concepto padre
	* @param string $Padre Codigo del nodo padre
	* @param string $CadPad Cadena que contiene unlistado de los nodos padre 
	* @param integer $NumPadre Id del nodo actual
	* @param form $FormaMapa Formulario que contiene la informaci�n de todo el mapa conceptual
	* @param integer $IdConceptoPadre Id del nodo actual
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function buscarHijos($Padre,$CadPad,$NumPadre,$FormaMapa,$IdConceptoPadre){//funcion usada por recibirDatosMapa
		if(strpos($CadPad,$Padre)!==false){
			$HijosRaiz=$FormaMapa["Hijos_".$Padre];
			$VectorHojasRaiz=explode(",",$HijosRaiz);
			$GLOBALS["NivelMapa"]++;
			$ContadorHijos=0;
			foreach($VectorHojasRaiz as $Vhr){
				if($Vhr!=""){
					$ContadorHijos++;
					$GLOBALS["PadreActual"]=$NumPadre;
					$GLOBALS["Contador"]++;
					$NomHoja=$FormaMapa["Valor_Nodo_".$Vhr];
					$VectorDatosHoja=explode("@",$NomHoja);
					$NumConcepto=$IdConceptoPadre.".".$ContadorHijos;
					//metemos el concepto en la matriz como la necesita la funcion
					$GLOBALS["MatrizConcepto"][$GLOBALS["Contador"]]["TextoDesc"]="";//me falta poner el texto descriptivo en el mapa
					$GLOBALS["MatrizConcepto"][$GLOBALS["Contador"]]["EspaciosPre"]=$GLOBALS["NivelMapa"]*3;//3 es el numero de espacios
					$GLOBALS["MatrizConcepto"][$GLOBALS["Contador"]]["NumConcepto"]=$NumConcepto;
					$GLOBALS["MatrizConcepto"][$GLOBALS["Contador"]]["NomConcepto"]=$VectorDatosHoja[1];
					$GLOBALS["MatrizConcepto"][$GLOBALS["Contador"]]["RelacionUp"]=$VectorDatosHoja[0];
					$GLOBALS["MatrizConcepto"][$GLOBALS["Contador"]]["NumRelacionUp"]=$GLOBALS["PadreActual"];
					buscarHijos($Vhr,$CadPad,$NumConcepto,$FormaMapa,$NumConcepto);
				}
			}
			$GLOBALS["NivelMapa"]--;
			return true;
		}
		else{
			return false;
		}
	}

	/**
	* Esta funci�n se encarga de recibir los datos del mapa creado en el editor
	* @param form $FormaMapa Formulario que contiene la informaci�n de todo el mapa conceptual
	* @param integer $IdMapa C�digo del mapa 
	* @param integer $Indicador Valor que indica si el mapa es editado o creado por primera vez 
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function recibirDatosMapa($FormaMapa,$IdMapa,$Indicador){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		if($IdMapa!=null && $Indicador!=0){
			$components=  getComponents();
			$QueryMapa="DELETE FROM mapaConceptual WHERE idMapaConceptual='".$IdMapa."';";
			if(!$components->__executeQuery($QueryMapa,$components->getConnect())){
				$Respuesta->addAlert("Ha ocurrido un problema al editar el mapa. Intente de nuevo m�s tarde.");
			}
			cerrarConexion($components->getConnect());
		}
		//datos recibidos desde el editor de mapas
		$ValorRaiz=$FormaMapa["ValorRaiz"];
		$CadenaPadres=$FormaMapa["CadenaPadres"];
		$VectorPadres=explode(",",$CadenaPadres);
		//datos del elemento raiz
		$HijosRaiz=$FormaMapa["Hijos_Raiz"];
		$VectorHojasRaiz=explode(",",$HijosRaiz);
		$NumRaiz=1;
		//-----------------------------
		$PosicionVector=count($GLOBALS["VectorNumUsados"]);
		$GLOBALS["VectorNumUsados"][$PosicionVector]=$NumRaiz;
		//insercion del elemento raiz en la matriz
		$GLOBALS["MatrizConcepto"][$GLOBALS["Contador"]]["TextoDesc"]="";//me falta poner el texto descriptivo en el mapa
		$GLOBALS["MatrizConcepto"][$GLOBALS["Contador"]]["EspaciosPre"]=0;//no se
		$GLOBALS["MatrizConcepto"][$GLOBALS["Contador"]]["NumConcepto"]=$NumRaiz;
		$GLOBALS["MatrizConcepto"][$GLOBALS["Contador"]]["NomConcepto"]=$ValorRaiz;
		$GLOBALS["MatrizConcepto"][$GLOBALS["Contador"]]["RelacionUp"]="";//es el elemento raiz
		$GLOBALS["MatrizConcepto"][$GLOBALS["Contador"]]["NumRelacionUp"]=0;//es el elemento raiz
		//lectura de los hijos de raiz
		$ContadorHijos=0;
		foreach($VectorHojasRaiz as $Vhr){
			if($Vhr!=""){
				$ContadorHijos++;
				$GLOBALS["PadreActual"]=$NumRaiz;
				$GLOBALS["Contador"]++;
				$NomHoja=$FormaMapa["Valor_Nodo_".$Vhr];
				$VectorDatosHoja=explode("@",$NomHoja);
				//$NumConcepto=generarNumeroConcepto();
				$NumConcepto=$NumRaiz.".".$ContadorHijos;
				//metemos el concepto en la matriz como la necesita la funcion
				$GLOBALS["MatrizConcepto"][$GLOBALS["Contador"]]["TextoDesc"]="";//me falta poner el texto descriptivo en el mapa
				$GLOBALS["MatrizConcepto"][$GLOBALS["Contador"]]["EspaciosPre"]=$GLOBALS["NivelMapa"]*3;//3 es el numero de espacios
				$GLOBALS["MatrizConcepto"][$GLOBALS["Contador"]]["NumConcepto"]=$NumConcepto;
				$GLOBALS["MatrizConcepto"][$GLOBALS["Contador"]]["NomConcepto"]=$VectorDatosHoja[1];
				$GLOBALS["MatrizConcepto"][$GLOBALS["Contador"]]["RelacionUp"]=$VectorDatosHoja[0];
				$GLOBALS["MatrizConcepto"][$GLOBALS["Contador"]]["NumRelacionUp"]=$GLOBALS["PadreActual"];
				//busqueda de mas hijos
				buscarHijos($Vhr,$CadenaPadres,$NumConcepto,$FormaMapa,$NumConcepto);
			}
		}
		//formamos la matriz de informacion general del mapa
		$DatosMapa=explode(",",$FormaMapa["DatosMapa"]);
		$InfoMapa["TipoMapa"]=$DatosMapa[0];
		$InfoMapa["NombreMapa"]=$DatosMapa[1];
		$InfoMapa["Conceptos"]=$DatosMapa[2];
		$InfoMapa["Relaciones"]=$DatosMapa[3];
		$InfoMapa["EstadoMapa"]=$DatosMapa[4];
		//cuadramos la duracion en horas
		$TipoDuracion=$FormaMapa["TipoDuracion"];
		$ValorDuracion=$FormaMapa["ValorDuracion"];
		switch($TipoDuracion){
			case "Dias":
				$ValorDuracion*=24;
			break;
			case "Meses":
				$ValorDuracion*=24*30;
			break;
		}
		//----------------------------------------
		//cuadramos el id del mapa
		$IdTematica=$FormaMapa["Tematica"];
		//--------------------------
		$EstadoMapa=guardarMapaConceptual($GLOBALS["MatrizConcepto"],$InfoMapa,$ValorDuracion,$IdTematica);
		if($EstadoMapa!="1"){
			$Respuesta->addAlert($EstadoMapa);
		}
		else{
			$Respuesta->addAlert("Mapa conceptual creado con �xito.");
			$Respuesta->addScript("xajax_cargarListadoMapa();");
		}
		return $Respuesta;
	}
	$Xajax->registerFunction('recibirDatosMapa');
	
	/**
	* Esta funci�n se encarga de mostrar el mapa conceptual, sus conceptos y relaciones
	* @param integer $IdMapa C�digo del mapa 
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function mostrarMapa($IdMapa){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$components=  getComponents();
		//informacion del concepto
		$QueryConcepto=$components->__executeQuery("SELECT idConcepto as id, nombreConcepto as nombre, textoConcepto as texto FROM concepto 
		WHERE idMapaConceptual='".$IdMapa."' AND idConcepto NOT LIKE	'%.%';",$components->getConnect());
		if(!$QueryConcepto){
			$Respuesta->addAlert("No se puede mostrar el mapa. Por favor, intente de nuevo m�s tarde.");
		}
		else{
			$VectorConcepto=  mysql_fetch_array($QueryConcepto);
			//consulta que contiene todos los conceptos del mapa que sean padres
			$QueryPadres=$components->__executeQuery("SELECT DISTINCT idConcepto as id_padre FROM relacion 
			WHERE idMapaConceptual='".$IdMapa."';",$components->getConnect());
			if($QueryPadres){
				if(mysql_affected_rows($components->getConnect())>0){
					$CadenaPadres=implode(",",  mysql_fetch_array($QueryPadres));
				}
				else{
					$CadenaPadres="";
				}
			}
			//informacion del mapa
                        $query="SELECT nombreMapa as nombre, estadoMapa as estado, duracionMapa as duracion FROM mapaconceptual 
                                WHERE idMapaConceptual=".$IdMapa.";";
                        $response = $components->__executeQuery($query,$components->getConnect());
                        $VecMapa=  mysql_fetch_array($response);
			//cuadramos el intervalo y la duracion
			if($VecMapa["duracion"]<24){
				$d=$VecMapa["duracion"];
				$in="Horas";
			}
			elseif($VecMapa["duracion"]>=24 && $VecMapa["duracion"]<720){//720 es 24 horas * 30 dias
				$d=$VecMapa["duracion"]/24;
				$in="Dias";
			}
			elseif($VecMapa["duracion"]>=720 && $VecMapa["duracion"]<8640){//8640 es 24 horas * 30 dias * 12 meses
				$d=$VecMapa["duracion"]/(24*30);
				$in="Meses";
			}
			//------------------------------------------------
			//inicio del mapa
			$Salida="<table align='100%' border='0'";
			$Salida.="<tr>";
			$Salida.="<td>";
			$Salida.="Nombre del mapa:&nbsp;<span id='Nombre'";
			if($VecMapa["estado"]==0){
				$Salida.=" onDblClick=\"cargarNombreHoja(this.id);\"";
			}
			$Salida.=">".$VecMapa["nombre"]."</span>";
			$Salida.="</td>";
			$Salida.="</tr>";
			//definimos tematica
                        $sql ="SELECT t.idTematica as id, t.nombreTematica as nom FROM tematica t, mapaconceptualtematica mct WHERE t.idTematica=mct.idTematica AND mct.idMapaConceptual='".$IdMapa."' LIMIT 1;";
                        $rs = $components->__executeQuery($sql,$components->getConnect());
			$Tema=  mysql_fetch_array($rs);
			$Salida.="<tr>";
			$Salida.="<td>";
			$Salida.="Tem&aacute;tica del mapa:&nbsp;<span id='Tematica'";
			if($VecMapa["estado"]==0){
				$Salida.="  onDblClick=\"xajax_cargarComboTematica(this.id,'xajax_cargarFormaMapa','1')\" title='Haga doble click para editar la tematica'";
			}
			$Salida.=">".$Tema["nom"]."</span><input type='hidden' name='txtTematica' id='txtTematica' value='".$Tema["id"]."'>";
			$Salida.="</td>";
			$Salida.="</tr>";
			$Salida.="<tr>";
			$Salida.="<td>";
			$Salida.="Duracion:&nbsp;<span id='duracion'";
			if($VecMapa["estado"]==0){
				$Salida.=" onDblClick=\"cargarComboDuracion()\" title='Haga doble click para editar'";
			}
			$Salida.=">".$d."</span>&nbsp;";
			$Salida.="<span id='spanTipoDuracion'";
			if($VecMapa["estado"]==0){
				$Salida.=" onDblClick=\"cargarComboDuracion()\" title='Haga doble click para editar'";
			}
			$Salida.=">".$in."</span>";
			$Salida.="&nbsp;<a href='javascript:void(0)' id='Vinculo' onClick='cancelarComboDuracion();'></a><input type='hidden' name='TipoIntervaloTiempo' id='TipoIntervaloTiempo' value='".$in."'><input type='hidden' name='txtDuracion' id='txtDuracion' value='".$d."'>";
			$Salida.="</td>";
			$Salida.="</tr>";
			$Salida.="<tr><td>";
			$Salida.="<ul id='Arbol'>";
			$Salida.="<li><input type='hidden' id='Nomen_Raiz' name='Nomen_Raiz' value='".$VectorConcepto["id"]."'><span id='NombreRaiz'";
			if($VecMapa["estado"]==0){
				$Salida.=" onDblClick=\"cargarNombreHoja(this.id);\"";
			}
			$Salida.=">".$VectorConcepto["nombre"]."</span>&nbsp;";
			if($VecMapa["estado"]==0){
				$Salida.="<span id='HojasRaiz'><img id='BotonMenu' src='img/ico_agregar.gif' onClick=\"cargarFormaHojas('HojasRaiz','Raiz');\" title='Haga click aqui para agregar hojas' border='0'/></span>";
			}
			//en este span almacenamos las nhojas anteriores
			$Salida.="<span id='Raiz'>";
			$Salida.="</span>";
			$Salida.="</li></ul>";
			$Salida.="</td></tr>";
			if($VecMapa["estado"]==0){
				$Salida.="<tr><td>";
				$Salida.="<button type='button' id='BotonGuardarMapa' onClick=\"obtenerDatosMapaEditado('".$IdMapa."');\">Guardar mapa</button>";
				$Salida.="</td></tr>";
			}
			$Salida.="<input type='hidden' name='campoactual' id='campoactual' value=''>";
			$Salida.="<span id='formamatrices'></span>";
			$Respuesta->addAssign("ContenidoMapa","innerHTML",$Salida);
			$Respuesta->addScriptCall("xajax_mostrarHojasMapa",$IdMapa,$VecMapa["estado"],$VectorConcepto["id"],$CadenaPadres);
		}
		cerrarConexion($components->getConnect());
		return $Respuesta;
	}
	$Xajax->registerFunction('mostrarMapa');
	
	/**
	* Esta funci�n se encarga de transmitir los datos para mostrar los conceptos y relaciones del mapa
	* @param integer $IdMapa C�digo del mapa 
	* @param integer $EstadoMapa Valor que contiene el estado del mapa
	* @param integer $IdConcepto C�digo del concepto 
	* @param string $CadenaPadres Cadena que contiene el listado de los conceptos padre 
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function mostrarHojasMapa($IdMapa,$EstadoMapa,$IdConcepto,$CadenaPadres){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$components=  getComponents();
		$VectorIdHijo=array("");
		$VectorNomHijo=array("");
		$VectorRelHijo=array("");
		//$Respuesta->addAlert("Concepto: ".$IdConcepto." Cadena Padres:".$CadenaPadres);
		if(strpos($CadenaPadres,$IdConcepto)!==false){
			if($IdConcepto=="1"){	
				$CampoMenu="HojasRaiz";
				$CampoInicial="Raiz";
			}
			else{
				$NomenIdPadre=str_replace(".","_",substr_replace($IdConcepto,"",0,2));
				//$Respuesta->addAlert("Padre: ".$NomenIdPadre);
				$CampoMenu="menu_".$NomenIdPadre;
				$CampoInicial=$NomenIdPadre;
			}
			$QueryHijos=$components->__executeQuery("SELECT idConceptoHijo as id_hijo, nombreRelacion as relacion FROM relacion WHERE idMapaConceptual='".$IdMapa."' 
			AND idConcepto='".$IdConcepto."';",$components->getConnect());
			if($QueryHijos){
				if(mysql_affected_rows($components->getConnect())>0){
					while($Vector=  mysql_fetch_array($QueryHijos)){
                                                $sql ="SELECT nombreConcepto as nomhijo FROM concepto WHERE 
						idMapaConceptual='".$IdMapa."' AND idConcepto='".$Vector["idHijo"]."';";
						$VecNomHijo=  mysql_fetch_array($components->__executeQuery($sql, $components->getConnect()));
                                                $VectorIdHijo[]=$Vector["id_hijo"];
						$VectorNomHijo[]=$VecNomHijo["nomhijo"];
						$VectorRelHijo[]=$Vector["relacion"];
					}
					$Respuesta->addScriptCall("generarHojasEditadas",$CampoMenu,$CampoInicial,$VectorNomHijo,$VectorRelHijo,$EstadoMapa);
					foreach($VectorIdHijo as $Vih){
						if($Vih!=""){
							$Respuesta->addScriptCall("xajax_mostrarHojasMapa",$IdMapa,$EstadoMapa,$Vih,$CadenaPadres);
						}
					}
				}
			}
		}
		cerrarConexion($components->getConnect());
		return $Respuesta;
	}
	$Xajax->registerFunction('mostrarHojasMapa');
?>