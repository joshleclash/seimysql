<?php
include_once '../model/userModel.php';
class userController{
    private $userModel = null;
    public function __construct(){
       $this->userModel = new userModel(); 
    }
    public function createUserController($peticion){
        return $this->userModel->saveUser($peticion);
    }
    public function loginUserController($peticion){
        return $this->userModel->loginUser($peticion);
    }
    public function adminUser(){
        $components = new Components();
        $sql = "select * from grupo where estado='activo'";
        $rs = $components->__executeQuery($sql, $components->getConnect());
        $grid = '<table>';
        $grid .= '<tr>';
        $grid .= '<th>Nombre Grupo</th>';
        $grid .= '<th>Fecha-Inicio</th>';
        $grid .= '<th>Fecha-Final</th>';
        $grid .= '<th>Corte1</th>';
        $grid .= '<th>Corte2</th>';
        $grid .= '<th>Corte3</th>';
        $grid .= '<th>Observaciones</th>';
        $grid .= '<th>Estado</th>';
        $grid .= '<tr>';
        while($row=  mysql_fetch_object($rs)):
            $grid.='<tr><td></td></tr>';
        endwhile;
        $grid .= '</table>';
        return $grid;
        
        
    }
}
if(isset($_REQUEST['option'])){
    $userController = new userController();
    switch($_REQUEST["option"]){
        case 0:
         $response = $userController->createUserController($_POST);
         if($response["codeError"]==0){
             echo '<div class="error-response">'.$response["msg"].'</div>';
         }else{
             echo '<div class="ok-response" align="center">
                        <img src="'.PATCH.'/images/icons/accept.png" style="margin-top: -10px;" align="middle">'.
                            $response["msg"]
                     .'</div>';
         }   
        break;
        case 1:
            $response = $userController->loginUserController($_REQUEST);
         if($response["codeError"]==0){
             echo '<div class="error-response">'.$response["msg"].'</div>';
         }else{
             echo '<div class="ok-response" align="center">
                 <img src="'.PATCH.'/images/icons/accept.png" style="margin-top: -10px;" align="middle">'.
                     $response["msg"]
                     .'<script>setTimeout(function(){window.location="welcome.php";},2000)</script>'.
                  '</div>';
             
         }
        break;
        
        
        
    }
}
?>
