<?php
include_once '../config/config.php';
class userModel{
    private $components=null;
    private $conect=null;
    private $error=null;
    public function __construct() {
        $this->components = new Components();
        $this->conect=$this->components->getConnect();
    }
    public function createUser(){
        $string = '@#&0987654321ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $temp="";
        for($i=0;$i<=10;$i++):
            $temp .= substr($string,rand(0,62),1);
        endfor;
	$i=0;	
        foreach($_REQUEST as $key => $val):
                if($key!='option')
                {   
                 if(empty($val))
                    {
                        $i++;
                    }
                }
        endforeach;
        if($i!=0){
            return array("codeError"=>0,"msg"=>"Todos los campos deven estar diligenciados");
        }
            if(!is_numeric($_REQUEST["celular"]))
                            return array("codeError"=>0,"msg"=>'Error en el numero de celular');
        if($this->validateEmail($_REQUEST["mail"])==false)
		return array("codeError"=>0,"msg"=>'Error en le formato de email');
	    if(!is_numeric($_REQUEST["identificacion"]))
                return array("codeError"=>0,"msg"=>"Error en el formato de numero de documento");
        
        $sql = "INSERT INTO usuario
                (nombreUsuario, apellidoUsuario, celular, mail, clave, identificacion) 
                VALUES ('$_REQUEST[nombres]', '$_REQUEST[apellidos]', '$_REQUEST[celular]', '$_REQUEST[mail]', '".$temp."', $_REQUEST[identificacion]);";
                $rs = $this->components->__executeQuery($sql,$this->components->getConnect()); 
                if($rs)
                    {
                       return array("codeError"=>1,"msg"=>"Usuario creado correctamente");
                    }
    }
    public function loginUser($peticion=null){
        $i=0;    
    foreach($peticion as $key => $val):
                if($key!='option')
                {   
                 if(empty($val))
                    {
                        $i++;
                    }
                }
    endforeach;
    if($i!=0){
            return array("codeError"=>0,"msg"=>"Todos los campos deven estar diligenciados");
        }
    if(!is_numeric($peticion["identificacion"])) {
       return array("codeError"=>0,"msg"=>"El usuario no puede contener caracteres deve ser numerico"); 
    }   
    if(strlen($peticion["password"])<=6){
            return array("codeError"=>0,"msg"=>"La clave es demasiado corta");
        }
        $SQL="select * from usuario where identificacion=".$peticion["identificacion"];  
        $rs = $this->components->__executeQuery($SQL,$this->conect);
        $row = mysql_fetch_array($rs);
        if(mysql_affected_rows($this->conect)<=0)
            return array("codeError"=>0,"msg"=>"usuario no resgistrado en el sistema"); 
        else if(is_array($row)){
            if($row["clave"]==$_REQUEST["password"]){
                $objectUser= (object) array();
                foreach($row as $k => $v):
                    if(!is_numeric($k))
                            $objectUser->$k=$v;
                endforeach;
                $_SESSION["_User"]=$objectUser;
                return array("codeError"=>1,"msg"=>'Inicio de session exitoso');  
            }else{
                return array("codeError"=>0,"msg"=>"Error de clave! Valide su informacion");  
            }
        }
    }
        
    private function  validateEmail($direccion=null)
        {
           $Sintaxis='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
           if(preg_match($Sintaxis,$direccion))
		   {
              return true;
           }
		   else 
		   {
			  return false;
		   }
        }
}
?>
