<?php
	$Arch = "conf/hdb.oej";
	$Arch1 = "installer.php";
	$Arch2 = "crear.php";
	$Arch3 = "SEI.sql";
	if(file_exists($Arch)==false)
	{
		if(file_exists($Arch1)==true && file_exists($Arch2)==true && file_exists($Arch3)==true)
		{
			header('Location:installer.php');
		}
		else{
			echo '	<html>
					<head>
					<title>SEI - Bienvenidos</title>
					<link rel="stylesheet" type="text/css" href="styles/EstiloIndex.css"></link>
					</head>
					<body>
						<table align="center">
							<tr align="center">
								<th style="height:100px;"></th>
							</tr>
							<tr align="center">
								<th><h2>SEI</h2><br>Sistema basado en conocimientos para Entrenamiento Inteligente orientado a la Evaluaci&oacute;n<br><br></th>
							</tr>
							<tr align="center">
								<td>Lo sentimos, se han encontrado errores en los archivos del sistema, por favor cont&aacute;ctese con su proveedor de software.</td>
							</tr>
						</table>
					</body>
					</html>';
		}
	}
	else
	{
		if(file_exists($Arch1)==true)
		{
			unlink($Arch1);
		}
		if(file_exists($Arch2)==true)
		{
			unlink($Arch2);
		}
		if(file_exists($Arch3)==true)
		{
			unlink($Arch3);
		}
		require("lib/xajax/xajax.inc.php");
		require("classes/BaseDatos.php");
		$Xajax=new xajax();
		$Xajax->setCharEncoding('ISO-8859-1');
		$Xajax->decodeUTF8InputOn();
		include("classes/Usuario.php");

		$Xajax->processRequests();
?>
<html>
<head>
<title>SEI - Bienvenidos</title>
<link rel="stylesheet" type="text/css" href="styles/EstiloIndex.css"></link>
<script language="javascript" src="js/ValidacionUsuario.js"></script>
<script type='text/javascript' src='js/Registro.js'>
<!---->
</script>
<?php
$Xajax->printJavascript("lib/xajax/");
?>
</head>
<body>
<form name="FormaIngreso" id="FormaIngreso" method="post">
	<table align="center">
		<tr align="center">
			<th colspan="2" style="height:100px;"></th>
		</tr>
		<tr align="center">
			<th colspan="2"><h2>SEI</h2><br>Sistema basado en conocimientos para Entrenamiento Inteligente orientado a la Evaluaci&oacute;n</th>
		</tr>
		<tr>
			<td height="20" colspan="2"></td>
		</tr>
		<tr>
			<td align="right">Documento Identidad</td>
			<td><input type="text" name="IdUsuario" id="IdUsuario" maxlength="12" onKeyPress="return numeros(event);"></td>
		</tr>
		<tr>
			<td align="right">Clave Acceso</td>
			<td><input type="password" name="Clave" id="Clave" onKeyPress="verificaTecla(event,this.form)"></td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<button type="button" id="BotonIngresar" onClick="validarFormaIngreso(this.form)">Ingresar</button>
			</td>
		</tr>
		<tr>
			<td height="20" colspan="2"></td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				¿Es un usuario nuevo? Para registrarse, haga click <a href="registro.php" target="_self">aqui</a>.
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				¿Olvid&oacute; su contrase&ntilde;a? Haga click <a href="javascript:;" onClick="xajax_olvidoContrasena(document.getElementById('IdUsuario').value);">aqui</a>.
			</td>
		</tr>
	</table>
</form>
</body>
</html>
<?php
	}
?>