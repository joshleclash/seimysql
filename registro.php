<?php
	require('lib/xajax/xajax.inc.php');
	require('classes/BaseDatos.php');
	$Xajax=new xajax();
	$Xajax->setCharEncoding('ISO-8859-1');
	$Xajax->decodeUTF8InputOn();
	include('classes/Docente.php');
	
	$Xajax->processRequests();
	
?>
<html>
	<head>
		<title>SEI - Registro de Docentes</title>
		<link rel="stylesheet" type="text/css" href="styles/EstiloIndex.css"></link>
		<script type='text/javascript' src='js/Registro.js'>
		<!---->
		</script>
	</head>
	<?php
		$Xajax->printJavascript("lib/xajax/");
	?>
	<body>
		<table align='center' style='width:1000px;' border='0'>
			<tr>
				<td style="height:100px;">
				</td>
			</tr>
			<tr align="center">
				<th><h2>SEI</h2><br>Sistema basado en conocimiento para Entrenamiento Inteligente orientado a la Evaluaci&oacute;n</th>
			</tr>
			<tr>
				<th>Formulario de Registro de Docentes
				</th>
			</tr>
			<tr align='center'>
				<td>Por favor ingrese los datos solicitados a continuaci&oacute;n para completar el registro:
				</td>
			</tr>
			<tr>
				<td>
					<form name='FormaRegistro' method='POST'>
					<table align='center' width='60%' border='0'>
						<tr align='center'>
							<td>Documento de Identidad:&nbsp;&nbsp;
							<input type='text' name='IdUsuario' id='IdUsuario' size='29' onkeypress='return numeros(event);'>
							</td>
						</tr>
						<tr align='center'>
							<td>Nombres:&nbsp;
							<input type='text' name='NombreUsuario' id='NombreUsuario' size='45' onkeypress='return noNumeros(event);'>
							</td>
						</tr>
						<tr align='center'>
							<td>Apellidos:&nbsp;
							<input type='text' name='ApellidoUsuario' id='ApellidoUsuario' size='45' onkeypress='return noNumeros(event);'>
							</td>
						</tr>
						<tr align='center'>
							<td>Correo:&nbsp;&nbsp;&nbsp;&nbsp;
							<input type='text' name='CorreoUsuario' id='CorreoUsuario' size='45' onkeypress='return correoPermitido(event);'>
							</td>
						</tr>
						<tr align='center'>
							<td><input type='button' onClick='validarRegistro(this.form);' value='Registrar'>&nbsp;&nbsp;&nbsp;&nbsp;
							<input type='reset' value='Limpiar Campos'>
							</td>
						</tr>
					</table>
					</form>
				</td>
			</tr>
		</table>
	</body>
</html>