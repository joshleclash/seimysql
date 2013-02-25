<?php
include_once '../components/Components.php';
	//Atributos
	//$Conexion;
	$Servidor="";
	$Usuario="";
	$Clave="";
	
	/**  
	 * Esta funcion se encarga de abrir la conexi�n con la base de datos.
	 * @return connection Conexi�n con la base de datos. 
	 */
	function getComponents()
	{
		//lectura del archivo que contiene la info
		$components = new Components();
		return $components;
		
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
		$components=getComponents();
		$ConsultaUsuario = "SELECT * FROM usuario u join
                                    perfil p on u.idPerfil = p.idPerfil where  u.identificacion = ".$NumIdentidad.";";
                
		$rs = $components->__executeQuery($ConsultaUsuario, $components->getConnect());
		$CantidadRegistros = mysql_affected_rows($components->getConnect());
                print_r($CantidadRegistros);
		if($CantidadRegistros == 1)
		{
			$VectorResultado=  mysql_fetch_object($rs);
		}
		else
		{
			$VectorResultado=false;
		}
		cerrarConexion($components->getConnect());
		return $VectorResultado;
	}
?>