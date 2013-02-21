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
    <script src="<?php echo PATCH?>/js/functionsJs.js"></script>
    </head>
    <body>
        <div class="container-header">
            <span>
                <?php echo $_SESSION["_User"]->nombreUsuario ." ". $_SESSION["_User"]->apellidoUsuario?>
                <text><?php echo $_SESSION["_User"]->nombrePerfil;?></text>
            </span>
            
        </div>
        <div class="container-login">
            <div class="container-menu">
                <?php
                echo '<ul>
                    <li>
                        <a>Administracion</a>
                            <ul>
                                    <li>
                                        <img src="../images/icons/group_add.png">
                                        <a method="POST" href="#" id="addGroup" action="'.PATCH.'/controller/aplicationController.php?option=0" onClick='."submitObjectData('addGroup','container-data',{'csc':1})".'>Crear Grupo</a>
                                    </li>
                                    <li>
                                        <img src="../images/icons/user_add.png">
                                        <a method="POST" href="#" id="addUser" action="'.PATCH.'/controller/aplicationController.php?option=1" onClick='."submitObjectData('addUser','container-data',{'csc':1})".'>Crear Usuario</a>
                                    </li>
                            </ul>
                    </li>
                </ul>';
                ?>
            </div>
            <div class="container-data" id="container-data">
                
            </div>
            <div style="clear: right" class="firma-container"><?php echo DEVELOPER;?></div>
        </div>
    </body>
</html>
