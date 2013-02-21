<?php include_once '../config/config.php';?>

<div class="create-form-container">
    <form  action="<?php echo PATCH?>/controller/userController.php?option=0" id="formUsuario" method="POST">
            <div class="title-form">Creacion Usuario</div>
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
                        <td>
                            <input type="button" value="Registrar" onclick="submitObjectData('formUsuario','idResponse',$('#formLogin').serializeArray());"/>  
                        </td>
                        <td>
                            <?php if(!empty($_SESSION["_User"]->idUsuario))
                            {
                                
                            }else{
                                echo '<input type="button" value="Volver" onClick='."window.location='index.php'".'/>';  
                            }
                                ?>
                            
                        </td>
                    </tr>
                </table>
                <div id="idResponse"></div>
    </form>    
    </div>
<script>
$('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' })
</script>
