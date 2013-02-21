<?php 
include_once '../controller/userController.php';
?>
<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="<?php echo PATCH?>/css/side.css"> 
    <link href="<?php echo PATCH?>/css/custom-theme/jquery-ui-1.10.0.custom.css" rel="stylesheet">
    <script src="<?php echo PATCH?>/js/jquery-1.9.0.js"></script>
    <script src="<?php echo PATCH?>/js/jquery-ui-1.10.0.custom.js"></script>
    <script src="<?php echo PATCH?>/js/functionsJs.js"></script>
    
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
            <form class="login" action="<?php echo PATCH?>/Controller/UserController.php?option=0" id="formLogin" method="POST">
                <span>Iniciar Sesion</span>
                <table style="padding: 10px; margin-left: 30px; width: 85%">
                    <tr>
                        <td>Nombres</td>
                        <td ><input type="text" name="nombres"/></td>
                    </tr>
                        
                    <tr>
                        <td>Apellidos</td>
                        <td ><input type="text" name="apellidos"/></td>
                    </tr>
                    
                    <tr>
                        <td>Celular</td>
                        <td ><input type="text" name="celular"/></td>
                    </tr>
                     
                    <tr>
                        <td>Mail</td>
                        <td ><input type="text" name="mail"/></td>
                    </tr>
                     
                    <tr>
                        <td>Identificacion</td>
                        <td colspan="2"><input type="text" name="identificacion"/></td>
                    </tr>
                     <tr>
                        
                    </tr>
                    <tr>
                        <td>
                            <input type="button" value="Registrar" onclick="submitObjectData('formLogin','idResponse',$('#formLogin').serializeArray());"/>  
                        </td>
                        <td><input type="button" value="Volver" onClick='window.location="index.php"'/>  </td>
                    </tr>
                </table>
                <div id="idResponse"></div>
                
                
                
                
            </form> 
        </div>
    </body>
</html>

