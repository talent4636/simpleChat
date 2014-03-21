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
		$rowList = explode(',', $getWhat);
		$filter = $this->_toFilter($params,'AND');
		if (!$start && !$limit ){
			if (!$filter) {
				$sql = "SELECT ".$getWhat." FROM ".$tableName.$orderBy;
			}else {
    			$sql = "SELECT ".$getWhat." FROM ".$tableName." WHERE ".$filter." ".$orderBy;
			}
		}else{
    		$sql = "SELECT ".$getWhat." FROM ".$tableName." WHERE ".$filter." LIMIT ".$start.",".$limit." ".$orderBy;
		}
		$result = mysql_query($sql);
		$r = array();
		if ($result) {
		    $i = 0;
		    while ($row = mysql_fetch_array($result)){
                foreach ($rowList as $v){
                    $r[$i][$v] = $row[$v];
                }
                $i++;
		    }
		    mysql_free_result($result);
		}
		if (@$r[0]){
		    return $r;
		}else {
		    return false;
		}
		
	}

	//获取数据
	public function getRow($tableName,$getWhat,$params){
	    if (!$tableName || !$getWhat) {
			return false;
		}
		$rowList = explode(',', $getWhat);
		$filter = $this->_toFilter($params,'AND');
		$sql = "SELECT ".$getWhat." FROM ".$tableName." WHERE ".$filter;
		$result = mysql_query($sql);
		$data = mysql_fetch_row($result);
		mysql_free_result($result);
		if ($data) {
		    return $data;
		}else {
		    return false;
		}
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
				$sub = explode('|', $key);
				switch ($sub[1]){
				    case 'in':
    				    $inwhat = implode(',', $value);
				        $sqlArr[] = " ".$sub[0]." IN (".$inwhat.") ";
				        break;
				    default: ;
				}
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