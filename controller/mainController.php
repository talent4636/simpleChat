<?php
require_once "db.php";
class main(){

	public function getMyMsg($member_id){
		$db = new db();
		$db->getList();
	}
}
?>