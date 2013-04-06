<?php
session_start();
//echo $_SESSION["NumIdentidad"]." - ".$_SESSION["PerfilUsuario"];
if(!isset($_SESSION["NumIdentidad"]) || $_SESSION["NumIdentidad"]==""){
	header("Location: index.php");
}
require("lib/xajax/xajax.inc.php");
require("classes/BaseDatos.php");
$Xajax=new xajax();
$Xajax->setCharEncoding('ISO-8859-1');
$Xajax->decodeUTF8InputOn();
include("classes/Usuario.php");
include("classes/Docente.php");
include("classes/Estudiante.php");
include("classes/MapaConceptual.php");
include("classes/StandAlone.php");
include("classes/SopaLetras.php");
include("classes/Juego.php");
include("classes/Grafica.php");
include_once 'components/Components.php';

function inicio($Funcion){
	$Respuesta = new xajaxResponse('ISO-8859-1');
	if($_SESSION["JuegoAbierto"]==1){
		$Respuesta->addAlert("Por favor, termina el juego primero.");
	}
	else{
		if($Funcion==""){
			if(strtolower($_SESSION["PerfilUsuario"])=="estudiante"){
				$Respuesta->AddScriptCall("xajax_recordatorioEstudiante");
			}
			else{
				$Respuesta->AddScriptCall("xajax_recordatorioDocente");
			}
		}
		else{
			$Respuesta->addScript($Funcion);
		}
		$Respuesta->AddScriptCall("xajax_mostrarDestacados");
	}
	return $Respuesta->getXML();
}
$Xajax->registerFunction('inicio');

