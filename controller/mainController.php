<?php
require_once "db.php";
require_once "member.php";
class main{
    //接收消息
	public function getMyMsg($sendData){
		$db = new db();
		$memObj = new member();
		$mem = $memObj->getCurrentMember();
		if (!@$sendData['from'] || !$mem) {
			@$this->_end('faile', '');
			exit;
		}
		$params = array(
		        'send_to'=>$mem['id'],
		        'send_from'=>$sendData['from'],
		        'status'=>'1',
		        );
		$res = $db->getList('message_main','content,time',$params,'','','');
		if ($res) {
			$data = array();
			foreach ($res as $key => $value) {
				$data[$key]['content'] = $value['content'];
				$data[$key]['time'] = date("Y-m-d H:i:s",$value['time']);
				$data[$key]['name'] = $memObj->getNameByMemId($sendData['from']);
			}
		}
		@$this->_end('succ',$data);
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