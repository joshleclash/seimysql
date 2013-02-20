<?php
include_once '../config/config.php';
class aplicationController{
    private $components=null;
    public function __construct() {
        $this->components= new Components();
    }
    public function viewFormCreateGroup(){
        include_once '../views/formGrupo.php';
    }
    
    
}
if(isset($_REQUEST["option"])){
    $controller = new aplicationController();
    switch($_REQUEST["option"]){
        case 0:
              echo $controller->viewFormCreateGroup();
        break;
        
    
    }
}

?>
