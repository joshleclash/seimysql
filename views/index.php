<?php 
include_once '../config/config.php';
?>
<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="<?php echo PATCH;?>/css/side.css"> 
    <link href="<?php echo PATCH;?>/css/custom-theme/jquery-ui-1.10.0.custom.css" rel="stylesheet">
    <script src="<?php echo PATCH;?>/js/jquery-1.9.0.js"></script>
    <script src="<?php echo PATCH;?>/js/jquery-ui-1.10.0.custom.js"></script>
    </head>
    <body>
        <div class="container-login">
            <div class="title">Sistema basado en conocimientos para Entrenamiento Inteligente orientado a la Evaluación</div>
            <span>
                Sistema de informacion en el cual podra documentar avances en los diferentes actividades dejadas por el docento
                <br/>
                <br/>
                <br/><br/>
                <br/><br/>
                <br/>
                <br/>
                <br/><br/><br/><br/><br/><br/>
            </span>
            <form class="login" >
                <span>Iniciar Sesion</span>
                <table style="padding: 10px; margin-left: 30px; width: 85%">
                    <tr>
                        <td>Identificacion</td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="text"/></td>
                    </tr>    
                    <tr>
                        <td>Clave</td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="text"/></td>
                    </tr>
                    <tr>
                        <td>
                            <input type="button" value="Iniciar sesion"/>  
                        </td>
                        <td><input type="button" value="Registar Usuario" onClick='window.location="registroUsuario.php"'/>  </td>
                    </tr>
                </table>
                <br/>
                <div class="footer-login">
                        <a href="">Olvido su contrase&ntilde;a</a>
                </div>
                
                
                
                
            </form> 
        </div>
    </body>
</html>
