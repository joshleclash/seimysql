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
        $sql = "INSERT INTO usuario
                (nombreUsuario, apellidoUsuario, celular, mail, clave, identificacion) 
                VALUES ('$_REQUEST[nombres]', '$_REQUEST[apellidos]', '$_REQUEST[celular]', '$_REQUEST[mail]', '".$temp."', $_REQUEST[identificacion]);";
                $rs = $this->components->__executeQuery($sql,$this->components->getConnect()); 
                if(!$rs){
                    return $this->error=  mysql_errno($this->components->getConnect());
                }else{
                    if($this->components->sendRsForMail(null, array('joshleclash@gmail,com'), "test", "Mensaje creado")):
                        return "usuario creado con correctamente";
                        else:
                        return "Exisito algun error al enviar el mail";
                    endif;
                    
                }
    }
}
?>
