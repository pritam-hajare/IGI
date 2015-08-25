<?php
// include the config
require_once('../config/config.php');
require_once('../classes/Keywords.php');

$Keywords = new Keywords();

$q=$_GET['term'];
$my_data=mysql_real_escape_string($q);
$data = array();
$result = $Keywords->getKeyword($my_data);
$data = array();
if(!empty($result)){
	foreach ($result as $k=>$v){
		$data[] = $v['keywords'];
	}
	echo json_encode($data);
}