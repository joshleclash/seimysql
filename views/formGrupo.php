<?php include_once '../config/config.php';?>

<div class="create-form-container">
    
    <form action="<?php echo PATCH?>/controller/grupoController.php?option=0" method="POST" id="formGrupo">
        <div class="title-form">Creacion Grupo</div>
        <table>
            <tr>
                <td>Nombre de Grupo</td>
                <td></td>
                <td>Fecha Inicio</td>
            </tr>
            <tr>
                <td><input type="text" name="nombreGrupo"></td>
                <td></td>
                <td><input type="text" class="datepicker" name="fechaInicio"></td>
            </tr>
            <tr>
                <td colspan="3" style="font-family: 'cool_fonts'; font-size: 14px;">Fechas Cortes</td>
            </tr>
            <tr>
                <td>Fecha Corte 1</td>
                <td>Fecha Corte 2</td>
                <td>Fecha Corte 3</td>
            </tr>
            <tr>
                <td><input type="text" style="width: 120px;" class="datepicker" name="fechaCorte1"></td>
                <td><input type="text" style="width: 120px;" class="datepicker" name="fechaCorte2"></td>
                <td><input type="text" style="width: 120px;" class="datepicker" name="fechaCorte3"></td>
            </tr>
            <tr>
                <td colspan="2">Fecha Final</td>
                <td></td>
            </tr>
            <tr>
                <td><input type="text" class="datepicker" name="fechaFinal"></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="3" style="font-family: 'cool_fonts'; font-size: 14px;">Observaciones</td>
                
            </tr>
            <tr>
                <td colspan="3">
                    <textarea name="observaciones"></textarea>
                </td>
                
            </tr>
            <tr>
                <td>
                    <input type="button" value="Guardar" onclick="submitObjectData('formGrupo', 'idResponse', $('#formGrupo').serializeArray());">
                </td>
                <td><input type="reset" value="Reset"></td>
                
            </tr>
            <tr>
                <td colspan="3" id="idResponse">
                    
                </td>
            </tr>
        </table>    
    </form>
    
</div>
<script>
$('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' })
</script>
