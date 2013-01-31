<?php
include_once '../config/config.php';
class userModel{
    private $components=null;
    private $conect=null;
    public function __construct() {
        $this->components = new Components();
        $this->conect=$this->components->getConnect();
    }
    public function createUserModel(){
        parent::__construct();
    }
}
?>
