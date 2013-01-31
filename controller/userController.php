<?php
include_once '../model/userModel.php';
class userController{
    
    public function createUserController($peticion){
        $userModel = new userModel();
        $userModel->createUserModel($peticion);
    }
}
$userController = new userController();
$userController->createUserController($_POST);
?>
