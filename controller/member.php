<?php

class member{
    
    function __construct(){
        //验证用户
//         $this->data = $_POST;
    }
    
    //登陆
    public function login($data){
        print_r($data);
    }
    
    //注册
    public function signup(){
        //TODO
    }
    
}


$main = new member();
$sendData = $_REQUEST;
$data = $_POST;
$type=$sendData['type'];
switch ($type){
    case 'login':
        $main->login($data);
    case 'signup':
        $main->signup($data);
    default: return;
}


?>