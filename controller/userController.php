<?php
include_once '../model/userModel.php';
class userController{
    
    public function createUserController($peticion){
        $userModel = new userModel();
        $userModel->createUser($peticion);
    }
}
if(isset($_REQUEST['option'])){
    $userController = new userController();
    if($_REQUEST["option"]==0)
      {
        echo $userController->createUserController($_POST);
      }  
    

    

}
?>
