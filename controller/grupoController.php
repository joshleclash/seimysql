<?php
include_once '../config/config.php';
include_once '../model/grupoModel.php';
class grupoController{
    private $components = null;
    private $model=null; 
    public function __construct() {
        $this->components = new Components();
        $this->model = new grupoModel();
    }
    public function saveGrupoController(){
        return $this->model->saveGrupo();
    }
}
if(isset($_REQUEST["option"])){
    $controller = new grupoController();
    switch($_REQUEST["option"]){
        case 0:
            $controller->saveGrupoController();
            break;
    }
}
?>
