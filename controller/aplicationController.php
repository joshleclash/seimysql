<?php
include_once '../config/config.php';
class aplicationController extends userController{
    private $components=null;
    private $controller=null;
    public function __construct() {
        $this->components= new Components();
        $this->controller = $this->components->getFilesofFolder("../controller");
    }
    public function viewFormCreateGroup(){
        include_once '../views/formGrupo.php';
    }
    public function viewFormRegisterUser(){
        include_once '../views/formUsuario.php';
    }
    public function viewFormAdminUser(){
        include_once '../views/formAdminUser.php';
        
    }
}
if(isset($_REQUEST["option"])){
    $controller = new aplicationController();
    switch($_REQUEST["option"]){
        case 0:
              echo $controller->viewFormCreateGroup();
            break;
        case 1:
             echo $controller->viewFormRegisterUser();
            break;
        case 2:
             echo $controller->viewFormAdminUser();
            break;
            
    
    }
}

?>
