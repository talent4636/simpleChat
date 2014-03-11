<?php 
require_once "config.php";
class db{

	public function db(){
		$conn = mysql_connect(DB_HOST,DB_USER,DB_PWD);
	}

	//获取数据
	public function getList($tableName,$getWhat,$params,$start,$limite,$orderBy){
		if (!$tableName || $getWhat) {
			return false;
		}
		$filter = $this->_toFilter($params);

		$sql = "SELECT ".$getWhat." FROM ".$tableName." WHERE ".$filter." LIMIT ".$start.",".$limite.$orderBy;

	}

	//获取数据
	public function getRow(){

	}

	public function insert(){

	}

	private function _toFilter($params){
		if(!is_array($params)) return false;
		foreach ($params as $key => $value) {
			//解析$key
			if (strpos($key,'|')) {
				strtok($key, '|');
				//TODO
			}
			
		}

	}
}
?>