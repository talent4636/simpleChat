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
		        'send_to|in'=>array($mem['id'],$sendData['from']),
		        'send_from|in'=>array($mem['id'],$sendData['from']),
		        'status'=>'1',
		        );
		$res = $db->getList('message_main','content,time,send_from',$params,'','','');
		if (is_array($res)) {
			$data = array();
			foreach ($res as $key => $value) {
				$data[$key]['content'] = $value['content'];
				$data[$key]['time'] = date("Y-m-d H:i:s",$value['time']);
				$data[$key]['name'] = $memObj->getNameByMemId($value['send_from']);
			}
		}
		@$this->_end('succ',$data);
	}
	
	//获取到对方发送的记录，每几秒刷新 @author jun.xie@magic-point.com 2014-3-21 下午4:35:51
	public function getMsgFromObj(){
	    //TODO
	}
	
	//发送消息
	public function sendMsg($sendData){
	    $mem = new member();
	    $toMem = $mem->getCurrentMember();
	    if (!$sendData['to'] || !$toMem['id'] || !$sendData['content']){
	        $this->_end('faile');
	        exit;
	    }
	    $db = new db();
	    $params = array(
	            'send_to'=>$sendData['to'],
	            'send_from'=>$toMem['id'],
	            'content'=>$sendData['content'],
	            'time'=>time(),
	            );
	    $result = $db->save('message_main',$params);
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
        $main->sendMsg($sendData);break;
    case 'get':
        $main->getMyMsg($sendData);break;
    default: return;
}


?>