<?php

    /**
	 * Este funci�n se encarga del registro de un nuevo docente.
	 * @param form $Formulario Fomulario con los datos ingresados por el docente.
	 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	 */
	function registrarDocente($Formulario){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$Conexion=abrirConexion();
		if($Conexion!=false)
		{
			//almaceno en la BD
			$QueryInsercion=pg_query("INSERT INTO usuario VALUES('".$Formulario['IdUsuario']."','1',
									'".$Formulario['NombreUsuario']."','".$Formulario['ApellidoUsuario']."',
									'".$Formulario['IdUsuario']."',
									'".$Formulario['CorreoUsuario']."');");
			if(!$QueryInsercion){
				$Respuesta->AddAlert("No se ha podido completar el registro.\nPor favor intente m�s tarde.");
			}
			
			else{
				//env�o de correo electr�nico
				$Destinatario=$Formulario['CorreoUsuario'];
				$Asunto="SEI - Confirmaci�n de Registro de Docentes";
				$Mensaje = '<html><head><title>Registro SISTEMA BASADO EN CONOCIMIENTOS PARA ENTRENAMIENTO INTELIGENTE ORIENTADO A LA EVALUACION ACADEMICA "SEI"</title></head>';
				$Mensaje.= '<body><table align="center"><tr><th>Se&ntilde;or(a): '.$Formulario['NombreUsuario'].'&nbsp;';
				$Mensaje.= ''.$Formulario['ApellidoUsuario'].', usted ha sido registrado exitosamente en el SISTEMA BASADO EN CONOCIMIENTOS PARA ENTRENAMIENTO INTELIGENTE ORIENTADO A LA EVALUACION ACADEMICA "SEI"</th></tr>';
				$Mensaje.= '<tr><td><br>Su solicitud de acceso ha sido aceptada exitosamente, a continuaci&oacute;n incluimos sus datos de acceso:<br></td></tr>';
				$Mensaje.= '<tr><td><br><strong>Documento de Identidad:</strong> '.$Formulario['IdUsuario'].'</td></tr>';
				$Mensaje.= '<tr><td><strong>Clave Acceso:</strong>  '.$Formulario['IdUsuario'].'</td></tr>';
				$Mensaje.= '</table></body></html>';
				$Cabeceras = 'MIME-Version: 1.0' . "\r\n";
				$Cabeceras.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$Cabeceras.= 'To: '.$Formulario['NombreUsuario'].' '.$Formulario['ApellidoUsuario'].' <'.$Formulario['CorreoUsuario'].'>' . "\r\n";
				$Cabeceras.= 'From: admin@sei.com' . "\r\n";
				
				require("lib/PHPMailer_v5.0.2/class.phpmailer.php");
				$mail=new PHPMailer();
				$mail->IsSMTP(); // telling the class to use SMTP
				$mail->Host       = "localhost"; // SMTP server
				$mail->SMTPAuth   = true;                  // enable SMTP authentication
				$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
				$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
				$mail->Port       = 465; 
				$mail->Username   = "admin.sceie@gmail.com";  // GMAIL username
				$mail->Password   = "123456789admin"; 
				
				$mail->SetFrom("admin@sceie.com","SEI");
				$mail->AddAddress($Destinatario);
				$mail->Subject=$Asunto;
				$mail->MsgHTML($Mensaje);
				$mail->Send();
				$Respuesta->AddAlert(" El Docente ha sido registrado con �xito.\n Se ha enviado un correo de confirmaci�n\n al correo que nos ha proporcionado\n con todos los datos de acceso a SEI.");
				$Respuesta->AddScript("location.href='index.php';");
			}
		}
		else{
			$Respuesta->AddAlert("No se conect�");
		}
		cerrarConexion($Conexion);
		return $Respuesta;
	}
	$Xajax->registerFunction('registrarDocente');
	
	/**
	 * Esta funci�n se encarga de traer los grupos de la base de datos que estan asignados a un docente 
	 * @param integer $NumIdDocente N�mero de identificaci�n del docente.
	 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	 */
	function cargarGrupos($NumIdDocente){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		//$Respuesta->addAlert("hola mundo");
		$components=  getComponents();
		$Salida="<fieldset>";
		$Salida.="<legend>Mis Grupos</legend>";
		$Salida.="<table width='100%'>";
		$Salida.="<tr>";
		$Salida.="<td align='left'><a href='javascript:void(0)' onClick=\"xajax_cargarFormaGrupo('".$NumIdDocente."');\">Crear nuevo grupo</a></td>";
		$Salida.="</tr>";
		$Salida.="<tr><td><span id='SpanGrupo'></span></td></tr>";
		$Salida.="<tr><th>Nombre Grupo</th><th>Descripci&oacute;n</th>";
		$Salida.="<th>Mapas Asociados</th>";
		$Salida.="</tr>";
		$Query="SELECT idGrupo as grupo, nombreGrupo as nom, dscGrupo as descs FROM grupo WHERE idGrupo IN(SELECT idGrupo FROM grupoUsuario WHERE idUsuario='".$NumIdDocente."');";
                //echo $Query;
		$ResultadoQuery=$components->__executeQuery($Query,$components->getConnect());
                if(!$ResultadoQuery){
			$Respuesta->addAlert("Ha ocurrido un error. ".pg_last_error());
		}
		else{
			$NumQuery=  mysql_affected_rows($components->getConnect());
			if($NumQuery>0){
				while($VectorGrupo=  mysql_fetch_array($ResultadoQuery)){
					$Salida.="<tr>";
					$Salida.="<td valign='top'>";
					//encontrar si alguno de los juegos ha sido ejecutado, si no es asi si se puede eliminar el grupo
					$QueryRtas=$components->__executeQuery("SELECT duracionReal FROM historialjuegorespuesta 
					WHERE idUsuario IN (SELECT idUsuario FROM grupousuario WHERE idGrupo='".$VectorGrupo["grupo"]."');",$components->getConnect());
					if($QueryRtas){
						$NumRtas=  mysql_affected_rows($components->getConnect());
						if($NumRtas==0){
							$Salida.="<a href='javascript:void(0)' onClick=\"confirmarEliminarGrupo('".$NumIdDocente."','".$VectorGrupo["grupo"]."')\" title='Haga click para eliminar el grupo'><img src='img/ico_eliminar.gif' border='0'></a>";
						}
					}
					$Salida.="&nbsp;<a href='javascript:void(0)' onClick=\"xajax_mostrarEstudiantesGrupo('".$NumIdDocente."','".$VectorGrupo["grupo"]."')\">".$VectorGrupo["nom"]."</a>";
					$Salida.="</td>";
					$Salida.="<td valign='top'>".$VectorGrupo["descs"]."</td>";
					$Salida.="<td valign='top'>";
					$Salida.="<span id='celda_".$VectorGrupo["grupo"]."'>";
					//query para traer los mapas conceptuales asociados al grupo
                                        //JUANRUSSI/*$QueryMapas=$components->__executeQuery("SELECT gm.idMapa as idmapa, mc.nombreMapa as nom 
					/*FROM grupomapaconceptual gm, mapaconceptual mc 
					WHERE gm.idGrupo='".$VectorGrupo["grupo"]."' 
					AND mc.idMapaConceptual=gm.idMapa",$components->getConnect());*/
                                        $sql="SELECT gm.idMapaConceptual as idmapa, mc.nombreMapa as nom 
					FROM grupomapausuario gm, mapaconceptual mc 
					WHERE gm.idGrupo='".$VectorGrupo["grupo"]."' 
					AND mc.idMapaConceptual=gm.idMapaConceptual";
					$QueryMapas=$components->__executeQuery($sql,$components->getConnect());
                                       // echo $sql;
                                        if(!$QueryMapas){
						if(mysql_affected_rows($components->getConnect())>0){
							$Salida.="<ul type='circle'>";
							while($VecMapas=  mysql_fetch_array($QueryMapas)){
								$Salida.="<li>".$VecMapas["nom"]."</li>";
							}
							$Salida.="</ul>";
						}
						else{
							$Salida.="No hay mapas asociados a este grupo.<br><br>";
						}
					}
					else{
						$Salida.="No hay mapas asociados a este grupo.<br><br>";
					}
					$Salida.="<a href='javascript:void(0)' onClick=\"xajax_editarGrupoMapa('".$NumIdDocente."','".$VectorGrupo["grupo"]."');\">Editar</a>";
					$Salida.="</span>";
					$Salida.="</td>";
					$Salida.="</tr>";
				}
			}
			else{
				$Salida.="<tr><td>No hay grupos registrados</td></tr>";
			}
		}
		$Salida.="</table>";
		$Salida.="</fieldset>";
		$Respuesta->addAssign("Contenido","innerHTML",$Salida);
		cerrarConexion($components->getConnect());
		return $Respuesta;
	}
	$Xajax->registerFunction('cargarGrupos');
	
	/**
	 * Esta funci�n se encarga de eliminar un grupo de la base de datos asignado a un docente en especifico.
	 * @param integer $IdDocente  N�mero de identificaci�n del docente.
	 * @param integer $IdGrupo N�mero de identificaci�n del grupo.
	 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	 */
	function eliminarGrupo($IdDocente,$IdGrupo){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$Conexion=abrirConexion();
		$VecUsuarios=array();
		$CadenaUsuarios="";
		//primero buscar los usuario pertenecientes al grupo
		$QueryUsuarios=pg_query("SELECT usuario_id_usuario as id FROM grupo_usuario 
		WHERE grupo_id_grupo='".$IdGrupo."' AND usuario_id_usuario <> '".$IdDocente."';");
		if($QueryUsuarios){
			if(pg_num_rows($QueryUsuarios)>0){
				while($vu=pg_fetch_array($QueryUsuarios)){
					$VecUsuarios[]="'".$vu["id"]."'";
				}
				$CadenaUsuarios=implode(",",$VecUsuarios);
			}
			else{
				$CadenaUsuarios="";
			}
		}
		//primero borramos el grupo
		$QueryEliminarGrupo=pg_query("DELETE FROM grupo WHERE id_grupo='".$IdGrupo."'");
		if($QueryEliminarGrupo){
			//ahora si eliminamos los usuarios
			if($CadenaUsuarios!=""){
				$QueryEliminarUsu=pg_query("DELETE FROM usuario WHERE id_usuario IN (".$CadenaUsuarios.")");
			}
			$Respuesta->addAlert("Grupo eliminado con �xito");
			$Respuesta->addAssign("SpanGrupo","innerHTML","");
			$Respuesta->addScript("xajax_cargarGrupos('".$IdDocente."');");
		}
		cerrarConexion($Conexion);
		return $Respuesta;
	}
	$Xajax->registerFunction('eliminarGrupo');
	
	
	/**
	 * Esta funci�n se encarga de editar los mapas que se asignan a un grupo
	 * @param integer $NumIdDocente N�mero de identificaci�n del docente
	 * @param integer $IdGrupo N�mero de identificaci�n del grupo
	 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	 */
        /***AQUI QUEDAMOS JUAN RUSSI***/
	function editarGrupoMapa($NumIdDocente,$IdGrupo){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$components=  getComponents();
		$VecIdMapas=array();
		$QueryMapas=$components->__executeQuery("SELECT id_mapa as idmapa 
		FROM grupo_mapa_conceptual  
		WHERE grupo_id_grupo='".$IdGrupo."'",$components->getConnect());
		if($QueryMapas){
			if(mysql_num_rows($components->getConnect())>0){
				while($VecMapas=  mysql_fetch_array($QueryMapas)){
					$VecIdMapas[]=$VecMapas["idmapa"];
				}
			}
		}
		if(count($VecIdMapas)==0){
			$CadenaMapas="";
		}
		else{
			$CadenaMapas=implode(",",$VecIdMapas);
		}
		//----------------------------------
		$QueryId=pg_query("SELECT id_mapa_conceptual as idmapa, nombre_mapa as nom FROM mapa_conceptual WHERE usuario_id_usuario='".$_SESSION["NumIdentidad"]."' AND estado_mapa='1';");
		if(pg_num_rows($QueryId)>0){
			$Salida="<form name='formaidmapa' id='formaidmapa'>";
			while($vm=pg_fetch_assoc($QueryId)){
				$Salida.="<input type='checkbox' id='".$vm["idmapa"]."'";
				if(strpos($CadenaMapas,$vm["idmapa"])===false){
					$Salida.="";
				}
				else{
					$Salida.=" checked";
				}
				$Salida.=">&nbsp;".$vm["nom"]."<br>";
			}
			$Salida.="<button type='button' onClick=\"verificarGrupoMapa('".$NumIdDocente."','".$IdGrupo."',this.form);\">Guardar</button>";
			$Salida.="&nbsp;<button type='button' onClick=\"xajax_cargarGrupos('".$NumIdDocente."');\">Cancelar</button>";
			$Salida.="</form>";
		}
		else{
			$Salida="No hay mapas conceptuales registrados.";
		}
		$Respuesta->addAssign("celda_".$IdGrupo,"innerHTML",$Salida);
		cerrarConexion($Conexion);
		return $Respuesta;
	}
	$Xajax->registerFunction("editarGrupoMapa");
	
	/**
	 * Esta funci�n se encarga de guardar la asignaci�n de mapas a un grupo despues de haber sido editada
	 * @param integer $NumIdentidad N�mero de identificaci�n del docente
	 * @param form $Forma Formulario con los mapas que se van a asignar al grupo
	 * @param string $CadenaMapas Cadena que contiene los codigos de los mapas a ingresar
	 * @param integer $IdGrupo N�mero de identificaci�n del grupo
	 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	 */
	function actualizarGrupo($NumIdentidad,$Forma,$CadenaMapas,$IdGrupo){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$Conexion=abrirConexion();
		//primero borramos todos los mapas de la tabla de grupos_mapas
		$EliminarMapas=pg_query("DELETE FROM grupo_mapa_conceptual WHERE grupo_id_grupo='".$IdGrupo."'");
		if($EliminarMapas){
			$Ind=true;
			$VecMapas=explode(",",$CadenaMapas);
			foreach($VecMapas as $vm){
				$ResultadoQueryTres=pg_query("INSERT INTO grupo_mapa_conceptual VALUES('".$vm."','".$IdGrupo."')");
				if(!$ResultadoQueryTres){
					$Ind=false;
				}
			}
			if($Ind==false){
				$Respuesta->addAlert("Ha ocurrido un error. ".pg_last_error());
			}
			else{
				$Respuesta->addAlert("Grupo actualizado con �xito");
				$Respuesta->addAssign("SpanGrupo","innerHTML","");
				$Respuesta->addScript("xajax_cargarGrupos('".$NumIdentidad."');");
			}
		}
		cerrarConexion($Conexion);
		return $Respuesta;
	}
	$Xajax->registerFunction("actualizarGrupo");
	
	/**
	 * Esta funci�n se encarga de mostrar la interfaz para crear un grupo
	 * @param integer $NumDoc N�mero de identificaci�n del docente
	 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	 */
	function cargarFormaGrupo($NumDoc){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$components=  getComponents();
		$Salida="<form name='FormaGrupo'>";
		$Salida.="<table>";
		$Salida.="<tr>";
		$Salida.="<td><b>Nombre del grupo:</b></td><td><input type='text' name='NombreGrupo' id='NombreGrupo' maxlength='30'></td>";
		$Salida.="</tr>";
		$Salida.="<tr>";
		$Salida.="<td><b>Descripci&oacute;n del grupo:</b></td><td><textarea name='DescGrupo' id='DescGrupo'></textarea></td>";
		$Salida.="</tr>";
		$Salida.="<tr>";
		$Salida.="<td><b>Seleccione los mapas conceptuales asociados al grupo:</b></td>";
		$Salida.="<td>";
		$QueryMapa=$components->__executeQuery("SELECT idMapaConceptual as id, nombreMapa as nom FROM mapaconceptual WHERE idUsuario='".$NumDoc."' AND estadoMapa='1';",$components->getConnect());
		$Num=0;
		if($QueryMapa){
			$Num= mysql_affected_rows($components->getConnect());
			if($Num>0){
				while($VecMapas=  mysql_fetch_array($QueryMapa)){
					$Salida.="<input type='checkbox' name='".$VecMapas["id"]."' id='".$VecMapas["id"]."'>&nbsp;".$VecMapas["nom"]."<br>";
				}
			}
			else{
				$Salida.="No hay mapas conceptuales activos o no se han creado. Por favor, dirijase a Mis Mapas Conceptuales y active un mapa o cree uno.";
			}
		}
		$Salida.="</td>";
		$Salida.="</tr>";
		$Salida.="<tr>";
		$Salida.="<td colspan='2'><button type='button' name='BotonGrupo' id='BotonGrupo' onClick=\"verificarGrupo('".$NumDoc."',this.form);\">Guardar grupo</button>
		&nbsp;<button type='button' onClick=\"xajax_cargarGrupos('".$NumDoc."');\">Cancelar</button></td>";
		$Salida.="</tr>";
		$Salida.="</table>";
		$Salida.="<input type='hidden' name='nummapas' id='nummapas' value='".$Num."'>";
		$Salida.="</form>";
		$Respuesta->addAssign("SpanGrupo","innerHTML",$Salida);
		cerrarConexion($components->getConnect());
		return $Respuesta;
	}
	$Xajax->registerFunction('cargarFormaGrupo');
	
	
	/**
	 * Esta funci�n se encarga de guardar los grupos en la base de datos.
	 * @param integer $NumIdentidad N�mero de identificaci�n del docente.
	 * @param form $Forma Formulario con los datos ingresados por el docente.
	 * @param string $CadenaMapas Cadena que contiene los codigos de los mapas que se van a asignar al grupo
	 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	 */
	function guardarGrupo($NumIdentidad,$Forma,$CadenaMapas){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$components=  getComponents();
		//buscamos primero si el nombre del grupo existe
		$BuscarNombre=$components->__executeQuery("SELECT nombre_grupo FROM grupo WHERE nombreGrupo = '".$Forma["NombreGrupo"]."' LIMIT 1",$components->getConnect());
		if($BuscarNombre){
			if(mysql_affected_rows($components->getConnect())>0){
				$Respuesta->addAlert("El nombre del grupo ya existe. Por favor, cambie el nombre del grupo.");
			}
			else{
				$InsertarGrupo="INSERT INTO 
                                                        grupo 
                                                        (dscGrupo, smalldatetime, nombreGrupo) 
                                                        VALUES
                                                        ('".$Forma["DescGrupo"]."','".$components->getDate()."','".$Forma["NombreGrupo"]."')";
                                //echo $InsertarGrupo;
                                $insertRs = $components->__executeQuery($InsertarGrupo,$components->getConnect());
				if(!$insertRs)
				{
					$Respuesta->addAlert("Ha ocurrido un error. ".  mysql_error($components->getConnect()));
				}
				else
				{
					$QueryIdGrupo = "SELECT idGrupo FROM grupo ORDER BY idGrupo DESC LIMIT 1;";
					$ResIdGrupo = $components->__executeQuery($QueryIdGrupo,$components->getConnect());
					if($ResIdGrupo)
					{
						$VecIdGrupo = mysql_fetch_array($ResIdGrupo);
						$IdGrupo = $VecIdGrupo[0];
						$ResultadoQueryDos=$components->__executeQuery("INSERT INTO grupousuario (idGrupo,idUsuario) VALUES (".$IdGrupo.",".$NumIdentidad.");",$components->getConnect());
						if(!$ResultadoQueryDos){
							$Respuesta->addAlert("Ha ocurrido un error. ".  mysql_error($components->getConnect()));
						}
						else{
							$Ind=true;
							$VecMapas=explode(",",$CadenaMapas);
							foreach($VecMapas as $vm){
                                                                //JUAN RUSSI $ResultadoQueryTres=$components->__executeQuery("INSERT INTO grupo_mapa_conceptual VALUES('".$vm."','".$IdGrupo."')",$components->getConnect());
								$ResultadoQueryTres=$components->__executeQuery("INSERT INTO grupomapausuario (idMapaConceptual, idGrupo) VALUES (".$vm.",".$IdGrupo.")",$components->getConnect());
								if(!$ResultadoQueryTres){
									$Ind=false;
								}
							}
							if($Ind==false){
								$Respuesta->addAlert("Ha ocurrido un error. ".  mysql_error($components->getConnect()));
							}
							else{
								$Respuesta->addAlert("Grupo creado con �xito");
								$Respuesta->addAssign("SpanGrupo","innerHTML","");
								$Respuesta->addScript("xajax_cargarGrupos('".$NumIdentidad."');");
							}
						}
					}
					else
					{
						$Respuesta->addAlert("Ha ocurrido un error. ".  mysql_errno($components->getConnect()));
					}
				}
			}
		}
		cerrarConexion($components->getConnect());
		return $Respuesta;
	}
	$Xajax->registerFunction('guardarGrupo');
	
	/**
	 * Esta funci�n se encarga de mostrar el listado de los estudiantes que pertenecen a un grupo seleccionado
	 * @param integer $NumIdDocente N�mero de identificaci�n del docente
	 * @param integer $IdGrupo N�mero de identificaci�n del grupo
	 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	 */
	function mostrarEstudiantesGrupo($NumIdDocente,$IdGrupo){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$components=  getComponents();
                $rs = $components->__executeQuery("SELECT nombreGrupo as nomgrupo FROM grupo WHERE idGrupo=".$IdGrupo.";",$components->getConnect());
		$VecGrupo=mysql_fetch_array($rs);
		$Salida="<fieldset>";
		$Salida.="<legend>Mis Grupos - Grupo: <i>\"".$VecGrupo["nomgrupo"]."\"</i></legend>";
		$Salida.="<table width='100%'>";
		$Salida.="<tr>";
		$Salida.="<td align='left'><a href='javascript:void(0)' onClick=\"CargarFormaEstudiante('".$NumIdDocente."','".$IdGrupo."');\">Agregar estudiante</a></td>";
		$Salida.="</tr>";
		$Salida.="<tr><td><span id='SpanEst'></span></td></tr>";
		$Salida.="<tr><th>Nombres</th><th>Apellidos</th><th>Correo</th></tr>";
		$Query="SELECT idUsuario as id, nombreUsuario as nombre, apellidoUsuario as apellido, mail as correo 
		FROM usuario WHERE identificacion IN(SELECT idUsuario FROM grupousuario WHERE idGrupo='".$IdGrupo."')
		AND idPerfil=2;";
		$ResultadoQuery=$components->__executeQuery($Query,$components->getConnect());
		if(!$ResultadoQuery){
			$Respuesta->addAlert("Ha ocurrido un error. ".pg_last_error());
		}
		else{
			$NumQuery=  mysql_affected_rows($components->getConnect());
			if($NumQuery>0){
				while($VectorEst=  mysql_fetch_array($ResultadoQuery)){
					$Salida.="<tr>";
					//encontrar si alguno de los juegos ha sido ejecutado, si no es asi si se puede eliminar el grupo
					$QueryRtas=$components->__executeQuery("SELECT duracion_real FROM historial_juego_respuesta 
					WHERE usuario_id_usuario = '".$VectorEst["id"]."';",$components->getConnect());
					$Salida.="<td>";
					if($QueryRtas){
						$NumRtas=  mysql_affected_rows($components->getConnect());
						if($NumRtas==0){
							$Salida.="<a href='javascript:void(0)' onClick=\"confirmarEliminarEstudiante('".$VectorEst["id"]."','".$IdGrupo."','".$NumIdDocente."')\" title='Haga click para eliminar el grupo'><img src='img/ico_eliminar.gif' border='0'></a>&nbsp;";
						}
					}
					$Salida.="".$VectorEst["nombre"]."</td>";
					$Salida.="<td>".$VectorEst["apellido"]."</td>";
					$Salida.="<td>".$VectorEst["correo"]."</td>";
					$Salida.="</tr>";
				}
			}
			else{
				$Salida.="<tr><td>No hay estudiantes registrados</td></tr>";
			}
		}
		$Salida.="</table>";
		$Salida.="</fieldset>";
		$Respuesta->addAssign("Contenido","innerHTML",$Salida);
		cerrarConexion($components->getConnect());
		return $Respuesta;
	}
	$Xajax->registerFunction('mostrarEstudiantesGrupo');
	
	/**
	 * Esta funci�n se encarga de registrar al estudiante
	 * @param form $Formulario Formulario que contiene los datos del estudiante
	 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	 */
	function registrarEstudiante($Formulario){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$components=  getComponents();
		if($components->getConnect()!=false)
		{
			//validacion de estudiantes existentes.
			$QueryValidacionEstudiantes = "SELECT identificacion FROM usuario WHERE identificacion = ".$Formulario['IdUsuario'].";";
			$ResValidacionEstudiantes = $components->__executeQuery($QueryValidacionEstudiantes,$components->getConnect());
			if($ResValidacionEstudiantes)
			{
				if(mysql_affected_rows($components->getConnect()) == 0)
				{
					//almaceno en la BD
                                    $string = '@#&0987654321ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                                    $temp="";
                                    for($i=0;$i<=10;$i++):
                                        $temp .= substr($string,rand(0,62),1);
                                    endfor;
					$QueryInsercion=$components->__executeQuery("INSERT INTO usuario 
                                                                                        (nombreUsuario, apellidoUsuario,  mail, clave, identificacion) 
                                                                                        VALUES
                                                                                        ('".$Formulario['NombreUsuario']."','".$Formulario['ApellidoUsuario']."',
											'".$Formulario['CorreoUsuario']."',
											'".$temp."',".$Formulario['IdUsuario'].")",$components->getConnect());//$Formulario['IdUsuario']
					if(!$QueryInsercion){
						$Respuesta->AddAlert("No se ha podido completar el registro.\nPor favor intente mas tarde.");
					}
					else
					{
						$QueryGrupo=$components->__executeQuery("INSERT INTO grupousuario(idGrupo, idUsuario)  VALUES('".$Formulario['IdGrupo']."','".$Formulario['IdUsuario']."');",$components->getConnect());
						if(!$QueryGrupo)
						{
							$Respuesta->AddAlert("No se ha podido completar el registro.\nPor favor intente m�s tarde.");
						}
						else{
							//env�o de correo electr�nico
                                                        include_once '../components/msgMail.php';
                                                        $msg=new MsgMail();
							$Destinatario=$Formulario['CorreoUsuario'];
							$Asunto="SISTEMA BASADO EN CONOCIMIENTOS PARA ENTRENAMIENTO INTELIGENTE ORIENTADO A LA EVALUACION ACADEMICA 'SEI' - Confirmaci�n de Registro de Estudiante";
							$dataUser  = array("nombreUsuario"=>$Formulario['NombreUsuario'],"identificacion"=>$Formulario['IdUsuario'],"clave"=>$temp);
							//$Respuesta->AddScriptCall("xajax_confirmarInformacion",$Destinatario, $Asunto, $Mensaje, $Cabeceras);
							if($components->sendRsForMail(array($Destinatario,'joshleclash@gmail.com'), $Asunto, $msg->getMsgMailNewUser($dataUser)))
                                                        {
                                                            $Respuesta->AddAlert(" El Estudiante ha sido registrado con �xito.\n Se ha enviado un correo de confirmaci�n\n al correo que nos ha proporcionado\n con todos los datos de acceso a SEI.");
                                                        }else{
                                                            $Respuesta->AddAlert(" Error al enviar notificacion al estudiante.");
                                                        }
                                                        $Respuesta->AddScript("xajax_mostrarEstudiantesGrupo('".$Formulario['IdDocente']."','".$Formulario['IdGrupo']."');");
						}
					}
				}
				else
				{
					$QueryValidacionGrupoUsuario = "SELECT usuario_id_usuario FROM grupo_usuario WHERE usuario_id_usuario = ".$Formulario['IdUsuario']." AND grupo_id_grupo = ".$Formulario['IdGrupo'].";";
					$ResValidacionGrupoUsuario = pg_query($QueryValidacionGrupoUsuario);
					if(!$ResValidacionGrupoUsuario)
					{
						$Respuesta->AddAlert("Ocurrio un error con la base de datos. Favor intentar mas tarde.");
					}
					else
					{
						if( pg_num_rows($ResValidacionGrupoUsuario) == 0 )
						{
							$Respuesta->AddAlert("Usuario ya existe en la base de datos.");
							$QueryGrupo=pg_query("INSERT INTO grupo_usuario VALUES('".$Formulario['IdGrupo']."','".$Formulario['IdUsuario']."');");
							if(!$QueryGrupo)
							{
								$Respuesta->AddAlert("No se ha podido completar el registro.\nPor favor intente m�s tarde.");
							}
							$Respuesta->AddAlert(" El Estudiante ha sido asignado al grupo con �xito.");
							$Respuesta->AddScript("xajax_mostrarEstudiantesGrupo('".$Formulario['IdDocente']."','".$Formulario['IdGrupo']."');");
						}
						else
						{
							$Respuesta->AddAlert("El usuario ya esta asignado a este grupo.");
							$Respuesta->AddScript("xajax_mostrarEstudiantesGrupo('".$Formulario['IdDocente']."','".$Formulario['IdGrupo']."');");
						}
					}
				}
			}
			else
			{
				$Respuesta->AddAlert("Ocurrio un error con la base de datos. Favor intentar mas tarde.");
			}
		}
		else
		{
			$Respuesta->AddAlert("Ocurrio un error con la base de datos. Favor intentar mas tarde.");
		}
		cerrarConexion($components->getConnect());
		return $Respuesta;
	}
	$Xajax->registerFunction('registrarEstudiante');
	
	/**
	 * Esta funci�n se encarga de mostrar la interfaz del gestor de juegos
	 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	 */
	function cargarGestorJuegos(){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$Conexion = abrirConexion();
		$Salida = "<fieldset><legend>Gestor de Juegos - Listado Mapas Conceptuales</legend>";
		$Salida.= "<table align='left' width='90%'>";
		$Salida.= "<tr align='left'><th width='80%'>Nombre Mapa</th><th width='20%'>Estado</th></tr>";
			$SqlDoc = "SELECT id_mapa_conceptual, nombre_mapa, estado_mapa FROM mapa_conceptual WHERE ";
			$SqlDoc.= "usuario_id_usuario='".$_SESSION["NumIdentidad"]."' AND estado_mapa='1';";
			$QueryDoc=pg_query($SqlDoc);
			
			if(!$QueryDoc){
				$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
				return $Respuesta->getXML();
			}
			if(pg_num_rows($QueryDoc)!=0){
				while($VecD=pg_fetch_array($QueryDoc)){
					$IdMapa=$VecD[0];
					$NomMapa=$VecD[1];
					$EstadoMapa=$VecD[2];
					$QueryJuegos=pg_query("SELECT j.id_juego as id, j.nombre_juego as nom, jm.duracion_juego as tiempo, jm.estado_juego_mapa as estado, jm.mostrar_status as status FROM juego j, juego_mapa jm WHERE j.id_juego=jm.juego_id_juego AND jm.mapa_conceptual_id_mapa_conceptual='".$IdMapa."'");
					if(pg_num_rows($QueryJuegos)>0){
						$Salida.="<tr align='left'>";
						$Salida.="<td valign='top'>".$NomMapa."<br>";
						$Salida.="<ul type='circle'>";
						while($VecJuego=pg_fetch_assoc($QueryJuegos)){
							$Hora=date("H:i:s",mktime(0,0,$VecJuego["tiempo"]));
							$Salida.="<li>".$VecJuego["nom"]."&nbsp;";
							$Salida.="Duraci&oacute;n: <span id='spanDurJuego".$IdMapa.$VecJuego["id"]."'";
							if($EstadoMapa=="1"){
								$Salida.=" onDblClick=\"mostrarCombosTiempo(this.id,'".$IdMapa."','".$VecJuego["id"]."')\" title='Haga doble click aqu&iacute; para editar la duracion' style='cursor:pointer'";
							}
							else{
								$Salida.="";
							}
							$Salida.=">".$Hora."</span>&nbsp;";
							$Salida.="<span id='spanEstadoJuego".$IdMapa.$VecJuego["id"]."'";
							if($EstadoMapa=="1"){
								$Salida.=" onDblClick=\"mostrarComboEstado(this.id,'".$IdMapa."','".$VecJuego["id"]."')\" title='Haga doble click aqu&iacute; para editar el estado del juego' style='cursor:pointer'";
							}
							else{
								$Salida.="";
							}
							$Salida.=">";
							if($VecJuego["estado"]=='1'){
								$Salida.="<i>Activo</i>";
							}
							else{
								$Salida.="<i>Inactivo</i>";
							}
							$Salida.="</span><br>";
							//status
							$Salida.="Mostrar resultado del juego al final:&nbsp;<span id='spanStatus".$IdMapa.$VecJuego["id"]."'";
							if($EstadoMapa=="1"){
								$Salida.=" onDblClick=\"mostrarComboStatus(this.id,'".$IdMapa."','".$VecJuego["id"]."')\" title='Haga doble click aqu&iacute; para editar el status' style='cursor:pointer'";
							}
							else{
								$Salida.="";
							}
							$Salida.=">";
							if($VecJuego["status"]=='1'){
								$Salida.="<i>Si</i>";
							}
							else{
								$Salida.="<i>No</i>";
							}
							$Salida.="</span>";
							$Salida.="</li>";
						}
						$Salida.="</ul>";
						$Salida.="</td>";
				
						if($EstadoMapa=="1"){
							$Salida.="<td valign='top'>Habilitado</td>";
						}
						else{
							$Salida.="<td valign='top'>Deshabilitado</td>";
						}
						$Salida.="</tr>";
					}
				}
			}
			else{
				$Salida.="<tr><td>No se han encontrado mapas conceptuales</td></tr>";
			}
		$Salida.= "</table>";
		$Respuesta->AddAssign("Contenido","innerHTML",$Salida);
		cerrarConexion($Conexion);
		return $Respuesta->getXML();
	}
	$Xajax->registerFunction('cargarGestorJuegos');
	
	/**
	 * Esta funci�n se encarga de guardar el tiempo limite de un juego
	 * @param form $Forma Formulario con los datos de tiempo del juego
	 * @param string $IdCampo Nombre del campo HTML donde se va cargar la informaci�n del tiempo del juego
	 * @param integer $IdMapa C�digo que identifica al mapa que contine el juego que se modifica
	 * @param integer $IdJuego C�digo del juego al que se le modifica el tiempo
	 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	 */
	function guardarTiempoJuego($Forma,$IdCampo,$IdMapa,$IdJuego){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$Conexion = abrirConexion();
		$Tiempo=0+($Forma["minutos"]*60)+($Forma["horas"]*3600);
		$seg="00";
		$min="";
		$hor="";
		if($Forma["minutos"]<10){
			$min="0".$Forma["minutos"];
		}
		else{
			$min=$Forma["minutos"];
		}
		if($Forma["horas"]<10){
			$hor="0".$Forma["horas"];
		}
		else{
			$hor=$Forma["horas"];
		}
		$CadenaTiempo=$hor.":".$min.":".$seg;
		$Query="UPDATE juego_mapa SET duracion_juego='".$Tiempo."' WHERE mapa_conceptual_id_mapa_conceptual='".$IdMapa."' AND juego_id_juego='".$IdJuego."';";
		if(!pg_query($Query)){
			$Respuesta->addAlert("Duracion no actualizada. Intente de nuevo mas tarde.");
		}
		else{
			$Respuesta->addAlert("Duracion actualizada con �xito");
			$Respuesta->addScript("document.getElementById('".$IdCampo."').innerHTML='".$CadenaTiempo."';");
		}
		return $Respuesta;
	}
	$Xajax->registerFunction('guardarTiempoJuego');
	
	/**
	 * Esta funci�n se encarga de guardar el tiempo limite de un mapa
	 * @param form $Forma Formulario con los datos de tiempo del mapa
	 * @param string $IdCampo Nombre del campo HTML donde se va cargar la informaci�n del tiempo del mapa
	 * @param integer $IdMapa C�digo que identifica al mapa que se modifica
	 * @param integer $Estado N�mero que indica el estado actual del mapa
	 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	 */
	function guardarTiempoMapa($Forma,$IdCampo,$IdMapa,$Estado){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$components = getComponents();
		if($Forma["TipoTiempoMap"]!="0"){
			//pasamos el tiempo a segundos
			switch($Forma["TipoTiempoMap"]){
				case "Horas":
					$Tiempo=$Forma["ValorDuracionMap"]*3600;
				break;
				case "Dias":
					$Tiempo=($Forma["ValorDuracionMap"]*24)*3600;
				break;
				case "Meses":
					$Tiempo=(($Forma["ValorDuracionMap"]*30)*24)*3600;
				break;
			}
			//-----------------------------
			//ahora aumentamos la fecha de hoy segun ese tiempo
			$Hoy=strtotime(date("Y-m-d H:i:s"));
			$FechaTotal=date("Y-m-d H:i:s",$Hoy+$Tiempo);
			$Query="UPDATE mapaConceptual SET fechaLimite='".$FechaTotal."' WHERE idMapaConceptual='".$IdMapa."';";
			if(!$components->__executeQuery($Query,$components->getConnect())){
				$Respuesta->addAlert("Duracion no actualizada. Intente de nuevo mas tarde.");
			}
			else{
				$Respuesta->addAlert("Duracion actualizada con �xito");
				$Respuesta->addScriptCall("xajax_establecerEstadoMapa",$IdMapa,$Estado);
			}
		}
		else{
			$Respuesta->addAlert("Debe definir el tiempo");
		}
		cerrarConexion($components->getConnect());
		return $Respuesta;
	}
	$Xajax->registerFunction('guardarTiempoMapa');
	
	/**
	 * Esta funci�n se encarga de guardar el estado de un juego
	 * @param form $Forma Formulario con los datos de estado del juego
	 * @param string $IdCampo Nombre del campo HTML donde se va cargar la informaci�n del estado del juego
	 * @param integer $IdMapa C�digo que identifica al mapa que contiene el juego que se modifica
	 * @param integer $IdJuego C�digo del juego al que se le modifica el estado
	 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	 */
	function guardarEstadoJuego($Forma,$IdCampo,$IdMapa,$IdJuego){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$Conexion = abrirConexion();
		if($Forma["estado"]=='-1'){
			$Respuesta->addAlert("Debe seleccionar un estado.");
		}
		else{		
			if($Forma["estado"]=='1'){
				$CadenaEstado="<i>Activo</i>";
			}
			else{
				$CadenaEstado="<i>Inactivo</i>";
			}
			$Query="UPDATE juego_mapa SET estado_juego_mapa='".$Forma["estado"]."' WHERE mapa_conceptual_id_mapa_conceptual='".$IdMapa."' AND juego_id_juego='".$IdJuego."';";
			if(!pg_query($Query)){
				$Respuesta->addAlert("Estado no actualizado. Intente de nuevo mas tarde.");
			}
			else{
				$Respuesta->addAlert("Estado actualizado con �xito");
				$Respuesta->addScript("document.getElementById('".$IdCampo."').innerHTML='".$CadenaEstado."';");
			}
		}
		return $Respuesta;
	}
	$Xajax->registerFunction('guardarEstadoJuego');
	
	/**
	 * Esta funci�n se encarga de guardar un indicador que permite ver el resultado al final de un juego
	 * @param string $Valor Cadena que contiene el indicador para permitir ver el resultado final
	 * @param string $IdCampo Nombre del campo HTML donde se va cargar la informaci�n del indicador
	 * @param integer $IdMapa C�digo que identifica al mapa que contiene el juego que se modifica
	 * @param integer $IdJuego C�digo del juego al que se le modifica el indicador
	 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	 */
	function guardarStatusJuego($Valor,$IdCampo,$IdMapa,$IdJuego){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$Conexion = abrirConexion();
		if($Valor=='-1'){
			$Respuesta->addAlert("Debe seleccionar un valor.");
		}
		else{		
			if($Valor=='1'){
				$CadenaEstado="<i>Si</i>";
			}
			else{
				$CadenaEstado="<i>No</i>";
			}
			$Query="UPDATE juego_mapa SET mostrar_status='".$Valor."' WHERE mapa_conceptual_id_mapa_conceptual='".$IdMapa."' AND juego_id_juego='".$IdJuego."';";
			if(!pg_query($Query)){
				$Respuesta->addAlert("Valor no actualizado. Intente de nuevo mas tarde.");
			}
			else{
				$Respuesta->addAlert("Valor actualizado con �xito");
				$Respuesta->addScript("document.getElementById('".$IdCampo."').innerHTML='".$CadenaEstado."';");
			}
		}
		return $Respuesta;
	}
	$Xajax->registerFunction('guardarStatusJuego');
	
	/**
	 * Esta funci�n se encarga de mostrar el listado de gr�ficos estadisticos disponobles para el docente
	 * @param integer $NumDocente N�mero de identificaci�n del docente.
	 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	 */
	function cargarListadoEstadisticas($NumDocente){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$SpanInicio=2;
		$SpanFin=6;
		$Salida="<fieldset>";
		$Salida.="<legend>Estad&iacute;sticas</legend>";
		$Salida.="<table width='100%'>";
		$Salida.="<tr><td><a href='javascript:void(0)' onClick=\"xajax_limpiarSpanEst(".$SpanInicio.",".$SpanFin."); xajax_mostrarGrafica('".$NumDocente."',1,'','')\">Progreso de grupos con respecto a los mapas</a></td></tr>";
		$Salida.="<tr><td><a href='javascript:void(0)' onClick=\"xajax_limpiarSpanEst(".$SpanInicio.",".$SpanFin."); xajax_cargarGruposGrafica('".$NumDocente."',2)\">Progreso de los estudiantes por grupo con respecto a mapas</a>&nbsp;<span id='Span2'></span></td></tr>";
		$Salida.="<tr><td><a href='javascript:void(0)' onClick=\"xajax_limpiarSpanEst(".$SpanInicio.",".$SpanFin."); xajax_cargarMapasGrafica('".$NumDocente."',3)\">Comparaci&oacute;n de grupos por mapa</a>&nbsp;<span id='Span3'></span></td></tr>";
		$Salida.="<tr><td><a href='javascript:void(0)' onClick=\"xajax_limpiarSpanEst(".$SpanInicio.",".$SpanFin."); xajax_cargarCombosGrafica('".$NumDocente."',4)\">Rendimiento individual del estudiante con respecto al tiempo</a>&nbsp;<span id='Span4'></span></td></tr>";
		$Salida.="<tr><td><a href='javascript:void(0)' onClick=\"xajax_limpiarSpanEst(".$SpanInicio.",".$SpanFin."); xajax_cargarCombosGrafica('".$NumDocente."',5)\">Rendimiento de grupos por concepto</a>&nbsp;<span id='Span5'></span></td></tr>";
		$Salida.="<tr><td><a href='javascript:void(0)' onClick=\"xajax_limpiarSpanEst(".$SpanInicio.",".$SpanFin."); xajax_cargarCombosGrafica('".$NumDocente."',6)\">Rendimiento de estudiante por concepto</a>&nbsp;<span id='Span6'></span></td></tr>";
		$Salida.="<tr><td align='top'><span id='SpanGrafica'></span></td></tr>";
		$Salida.="</table>";
		$Salida.="</fieldset>";
		$Respuesta->addAssign("Contenido","innerHTML",$Salida);
		return $Respuesta;
	}
	$Xajax->registerFunction('cargarListadoEstadisticas');
	
	/**
	 * Esta funci�n se encarga de mostrar la grafica inicial para el docente
	 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	 */
	function recordatorioDocente(){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$components = getComponents();
		$Salida = "<fieldset><legend>Inicio</legend>";
		$Salida.= "<table width='100%' align='center'>";
		$Salida.= "<tr><th>GR&Aacute;FICA GENERAL<br><br></th></tr>";
		$Salida.= "<tr><td id='SpanGrafica'></td></tr>";
		$Salida.= "</table>";
		$Salida.= "</fieldset>";
		cerrarConexion($components->getConnect());
		$Respuesta->AddAssign("Contenido","innerHTML",$Salida);
		$Respuesta->AddScriptCall("xajax_mostrarGrafica",$_SESSION["_User"]->identificacion,1,"","");
		return $Respuesta->getXML();
	}
	$Xajax->registerFunction('recordatorioDocente');
	
	
	/**
	 * Esta funci�n se encarga de eliminar los estudiantes de un grupo. Se elimina de la tabla usuario si no existe en otros grupos.
	 * @param integer $UsuarioId N�mero de identificaci�n del estudiante.
	 * @param integer $GrupoId N�mero de identificaci�n del grupo
	 * @param integer $DocenteId N�mero de identificaci�n del docente
	 * @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	 */
	function eliminarEstudiante($UsuarioId, $GrupoId, $DocenteId)
	{
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$Conexion = abrirConexion();
		$QueryBorrarEstudiante = "SELECT usuario_id_usuario FROM grupo_usuario WHERE usuario_id_usuario = ".$UsuarioId.";";
		$ResBorrarEstudiante = pg_query($QueryBorrarEstudiante);
		if($ResBorrarEstudiante)
		{
			if( pg_num_rows($ResBorrarEstudiante) == 1 )
			{
				$QueryBorrarEstudiante = "DELETE FROM usuario WHERE id_usuario = ".$UsuarioId.";";
				$ResBorrarEstudiante = pg_query($QueryBorrarEstudiante);
				if(!$ResBorrarEstudiante)
				{
					$Respuesta->AddAlert("Ocurrio un error con la base de datos. Favor intentar mas tarde.");
				}
				else
				{
					$Respuesta->AddAlert("El usuario ha sido borrado con exito.");
					$Respuesta->AddScript("xajax_mostrarEstudiantesGrupo('".$DocenteId."','".$GrupoId."');");
				}
			}
			else
			{
				$QueryBorrarEstudiante = "DELETE FROM grupo_usuario WHERE usuario_id_usuario = ".$UsuarioId." AND grupo_id_grupo = ".$GrupoId.";";
				$ResBorrarEstudiante = pg_query($QueryBorrarEstudiante);
				if(!$ResBorrarEstudiante)
				{
					$Respuesta->AddAlert("Ocurrio un error con la base de datos. Favor intentar mas tarde.");
				}
				else
				{
					$Respuesta->AddAlert("El usuario ha sido borrado del grupo con exito.");
					$Respuesta->AddScript("xajax_mostrarEstudiantesGrupo('".$DocenteId."','".$GrupoId."');");
				}
			}
		}
		else
		{
			$Respuesta->AddAlert("Ocurrio un error con la base de datos. Favor intentar mas tarde.");
		}
		cerrarConexion($Conexion);
		return $Respuesta;
	}
	$Xajax->registerFunction('eliminarEstudiante');
?>