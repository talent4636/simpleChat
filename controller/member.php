<?php
require_once "db.php";

class member{
    
    public function __construct(){
        @session_start();
    }
    
    //登陆
    public function login($data){
        $db = new db();
        if (!is_array($data)){
            $this->_end('failure','用户名或密码错误');
            exit;
        }
        if (!$this->_checkVerifyCode($data['verify_code'])){
            $this->_end('failure','验证码错误');
            exit;
        }
        $mem = $db->getList('member', 'id,password,name', array('login_name'=>$data['login_name']),'','','');
        if (!$mem){
            $this->_end('failure','用户名或密码错误');
            exit;
        }
        if ($mem[0]){
            if ($mem[0]['password'] == $this->_pwdMd5($data['password'])){
                //写入session 和 cookie  TODO
                $_SESSION['chatmember'] = array(
                        'id'=>$mem[0]['id'],
                        'login_name'=>$data['login_name'],
                        'name'=>$mem[0]['name'],
                        );
                setcookie('chatname',$mem[0]['name'],time()+3600,'/');
                // $this->_end('succ','登陆成功');
                $url = "'../index.html'";
                $this->_jumpTo($url);
                exit;
            }
        }
        $this->_end('failure','用户名或密码错误');
        exit;
    }

    //注册
    public function signup($data){
        //判断格式 1.验证码，2.格式
        if ($data['password'] != $data['password_confirm']){
            $this->_end('failure','两次密码必须一致');
        }
        if (!$data['verify_code'] || !$data['login_name'] || !$data['name'] || !$data['email'] || !$data['mobile'] || !$data['sex'] || !$data['password'] ){
            $this->_end('failure','信息未填写完整');
        }
        if (!$this->_checkVerifyCode($data['verify_code'])){
            $this->_end('failure','验证码填写错误');
        }
        $db = new db();
        $params = array(
                'login_name' => $data['login_name'],
                'name' => $data['name'],
                'create_time' => time(),
                'email' => $data['email'],
                'mobile' => $data['mobile'],
                'sex' => $data['sex'],
                'password' => $this->_pwdMd5($data['password']),
                );
        $res = $db->save('member', $params);
        if ($res) {
            $this->_end('succ','注册成功');
        }else {
            $this->_end('failure','抱歉，注册失败');
        }
    }
    
    //获取当前登录的用户信息，返回array
    public function getCurrentMember(){
        return $_SESSION['chatmember'];
    }
    
    //根据用户id获取用户名
    public function getNameByMemId($memId){
        $db = new db();
        $res = $db->getRow('member', 'name', array(
                'id'=>$memId,
                ));
        return $res[0];
    }

    //TODO
    public function getMemberList(){
        $db = new db();
        $res = $db->getList('member','name,id','','','','');
        $this->_end('succ',$res);
    }

    public function logOut(){
        // $_SESSION['chatmember'] = '';
        // setcookie('chatname','');
        // echo "succ";
    }

    private function _jumpTo($url){

        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href=".$url.";";
        echo "</script>";
    }
    
    //验证码验证
    private function _checkVerifyCode($code){
        $serverCode = $_SESSION['verifyCode'];
        if ($serverCode == $code){
            return true;
        }else {
            return false;
        }
    }
    
    private function _end($status='succ',$msg=array()){
        $arr = array(
                'status'=>$status,
                'data'=>$msg,
        );
        echo json_encode($arr);
    }
    
    private function _pwdMd5($str){
        $pwd = md5(md5($str));
        return $pwd;
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
    case 'getMemberList':
        $main->getMemberList();
    case 'logOut':
        $main->logOut();
    default: return;
}


?>