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
    public function saveGrupoController($dataForm){
        $response = $this->model->saveGrupo($dataForm);
        if($response["codeError"]==0){
            $msg ='<div class="error-response">'.$response["msg"].'</div>';
            
        }else{
            $msg = '<div class="ok-response">'.$response["msg"].'</div>';
        }
        return $msg; 
    }
}
if(isset($_REQUEST["option"])){
    $controller = new grupoController();
    switch($_REQUEST["option"]){
        case 0:
            echo $controller->saveGrupoController($_POST);
            break;
    }
}
?>
