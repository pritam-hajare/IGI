<?php

function getDirContaints($dir, &resultss= array(), $backDir = ""){

$files = scandir($dir);

foreach($files as $key => $value){
	$timestamp = strtotime($value);
	$path = realpath($dir . DIRECTORY_SEPARATOR . $value);
	if(!is_dir($path)){
		//$results[]=$path;
		$copydir = $backDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . date("Y-m-d");
		mkdir($copydir);
		$newFile = $copydir . DIRECTORY_SEPARATOR . $value;
		if(!copy($path, $newFile )){
			//Log error Message
		} else {
			//Insert Into DataBase
			//Image name
			//get userid by username using folder from where we are picking image to move 
			//upload date
		}
	} else if(is_dir($path) && $value != '.' && $value != '..' && $value != '.git' && !$timestamp ){
		getDirContaints($path, $result, $path);
		//$results[]=$path;
		$backDir = $path;
	}
}
	return $results;

}

print_r(getDirContaints('xampp/htdocs/igi'));

function makedirs($dirpath, $mode = 0777){
	return is_dir($dirpath) || mkdir($dirpath, $mode, true);
}

?>