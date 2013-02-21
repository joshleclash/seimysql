<?php
include_once 'Components.php';
class MsgMail extends Components{
    private $mail =null;
    private $footer=null;
    public function __construct() {
        
        $this->footer='<div style="width:90%; "><strong>favor no responder este mensaje mensaje generado automaticamente '.Components::getDate().'</strong></div>';
    }
    public function getMsgMailNewUser($dataUser=null){
            return $this->mail='<div style="border-radius:20px;background-color:#cecece; font-family:arial; width:700px; height:300px; margin-left:auto; margin-right:auto;">
                                    <div style="border-top-left-radius:20px; border-top-right-radius:20px; background-color:#222222; color:#fff; font-size:18px; padding:10px;">Bienvenido</div>
                                    <div style="border-radius:10px; width:90%; padding:15px; font-size:12px;">
                                    Se&ntilde;or(a)'.$dataUser["nombreUsuario"].'<br/><br/>
                                    Bienvenido al sisteam de informacion de la Universidad cooperativa de Colombia por favor para ingresar al sitio de click en
                                    el siguiente enlace <br/><br/>
                                    <strong>Usuario:</strong>'.$dataUser["identificacion"].'<br/>    
                                    <strong>Clave:</strong>'.$dataUser["clave"].'<br/>    
                                    <br/><br/><br/>
                                    
                                    '.$this->footer.'    
                                    </div>
                                    
                                <div>';
    }
}
?>
