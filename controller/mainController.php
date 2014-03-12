<?php
require_once "db.php";
class main{
    //接收消息
	public function getMyMsg($sendData){
		$db = new db();
		$params = array(
		        'send_to'=>'3',
		        'send_from'=>'1',
		        'status'=>'1',
		        );
		$data = $db->getList('message_main','content,time',$params,'','','');
		$this->_end('succ',$data);
	}
	
	//发送消息
	public function sendMsg($sendData){
	    $db = new db();
	    $params = array(
	            'send_to'=>'3',
	            'send_from'=>'1',
	            'content'=>$sendData['content'],
	            'time'=>time(),
	            );
	    $result = $db->save('message_main',$params);
// 	    $result = false;
	    if ($result){
	        $this->_end('succ');
	    }else {
	        $this->_end('faile');
	    }
	}
	
	//返回数据统一格式
	private function _end($status='succ',$msg=array()){
	    $arr = array(
	            'status'=>$status,
	            'data'=>$msg,
	            );
	    echo json_encode($arr);
	}
}

$main = new main();
$sendData = $_REQUEST;
$type=$sendData['type'];
switch ($type){
    case 'send':
        $main->sendMsg($sendData);
    case 'get':
        $main->getMyMsg($sendData);
    default: return;
}


?>