function refrescarEstadoMapa(){
	$Respuesta = new xajaxResponse('ISO-8859-1');
	$Conexion = abrirConexion();
	//$Respuesta->addAlert("ok");
	//obtengo todos los mapas conceptuales
	$QueryMapas=mysql_query("SELECT id_mapa_conceptual as id, fecha_limite as feclim FROM mapa_conceptual 
	WHERE fecha_limite <= '".date("Y-m-d H:i:s")."' ORDER BY id");
	if($QueryMapas){
		if(mysql_num_rows($QueryMapas)>0){
                                        
			while($VecMapas=mysql_fetch_array($QueryMapas)){
				$ActualizarMapa="UPDATE mapa_conceptual SET estado_mapa='2' 
				WHERE id_mapa_conceptual='".$VecMapas["id"]."';";
				mysql_query($ActualizarMapa);
			}
		}
	}
	cerrarConexion($Conexion);
	return $Respuesta->getXML();
}
$Xajax->registerFunction('refrescarEstadoMapa');

$Xajax->processRequests();

$VectorDatos=obtenerDatos($_SESSION["NumIdentidad"]);
if($VectorDatos==false){
	die("Hubo un error al obtener los datos del usuario");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SEI - Sesi�n iniciada</title>
<link rel="stylesheet" type="text/css" href="styles/EstiloPrincipal.css"></link>
<?php
$Xajax->printJavascript("lib/xajax/");
if($VectorDatos["perfil"]=="Docente"){
?>
<link rel="stylesheet" type="text/css" href="styles/EstiloMapa.css"></link>
<!--<script language="javascript" src="js/FuncionesSesionDocente.js"></script>-->
<script type="text/javascript" src="js/FuncionesEditorMapa.js"></script>
<script type="text/javascript" src="js/FuncionesGestorJuegos.js"></script>
<?php
}
?>
<link rel="stylesheet" type="text/css" href="styles/EstiloSopaLetras.css"></link>
<script type="text/javascript" src="js/FuncionesSesionDocente.js"></script>
<script type="text/javascript" src="js/FuncionesSopaLetras.js"></script>
<script type="text/javascript" src="js/FuncionesReloj.js"></script>
<script type="text/javascript" src="js/FuncionesRelojMapas.js"></script>
<script type="text/javascript" src="js/FuncionesMapasInicio.js"></script>
<script type="text/javascript" src="js/FuncionesJuegos.js"></script>
<script type="text/javascript" src="js/ScrollerDestacados.js"></script>
<script type="text/JavaScript">
document.oncontextmenu = function(){return false}
//-->
</script>
</head>
<body oncontextmenu="return false">
<table cellspacing="10" align="center" width="995">
<tr align="center">
<td class="banner" colspan="2"><h2>Sistema basado en conocimientos para Entrenamiento<br>Inteligente orientado a la Evaluaci&oacute;n</h2></td>
</tr>
<tr valign="top">
<td colspan="2">
	<fieldset class="informacionUsuario">
	<table class="informacionUsuario" width="100%">
	<tr>
	<td align="left">
	&nbsp;&nbsp;Bienvenido(a) <?php echo strtolower($_SESSION["PerfilUsuario"]).", ".ucwords(strtolower($VectorDatos["nombre"]." ".$VectorDatos["apellido"]));?>
	</td>
	<td align="right">
	<?php echo date("d M Y")?>&nbsp;&nbsp;
	</td>
	</table>
	</fieldset>
</td>
</tr>
<tr>
<td align="center" width="22%" valign="top">
	<fieldset class="menuIzquierdo"><legend align="center">Men&uacute; Principal</legend>
	<br>
	<table cellspacing="0" width="90%">
	<tr><td><a href='javascript:void(0)' onClick="xajax_inicio('');">Inicio</a></td></tr>
	<?php
	//mostramos el menu dependiendo del tipo de perfil que tenga el usuario
	switch($VectorDatos["perfil"]){
		case "Docente":
			echo "<tr><td><a href='javascript:void(0)' onClick=\"xajax_cargarGrupos('".$_SESSION["NumIdentidad"]."');\">Mis Grupos</a></td></tr>";
			echo "<tr><td><a href='javascript:void(0)' onClick=\"mostrarPerfil('".$VectorDatos["nombre"]."','".$VectorDatos["apellido"]."','".$VectorDatos["perfil"]."','".$VectorDatos["correo"]."');\">Mi Perfil</a></td></tr>";
			echo "<tr><td><a href='javascript:void(0)' onClick=\"xajax_cargarGestorJuegos();\">Gestor de Juegos</a></td></tr>";
			echo "<tr><td><a href='javascript:void(0)' onClick=\"xajax_cargarListadoMapa();\">Mis Mapas Conceptuales</a></td></tr>";
			echo "<tr><td><a href='javascript:void(0)' onClick=\"xajax_cargarListadoEstadisticas('".$_SESSION["NumIdentidad"]."');\">Estad&iacute;sticas</a></td></tr>";
		break;
		case "Estudiante":
			echo "<tr><td><a href='javascript:void(0)' onClick=\"xajax_inicio('mostrarPerfil(\'".$VectorDatos["nombre"]."\',\'".$VectorDatos["apellido"]."\',\'".$VectorDatos["perfil"]."\',\'".$VectorDatos["correo"]."\')');\">Mi Perfil</a></td></tr>";
			echo "<tr><td><a href='javascript:void(0)' onClick=\"xajax_inicio('xajax_sopaLetrasMapas();')\">Sopa de Letras</a></td></tr>";
			echo "<tr><td><a href='javascript:void(0)' onClick=\"xajax_inicio('xajax_standAloneMapas();')\">Standalone</a></td></tr>";
		break;
	}
	?>
	<tr><td><a href="javascript:void(0)" onClick="xajax_inicio('xajax_cerrarSesion()')">Cerrar Sesi&oacute;n</a></td></tr>
	</table>
	</fieldset><br>
	<fieldset class="menuIzquierdo"><legend align="center">Destacados</legend>
	<br>
	<table align="center" cellspacing="0" width="100%">
		<tr align="center" valign="top"><td>
			<div id="Destacados" onmouseover="scroll.stop();" onmouseout="scroll.start();">
				<table class="highlights" align='center' width='96%' style='font-size:11px;'>
					<tr align="left"><td>
					<span style="font-size:13px;" id="D_Mapa1"></span><br><br>
					<u id="D_Juego1_1"></u>: jugado <u id="D_Veces1_1"></u> veces.<br>
					<u id="D_Juego1_2"></u>: jugado <u id="D_Veces1_2"></u> veces.
					</td></tr>
				</table>
				<hr size=1>
				<table class="highlights" align='center' width='96%' style='font-size:11px;'>
					<tr align="left"><td>
					<span style="font-size:13px;" id="D_Mapa2"></span><br><br>
					<u id="D_Juego2_1"></u>: jugado <u id="D_Veces2_1"></u> veces.<br>
					<u id="D_Juego2_2"></u>: jugado <u id="D_Veces2_2"></u> veces.
					</td></tr>
				</table>
				<hr size=1>
				<table class="highlights" align='center' width='96%' style='font-size:11px;'>
					<tr align="left"><td>
					<span style="font-size:13px;" id="D_Mapa3"></span><br><br>
					<u id="D_Juego3_1"></u>: jugado <u id="D_Veces3_1"></u> veces.<br>
					<u id="D_Juego3_2"></u>: jugado <u id="D_Veces3_2"></u> veces.
					</td></tr>
				</table>
				<hr size=1>
			</div>
		</td></tr>
	</table>
	</fieldset>
</td>
<td valign="top">
<span id="Contenido">&nbsp;</span>
</td>
</tr>
</table>
<iframe name="Puente" id="Puente" class="iFrame"></iframe>
<script language="javascript">
	xajax_mostrarDestacados();
	var scroll = new NewsScroller('Destacados',40);
	iniciarCronometroTotal(0,0,0);
<?php
if(strtolower($_SESSION["PerfilUsuario"])=="estudiante"){
	echo "xajax_recordatorioEstudiante();\r\n";
}
else{
	echo "xajax_recordatorioDocente();\r\n";
}
?>
</script>
</body>
</html>