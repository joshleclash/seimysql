<?php
	/**
	* Esta funci�n se encarga de mostrar el listado de mapas conceptuales pertinentes al estudiante
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function sopaLetrasMapas(){
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
		$Salida = "<fieldset><legend>Sopa de Letras - Listado Mapas Conceptuales</legend>";
		$Salida.= "<table align='left' width='100%'>";
		$Salida.= "<tr align='right'><td colspan='6'><a href='javascript:void(0')' onClick='cargarInstruccionesJuego(1)'><img src='img/ico_editar.gif' border='0'>&nbsp;Instrucciones</a></td></tr>";
		$Salida.= "<tr align='left'><th width='30%'>Nombre Mapa</th><th>Tem&aacute;tica</th><th width='15%'>Estado</th><th>Fecha L&iacute;mite</th><th>Docente</th><th>Grupo</th></tr>";
		while($Vec=mysql_fetch_array($QueryMapa)){
			$Id=$Vec[0];
			$Gr=$Vec[1];
			
			$SqlDoc = "SELECT mc.id_mapa_conceptual, mc.nombre_mapa, mc.estado_mapa, mc.fecha_limite FROM mapa_conceptual mc, juego_mapa jm WHERE ";
			$SqlDoc.= "mc.id_mapa_conceptual IN(SELECT mapa_conceptual_id_mapa FROM grupo_mapa_conceptual WHERE ";
			$SqlDoc.= "grupo_id_grupo='".$Gr."') AND ";
			$SqlDoc.= "mc.usuario_id_usuario='".$Id."' AND ";
			$SqlDoc.= "jm.mapa_conceptual_id_mapa_conceptual=mc.id_mapa_conceptual AND ";
			$SqlDoc.= "jm.juego_id_juego IN(SELECT id_juego FROM juego WHERE nombre_juego='Sopa Letras') AND ";
			$SqlDoc.= "jm.estado_juego_mapa = '1';";
			
			$QueryDoc=mysql_query($SqlDoc);
			
			if(!$QueryDoc){
				$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
				return $Respuesta->getXML();
			}
			if(mysql_num_rows($QueryDoc)>0){
				while($VecD=mysql_fetch_array($QueryDoc)){
					$IdMapa=$VecD[0];
					$NomMapa=$VecD[1];
					$EstadoMapa=$VecD[2];
					$FechaLimite=$VecD[3];
					if($EstadoMapa=="1"){
						$Juego=mysql_fetch_array(mysql_query("SELECT id_juego FROM juego WHERE nombre_juego='Sopa Letras'"));
						$SqlResp = "SELECT duracion_real FROM historial_juego_respuesta WHERE ";
						$SqlResp.= "juego_mapa_mapa_conceptual_id_mapa_conceptual='".$IdMapa."' AND juego_mapa_juego_id_juego='".$Juego["id_juego"]."' AND ";
						$SqlResp.= "usuario_id_usuario='".$_SESSION["NumIdentidad"]."';";
						
						$QueryResp=mysql_query($SqlResp);
						
						if(!$QueryResp){
							$Respuesta->AddAlert("No se ha podido traer datos de la BD.");
							return $Respuesta->getXML();
						}
						if(mysql_num_rows($QueryResp)==0){
							$LinkIni="<a href='javascript:;' onClick='xajax_generarSopaLetras(".$IdMapa.");'>";
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
						/*if($FechaLimite>=date("Y-m-d H:i:s")){
							$LinkIni="";
							$LinkFin="";
							$EstadoMapa="Vencido";
						}
						else{*/
							$LinkIni="";
							$LinkFin="";
							$EstadoMapa="Deshabilitado";
						//}
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
					//tematica
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
	$Xajax->registerFunction('sopaLetrasMapas');

	/**
	* Esta funci�n se encarga de mostrar la sopa de letras
	* @param integer $IdMapa C�digo del mapa
	* @return xajaxResponse Objeto con la respuesta de la libreria XAjax
	*/
	function generarSopaLetras($IdMapa)
	{
		$Respuesta = new xajaxResponse('ISO-8859-1');
		$Conexion=abrirConexion();
		$VecPalabras=array("","");
		$VecPal=array("");
		$VecConceptos=array();
		if($Conexion!=false)
		{
			$Query = "SELECT nombre_concepto
					  FROM     concepto
					  WHERE mapa_conceptual_id_mapa_conceptual='".$IdMapa."'
					  AND nombre_concepto similar to '%[*AZ]%' 
					  ORDER BY RANDOM()";
			$ResSelect=mysql_query($Query);
			if(!$ResSelect){
				$Respuesta->addAlert("Ha ocurrido un error. ".pg_last_error());
			}
			else
			{
				$cont=1;
				while($VecResp=mysql_fetch_array($ResSelect))
				{
					$VecConceptos[]="'".$VecResp["nombre_concepto"]."'";
					//buscamos la palabra con el mayor numero de caracteres dentro del concepto
					$mayor=0;
					$PalabraSel="";
					$Palabra=trim($VecResp["nombre_concepto"]);
					$vpal=explode(" ",$Palabra);
					foreach($vpal as $vp){
						$num=strlen($vp);
						$ExpReg=preg_match('/^[A-Z]+$/',$vp);//busca solo si esta en mayusculas la palabra
						if($num>$mayor && $num<25 && $ExpReg==1){
							$mayor=$num;
							$PalabraSel=strtolower($vp);
						}
					}
					//--------------------------------------------------------------------------
					if($PalabraSel!=""){
						if($cont<=8){
							if($VecPalabras[1]==""){
								$VecPalabras[$cont] = $PalabraSel;
								$cont++;
							}
							else{
								$CadenaPalabras=implode("@",$VecPalabras);
								if(strpos($CadenaPalabras,$PalabraSel)===false){
									$VecPalabras[$cont] = $PalabraSel;
									$cont++;
								}
							}
						}
						else{
							break;
						}
					}
				}
				for($j=1;$j<=$cont-1;$j++){
					if($VecPalabras[$j]!="")
						$VecPal[$j]=$VecPalabras[$j];
				}
				$Js="vectorPalabrasGeneral=new Array();\r\n";
				for($i=1;$i<=count($VecPal);$i++){
					if(isset($VecPal[$i])==true)
						$Js.="vectorPalabrasGeneral[".$i."]='".$VecPal[$i]."';\r\n";
				}
				$Respuesta->addScript($Js);
				//query para traer dos palabras incorrectas
				if(count($VecConceptos)==0){
					$Respuesta->addAlert("La sopa de letras no pudo ser ejecutada debido a que no hay los suficientes conceptos.");
					return $Respuesta;
				}
				$CadenaPalCor=implode(",",$VecConceptos);
				$QueryInc = "SELECT nombre_concepto as nom
					  FROM     concepto
					  WHERE mapa_conceptual_id_mapa_conceptual <> '".$IdMapa."'
					  AND nombre_concepto NOT IN (".$CadenaPalCor.")
					  ORDER BY RANDOM() LIMIT 2";
				//$Respuesta->addAlert($QueryInc);
				//return $Respuesta;
				$ResSelectInc=mysql_query($QueryInc);
				if($ResSelectInc){
					if(mysql_num_rows($ResSelectInc)>0){
						$mayorinc=0;
						while($VecInc=mysql_fetch_array($ResSelectInc)){	
							$PalabraInc=trim(strtolower($VecInc["nom"]));
							$vpalinc=explode(" ",$PalabraInc);
							foreach($vpalinc as $vpi){
								$numinc=strlen($vpi);
								if($numinc>$mayorinc && $numinc<25){
									$mayorinc=$numinc;
									$VecPal[]=$vpi;
								}
							}
						}
					}
					else{
						$VecPal[]="concepto";
						$VecPal[]="relaci�n";
					}
				}
				//-----------------------------------------
				//$Respuesta->addAlert(print_r($VecPalabras,true));
				$Html = mostrarSopaLetras($VecPal,$IdMapa);
				//$Respuesta->addAlert($Html);
				$Respuesta->AddAssign("Contenido","innerHTML",$Html);
				$Js2="document.getElementById('totalPalabras').innerHTML=vectorPalabrasGeneral.length-1;";
				$Respuesta->addScript($Js2);
				//query para traer la duracion del juego
				$SqlTiempoLim = "SELECT duracion_juego as tiempo FROM juego_mapa WHERE ";
				$SqlTiempoLim .= "juego_id_juego IN(SELECT id_juego FROM juego WHERE nombre_juego='Sopa Letras' LIMIT 1) AND ";
				$SqlTiempoLim .= "mapa_conceptual_id_mapa_conceptual='".$IdMapa."' LIMIT 1;";
				$VecJuego=mysql_fetch_array(mysql_query($SqlTiempoLim));
				//inicio de cronometro
				$Hora=explode(":",date("H:i:s",mktime(0,0,$VecJuego["tiempo"])));
				$Respuesta->addScript("mapa='".$IdMapa."';");
				$Respuesta->addScriptCall("mostrarCrono","spanCronometro",$Hora[0],$Hora[1],$Hora[2],"obtenerResultadosSopa",$IdMapa);
				//ya inicio el juego
				$_SESSION["JuegoAbierto"]=1;
			}
		}
		return $Respuesta;
	}
	$Xajax->registerFunction("generarSopaLetras");
	
	/**
	* Esta funci�n se encarga de preparar la sopa de letras
	* @param string[] $valores Vector que contiene las palabras de la sopa de letras
	* @param integer $IdMap C�digo del mapa
	* @return string $Html Cadena que contiene todo el c�digo HTML de la sopa de letras
	*/
	function mostrarSopaLetras($valores,$IdMap)
	{
		  	ob_start();
			//aqui arranca la organizacion de la sopa de letras
				$abecedario = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","�","o","p","q","r","s","t","u","v","w","x","y","z","1","2","3","4","5","6","7","8","9","0","&aacute;","&eacute;","&iacute;","&oacute;","&uacute;");
				$Matriz = array();
				$hor=rand(0,25);
				$ver=rand(0,25);
				$cantValores = count($valores);
				$texto = str_split($valores[1]);
				$cantTexto = count($texto);
				$vVer = TRUE;
				$listo=true;
				$ocupado = false;
				$lleno = false;
				while($listo == true)
				{
					if( ( ($ver+$cantTexto) < 25) && ($hor < 25) )
					{
						foreach($texto as $valor)
						{
							$Matriz[$hor][$ver] = $valor;
							$ver++;
						}
						$listo = false;
					}
					else
					{
						$ver=rand(0,25);
					}
				}
				for( $pos = 2; $pos<=$cantValores; $pos++ )
				{
					if(isset($valores[$pos])==true){
						$hor=rand(0,25);
						$ver=rand(0,25);
						$texto = str_split($valores[$pos]);
						$cantTexto=count($texto);
						for( $i=$ver; $i<($ver+$cantTexto);$i++ )
						{
							if( ( ($ver+$cantTexto) < 25 ) && ( $hor < 25 ) )
							{
								//echo "Vertical: ".$i."<br>";
								//echo "Horizontal: ".$hor."<br>";
								//echo "ejecucion ciclo: <br>";
								$vVer = TRUE;
								$vHor = FALSE;
								if( !isset($Matriz[$hor][$i] ) )
								{
									$ocupado = false;
									//echo "Hor: ".$hor."- Ver: ".$i."<br>";
									//$i++;
								}
								else
								{
									//echo "Ocupados Verticales - Hor: ".$hor."- Ver: ".$i."<br>";
									$ver = rand(0,25);
									$hor = rand(0,25);
									//verificar posiciones horizontales
									for( $j=$hor; $j<($hor+$cantTexto);$j++ )
									{
										if( ( ($hor+$cantTexto) < 25 ) && ( $ver < 25 ) )
										{
											//echo "Entro horizontales";
											$vVer = FALSE;
											$vHor = TRUE;
											if( !isset($Matriz[$j][$ver] ) )
											{
												$ocupado=false;
												//echo "Hor: ".$j."- Ver: ".$ver."<br>";
												//$j++;
											}
											else
											{
												$hor = rand(0,25);
												$j=$hor;
											}
											//scar del ciclo de verticales
											$i=$ver+$cantTexto;
										}
										else
										{
											//echo "Ocupados Horizontales - Hor: ".$j."- Ver: ".$ver."<br>";
											$ocupado = true;
											$ver = rand(0,25);
											$hor = rand(0,25);
											$j=$hor;
										}
									}
									//$i=$ver;
								}
							}
							else
							{
								//echo "Es Mayor de 25<br>";
								$lleno = true;
								$ver = rand(0,25);
								$hor = rand(0,25);
								$i=$ver;
							}
						}
						foreach($texto as $valor)
						{
							if($vVer == TRUE)
							{
								$Matriz[$hor][$ver] = $valor;
								$ver++;
							}
							else
							{
								$Matriz[$hor][$ver] = $valor;
								$hor++;
							}
						}
					}
				}
				echo "<fieldset><legend>Jugando: Sopa de Letras</legend>";
				echo "<table>";
				echo "<tr><td width='60%'>";
				echo "<table border='1' style='border-collapse:collapse;'>";
				for( $i=0;$i<25;$i++ )
				{
					echo "<tr align='center'>";
					for( $j=0; $j<25; $j++ )
					{
						//echo "(".$valor."- h".$pos." -v".$posd.")"."";
						if( isset( $Matriz[$i][$j] ) )
						{
							if($Matriz[$i][$j]==" "){
								$Matriz[$i][$j]="&nbsp;";
							}
							echo "<td class='Celda' id='".$i."_".$j."' onClick=\"this.style.backgroundColor='#FFCC66'; cambiarIndicador(this.id); interpretarDireccionPalabra(this.id);\" onMouseOver='interpretarDireccionPalabra(this.id);'>".$Matriz[$i][$j]."</td>";
						}
						else
						{
							$indice=rand(0,count($abecedario)-1);
							$Matriz[$i][$j] = $abecedario[$indice];
							if($Matriz[$i][$j]==" "){
								$Matriz[$i][$j]="&nbsp;";
							}
							echo "<td class='Celda' id='".$i."_".$j."' onClick=\"this.style.backgroundColor='#FFCC66'; cambiarIndicador(this.id); interpretarDireccionPalabra(this.id);\" onMouseOver='interpretarDireccionPalabra(this.id);'>".$Matriz[$i][$j]."</td>";
						}
					}
					echo "</tr>";
				}
				echo "</table>";
				echo "</td>";
				echo "<td>&nbsp;</td>";
				echo "<td width='45%' valign='top'>";
				echo "<table width='100%'>";
				echo "<tr><td><a href='javascript:;' onClick=\"detenerCrono('obtenerResultadosSopa','".$IdMap."')\">Terminar Juego</a></td></tr>";
				echo "<tr><td>Palabras encontradas: <span id='puntuacion'>0</span></td></tr>";
				echo "<tr><td>Total de palabras: <span id='totalPalabras'></span></td></tr>";
				//span del cronometro
				echo "<tr><td>Tiempo Restante: <span id='spanCronometro'></span><br>";
				echo "<span id='letreroFin'></span></td></tr>";
				/*echo "<tr><td>";
				echo "<table>";
				echo "<tr>";
				echo "<td colspan='2'>Palabras a buscar:</td>";
				echo "</tr>";
				for($i=1;$i<=count($valores);$i++){
					if(isset($valores[$i])==true)
						echo "<tr><td><span id='span_".$i."'>&nbsp;</span></td><td>".$valores[$i]."</td>";
				}
				echo "</table>";
				echo "</td></tr>";*/
				echo "</table>";
				echo "</td>";
				echo "</tr>";
				echo "</table>";
				echo "</fieldset>";
			//------------------------------------------------
		$Html=ob_get_contents();
		ob_end_clean();
		return $Html;
	}
?>