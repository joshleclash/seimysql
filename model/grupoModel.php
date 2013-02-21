<?php
include_once '../config/config.php';
class grupoModel{
    private $components=null;
    public function __construct() {
        $this->components =  new Components();
    }
    public function saveGrupo($formData){
        if($formData["fechaCorte1"]>=$formData["fechaCorte2"]){
            return array("codeError"=>0,"msg"=>'Error en las fechas de corte');  
        }
        if($formData["fechaCorte1"]>=$formData["fechaCorte3"]){
            return array("codeError"=>0,"msg"=>'Error en las fechas de corte');  
        }
        if($formData["fechaCorte2"]>=$formData["fechaCorte3"]){
            return array("codeError"=>0,"msg"=>'Error en las fechas de corte');  
        }
        $sql = "INSERT INTO grupo
                    (dscGrupo, fechaCorte1, fechaCorte2, fechaCorte3, fechaInicio, fechaFinal,smalldatetime,observaciones) 
                    VALUES ('".$formData["nombreGrupo"]."', '".$formData["fechaCorte1"]."', '".$formData["fechaCorte2"]."', 
                        '".$formData["fechaCorte3"]."', '".$formData["fechaInicio"]."', '$formData[fechaFinal]','".Components::getdate()."','".$formData["observaciones"]."')";
        $rs = $this->components->__executeQuery($sql, $this->components->getConnect());
        if($rs){
            return array("codeError"=>1,"msg"=>'Grupo creado correctamente');  
        }else{
            return array("codeError"=>0,"msg"=>'Error en la creacion de grupo valide su informacion');  
        }
    }
    public function updateGrupo($idGrupo=null){
        
    }
    public function deleteGrupo($idGrupo=null){
        
    }
    
}
?>
