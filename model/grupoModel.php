<?php
include_once '../config/config.php';
class grupoModel{
    private $components=null;
    public function __construct() {
        $this->components =  new Components();
    }
    public function saveGrupo(){
        var_dump($_REQUEST);
        exit;
        $sql = "INSERT INTO uccmysql.grupo
                    (dscGrupo, fechaCorte1, fechaCorte2, fechaCorte3, fechaInicio, fechaFinal,smalldatetime) 
                    VALUES ('dscGrupo', 'fechaCorte1', 'fechaCorte2', 'fechaCorte3', 'fechaInicio', 'fechaFinal','')";
        return array("codeError"=>1,"msg"=>'Grupo creado correctamente');  
    }
    public function updateGrupo($idGrupo=null){
        
    }
    public function deleteGrupo($idGrupo=null){
        
    }
    
}
?>
