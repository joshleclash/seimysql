<?php
	//Atributos
	$NumIdentidad;
	$ApellidosUsuario;
	$NombreUsuario;
	$CorreoUsuario;
	$ClaveUsuario;
	/**
	* Esta funci�n se encarga de permitir el acceso al sistema
	* @param integer $NumIdentidad N�mero de identificaci�n del usuario 
	* @param string $ClaveUsuario Cadena que contiene la clave del usuario
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function ingresarAplicativo($NumIdentidad,$ClaveUsuario)
	{
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$Conexion = abrirConexion();
		if($Conexion!=false)
		{
			$ConsultaUsuario = "SELECT u.id_usuario as usuario, p.nombre_perfil as perfil, u.clave as clave 
								FROM usuario u, perfil p
								WHERE u.perfil_id_perfil=p.id_perfil 
								AND u.id_usuario = ".$NumIdentidad.";";
			$ResultadoQuery = mysql_query($ConsultaUsuario);
			$CantidadRegistros = mysql_num_rows($ResultadoQuery);
			if($CantidadRegistros > 0)
			{
				$VectorResultado = mysql_fetch_array($ResultadoQuery);
                                if($ClaveUsuario == $VectorResultado["clave"])
				{
				   //sesion
				   session_start();
//				   session_register("NumIdentidad","PerfilUsuario","JuegoAbierto");
				   $_SESSION["NumIdentidad"]=$VectorResultado["usuario"];
				   $_SESSION["PerfilUsuario"]=$VectorResultado["perfil"];
				   $_SESSION["JuegoAbierto"]=0;
				   $Respuesta->AddScript("location.href='principal.php';");
				}
				else
				{
					$Respuesta->AddAlert("El usuario y/o clave no corresponden. Verifique estos datos e intente de nuevo.");
				}
			}
			else
			{
				$Respuesta->AddAlert("El usuario y/o clave no corresponden. Verifique estos datos e intente de nuevo");
			}
		}
		else
		{
			$Respuesta->AddAlert("La conexion a la base de datos ha fallado");
		}
		cerrarConexion($Conexion);
		return $Respuesta;
	}
	$Xajax->registerFunction('ingresarAplicativo');
	
	/**
	* Esta funci�n se encarga de cambiar la contrase�a de un usuario
	* @param string $ClaveUsuario Clave actual del usuario 
	* @param string $ClaveUsuarioNueva Clave nueva del usuario 
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function cambiarContrasena($ClaveUsuario, $ClaveUsuarioNueva)
	{
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$Conexion = abrirConexion();
		$NumIdentidad = $_SESSION["NumIdentidad"];
		$ConsultaUsuario = "SELECT id_usuario
							FROM usuario 
							WHERE id_usuario = ".$NumIdentidad."
							AND clave = '".$ClaveUsuario."';";
		$ResultadoQuery = mysql_query($ConsultaUsuario);
		$CantidadRegistros = mysql_num_rows($ResultadoQuery);
		if($CantidadRegistros == 1)
		{
			$InsercionClave = "UPDATE usuario SET clave = '".$ClaveUsuarioNueva."' 
							   WHERE id_usuario = ".$NumIdentidad.";";
			if(!mysql_query($InsercionClave)){
				$Respuesta->AddAlert("Hubo un error al cambiar la contrase�a. Por favor, intente m�s tarde. ".pg_last_error());
			}
			else{
				$Respuesta->AddAlert("Contrase�a cambiada con �xito");
				$Respuesta->AddAssign("SpanClave","innerHTML","");
			}
		}
		else
		{
			$Respuesta->AddAlert("La contrase�a es invalida. Intente de nuevo con la contrase�a correcta");	
		}
		cerrarConexion($Conexion);
		return $Respuesta;
	}
	$Xajax->registerFunction('cambiarContrasena');
	
	/**
	* Esta funci�n se encarga de enviar un correo al usuario por si olvido la contrase�a
	* @param integer $NumIdentidad N�mero de identificaci�n del usuario 
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function olvidoContrasena($NumIdentidad)
	{
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$Conexion = abrirConexion();
		if($NumIdentidad==""){
			$Respuesta->addAlert("Digite el documento de identidad y haga click de nuevo.");
		}
		else{
			$ConsultaUsuario = "SELECT id_usuario, nombre_usuario, apellido_usuario, clave as clave, correo_usuario as correo 
			FROM usuario WHERE id_usuario = '".$NumIdentidad."';";
			$ResultadoQuery = mysql_query($ConsultaUsuario);
			$CantidadRegistros = mysql_num_rows($Conexion);
			if($CantidadRegistros == 1)
			{
				$VectorResultado = mysql_fetch_array($ResultadoQuery);
				//$Respuesta->addAlert(print_r($VectorResultado,true));
				//Llamar funcion mail
				$Destinatario=$VectorResultado['correo'];
				$Asunto="SEI - Recuperacion de contrase�a";
				$Mensaje = '<html><head><title>Registro al SEI</title></head>';
				$Mensaje.= '<body><table align="center"><tr><th>Hola, '.$VectorResultado['nombre_usuario'].'&nbsp;';
				$Mensaje.= ''.$VectorResultado['apellido_usuario'].'.</th></tr>';
				$Mensaje.= '<tr><td><br>Su solicitud de recuperaci&oacute;n  de contrase&ntilde;a ha sido aceptada exitosamente, a continuaci&oacute;n incluimos sus datos de acceso:<br></td></tr>';
				$Mensaje.= '<tr><td><br><strong>Documento de Identidad:</strong> '.$VectorResultado['id_usuario'].'</td></tr>';
				$Mensaje.= '<tr><td><strong>Clave Acceso:</strong>  '.$VectorResultado['clave'].'</td></tr>';
				$Mensaje.= '</table></body></html>';
				$Cabeceras = 'MIME-Version: 1.0' . "\r\n";
				$Cabeceras.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$Cabeceras.= 'To: '.$VectorResultado['nombre_usuario'].' '.$VectorResultado['apellido_usuario'].' <'.$VectorResultado['correo'].'>' . "\r\n";
				$Cabeceras.= 'From: admin@SEI.com' . "\r\n";
				
				$Respuesta->AddScriptCall("xajax_confirmarInformacion",$Destinatario, $Asunto, $Mensaje, $Cabeceras);
			}
			else
			{
				$Respuesta->AddAlert("El usuario no corresponde. Verifique los datos e intente de nuevo");
			}
		}
		cerrarConexion($Conexion);
		return $Respuesta;
	}
	$Xajax->registerFunction('olvidoContrasena');
	
	/**
	* Esta funci�n se encarga de enviar el correo al usuario
	* @param string $Destinatario Direcci�n de correo del destinatario 
	* @param string $Asunto Asunto del correo 
	* @param string $Mensaje Cuerpo del correo 
	* @param string $Cabeceras Parametros adicionales para el envio del correo 
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function confirmarInformacion($Destinatario,$Asunto,$Mensaje,$Cabeceras){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		//PHPMailer
		require("lib/PHPMailer_v5.0.2/class.phpmailer.php");
		$mail=new PHPMailer();
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host       = "localhost"; // SMTP server
		//$mail->SMTPDebug  = 2; 
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
		$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
		$mail->Port       = 465; 
		$mail->Username   = "admin.sceie@gmail.com";  // GMAIL username
		$mail->Password   = "123456789admin"; 
		
		$mail->SetFrom("admin@sei.com","SEI");
		$mail->AddAddress($Destinatario);
		$mail->Subject=$Asunto;
		$mail->MsgHTML($Mensaje);
		//fin phpmailer
		//if(!mail($Destinatario, $Asunto, $Mensaje, $Cabeceras)){
		if(!$mail->Send()){
			$Respuesta->AddAlert("No fu� posible enviar el correo, por favor intente mas tarde.");
		}
		else{
			//$Respuesta->AddAlert("Un correo de verificaci�n ha sido enviado a la direcci�n proporcionada por el usuario.");
		}
		
		return $Respuesta;
	}
	$Xajax->registerFunction('confirmarInformacion');
	
	/**
	* Esta funci�n se encarga de mostrar los juegos con mayor actividad
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function mostrarDestacados(){
		$Respuesta =  new xajaxresponse('ISO-8859-1');
		$Conexion = abrirConexion();
		$Salida = "";
		
		$SqlDest = "SELECT m.id_mapa_conceptual as Mapa, m.nombre_mapa as NomMap, count(a.juego_mapa_mapa_conceptual_id_mapa_conceptual) as Total ";
		$SqlDest.= "FROM historial_juego_respuesta a, mapa_conceptual m ";
		$SqlDest.= "WHERE a.usuario_id_usuario IN(";
		$SqlDest.= "	SELECT b.usuario_id_usuario FROM grupo_usuario b ";
		$SqlDest.= "	WHERE b.grupo_id_grupo IN(";
		$SqlDest.= "		SELECT c.grupo_id_grupo FROM grupo_usuario c ";
		$SqlDest.= "		WHERE c.usuario_id_usuario='".$_SESSION["NumIdentidad"]."'))";
		$SqlDest.= "AND m.estado_mapa = '1' ";
		$SqlDest.= "AND m.id_mapa_conceptual = a.juego_mapa_mapa_conceptual_id_mapa_conceptual ";
		$SqlDest.= "GROUP BY m.id_mapa_conceptual, m.nombre_mapa ORDER BY Total DESC LIMIT 3;";
		
		$QueryDest = mysql_query($SqlDest);
	
		if(!$QueryDest){
			$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
			return $Respuesta->getXML();
		}
		if(mysql_num_rows($QueryDest)==0){
			$Salida.="No hay destacados por el momento.";
			$Respuesta->AddAssign("Destacados","innerHTML",$Salida);
			return $Respuesta->getXML();
		}
		else{
			$Posicion = 1;
			while($VecDest = mysql_fetch_array($QueryDest)){
				$SqlJuego = "SELECT id_juego, nombre_juego FROM juego;";
				$QueryJuego = mysql_query($SqlJuego);
				
				if(!$QueryJuego){
					$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
					return $Respuesta->getXML();
				}
				$NomMapa = ucwords(strtolower($VecDest[1]));
				$CampoMapa = "D_Mapa".$Posicion;
				$Respuesta->AddAssign($CampoMapa,"innerHTML",$NomMapa);
				//$Respuesta->AddAlert($NomMapa." - ".$CampoMapa." - ".$Posicion);
				$SubPosicion = 1;
				while($VecJuego = mysql_fetch_array($QueryJuego)){
					$SqlFinal = "SELECT count(id_historial_juego_respuesta) FROM historial_juego_respuesta ";
					$SqlFinal.= "WHERE juego_mapa_juego_id_juego = '".$VecJuego[0]."' ";
					$SqlFinal.= "AND juego_mapa_mapa_conceptual_id_mapa_conceptual = '".$VecDest[0]."';";
					
					$QueryFinal = mysql_query($SqlFinal);
					if(!$QueryFinal){
						$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
						return $Respuesta->getXML();
					}
					$Total=mysql_fetch_array($QueryFinal);
					$NomJuego = ucwords(strtolower($VecJuego[1]));
					$CampoJuego = "D_Juego".$Posicion."_".$SubPosicion;
					$CampoTotal = "D_Veces".$Posicion."_".$SubPosicion;
					$Respuesta->AddAssign($CampoJuego,"innerHTML",$NomJuego);
					$Respuesta->AddAssign($CampoTotal,"innerHTML",$Total[0]);
					//$Respuesta->AddAlert($NomJuego." - ".$CampoJuego." - ".$SubPosicion);
					//$Respuesta->AddAlert($Total[0]." - ".$CampoTotal." - ".$SubPosicion);
					$SubPosicion++;
				}
				$Posicion++;
			}
		}
		cerrarConexion($Conexion);
		return $Respuesta->getXML();
	}
	$Xajax->registerFunction('mostrarDestacados');
	
	/**
	* Esta funci�n se encarga de cerrar la sesi�n del usuario actual
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function cerrarSesion(){
		$Respuesta = new xajaxResponse('ISO-8859-1');
		session_regenerate_id();
		session_unset();
		session_destroy();
		$Respuesta->AddScript("detenerCronometroTotal();");
		$Respuesta->AddScript("location.href='index.php';");
		return $Respuesta;
	}
	$Xajax->registerFunction('cerrarSesion');
?>