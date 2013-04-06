<?php
session_start();
//variables del formulario
$TipoMapa=$_POST["IdTipoMapa"];
$Tematica=$_POST["TematicaMapa"];
//cuadramos la duracion en horas
$TipoDuracion=$_POST["TipoIntervaloTiempo"];
$ValorDuracion=$_POST["ValorDuracion"];
switch($TipoDuracion){
	case "Dias":
		$ValorDuracion*=24;
	break;
	case "Meses":
		$ValorDuracion*=24*30;
	break;
}
//----------------------------------------
//$EstadoMapa=$_POST["IdEstadoMapa"];
//archivo subido
$TipoArch=$_FILES["ArchivoMapa"]["type"];
$TmpArch=$_FILES["ArchivoMapa"]["tmp_name"];
$NomArch=$_FILES["ArchivoMapa"]["name"];
$TamArch=$_FILES["ArchivoMapa"]["size"];
$ErrArch=$_FILES["ArchivoMapa"]["error"];
//Verificar cuantos archivos del mismo nombre hay
$NumArchivos=count(glob("data/".$_SESSION["NumIdentidad"]."_".$NomArch));
//die("".$NumArchivos);
//echo $TipoArch." - ".$TmpArch." - ".$NomArch." - ".$TamArch." - ".$ErrArch;
$Destino="data/".$_SESSION["NumIdentidad"]."_".$NomArch;
?>
<html>
<head>
<script language="javascript">
<!--
<?php
if($NumArchivos>=1){
	echo "alert('El nombre de archivo ya existe en la base de datos. Cambie el nombre del archivo é intentelo de nuevo');\r\n";
}
elseif($ErrArch==1){
	echo "alert('Hubo un error al subir el archivo. Intente de nuevo más tarde');\r\n";
}
elseif($TamArch>2097152){
	echo "alert('No se puedo subir el archivo. El archivo excede los limites de tamaño establecidos.');\r\n";	
}
elseif($TipoArch!="text/plain"){
	echo "alert('No se pudo subir el archivo. El tipo de archivo no es el correcto.');\r\n";
}
elseif(!move_uploaded_file($TmpArch,$Destino)){
	echo "alert('No se pudo subir el archivo. Intente de nuevo mas tarde');\r\n";
}
else{
	//echo "alert('El archivo ha sido subido con éxito.');\r\n";
	echo "parent.xajax_interpretarMapaConceptual('".$Destino."','".$TipoMapa."','".$ValorDuracion."','".$Tematica."');\r\n";
}
?>
-->
</script>
</head>
</html>