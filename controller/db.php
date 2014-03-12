<?php 
require_once "config.php";
class db{
    
    function __construct(){
        $conn = mysql_connect(DB_HOST,DB_USER,DB_PWD);
        $useDB = mysql_select_db(DB_NAME,$conn);
        @mysql_set_charset('utf-8');
        if (!$useDB){
            return false;
        }
    }

	public function db(){
		$conn = mysql_connect(DB_HOST,DB_USER,DB_PWD);
	}

	//获取数据
	public function getList($tableName,$getWhat,$params,$start,$limit,$orderBy){
		if (!$tableName || !$getWhat) {
			return false;
		}
		$filter = $this->_toFilter($params,'AND');
		if (!$start && !$limit ){
    		$sql = "SELECT ".$getWhat." FROM ".$tableName." WHERE ".$filter." ".$orderBy;
		}else{
    		$sql = "SELECT ".$getWhat." FROM ".$tableName." WHERE ".$filter." LIMIT ".$start.",".$limit." ".$orderBy;
		}
		$result = mysql_query($sql);
		if ($result) {
		    $row = mysql_fetch_array($result);
		    while ($row = mysql_fetch_array($result)){
		        $r[] = array(
		                'content' => $row['content'],
		                'time' => $row['time'],
		                );
		    }
		    mysql_free_result($result);
		}
		return $r;
	}

	//获取数据
	public function getRow(){
	    //TODO
	}

	public function save($tableName,$params){
	    $filter = $this->_toFilter($params);
	    //INSERT INTO message_main SET send_from="1",send_to="2",content="xxxx",`time`="1356154211"
	    $sql = "INSERT INTO ".$tableName." SET ".$filter;
	    $res = mysql_query($sql);
	    return $res;
	}

	private function _toFilter($params,$and=''){
		if(!is_array($params)) return false;
		$sqlArr = array();
		foreach ($params as $key => $value) {
			//解析$key
			if (strpos($key,"|")) {
				strtok($key, "|");
				//TODO
			}else {
			    $sqlArr[] = "`".$key."`='".$value."'";
			}
			
		}
		if ($and){
		    $sqlStr = implode(' AND ', $sqlArr);
		}else{
    		$sqlStr = implode(',', $sqlArr);
		}
		return $sqlStr;

	}
}
?>