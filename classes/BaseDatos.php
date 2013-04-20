<?php
	//Atributos
	//$Conexion;
	
	/**  
	 * Esta funcion se encarga de abrir la conexi�n con la base de datos.
	 * @return connection Conexi�n con la base de datos. 
	 */
	function abrirConexion()
	{
		//lectura del archivo que contiene la info
            $Servidor="localhost";
            $Usuario="root";
            $Clave="";
            $Db="seimysql";
		$NombreArchivo="conf/hdb.oej";	
		$archivo = file($NombreArchivo); //creamos el array con las lineas del archivo
		$lineas = count($archivo); //contamos los elementos del array, es decir el total de lineas
		//conexion a la base de datos
		$Conexion = mysql_connect($Servidor,$Usuario,$Clave)or die("Error en la conexion con el servidor");
                        mysql_selectdb($Db, $Conexion);
		if(!$Conexion)
		{
			return false;
		}
		else
		{
			return $Conexion;
		}
	}
	/**
	 * Esta funcion se encarga de cerrar la conexi�n con la base de datos.
	 * @paran connection $Conexion Conexion establecida con la base de datos 
	 */
	function cerrarConexion($Conexion)
	{
            mysql_close($Conexion);
	}
	
	/**
	 * Este metodo se encarga de traer los datos del usuario de la base de datos.
	 * @param integer N�mero de identificaci�n del usuario
	 * @return string[] Vector con la informaci�n del usuario.
	 */
	function obtenerDatos($NumIdentidad){
		$Conexion=abrirConexion();
		$ConsultaUsuario = "SELECT u.id_usuario as usuario, p.nombre_perfil as perfil, u.nombre_usuario as nombre, u.apellido_usuario as apellido, u.correo_usuario as correo 
							FROM usuario u, perfil p 
							WHERE u.perfil_id_perfil=p.id_perfil 
							AND u.id_usuario = ".$NumIdentidad.";";
		$ResultadoQuery = mysql_query($ConsultaUsuario);
		$CantidadRegistros = mysql_num_rows($ResultadoQuery);
		if($CantidadRegistros == 1)
		{
			$VectorResultado=mysql_fetch_array($ResultadoQuery);
		}
		else
		{
			$VectorResultado=false;
		}
		cerrarConexion($Conexion);
		return $VectorResultado;
	}
?>