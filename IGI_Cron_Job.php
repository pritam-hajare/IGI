<?php

function getDirContaints($dir, $results= array(), $backDir = ""){

$files = scandir($dir);
echo '<pre>'; print_r($files);
foreach($files as $key => $value){
	//echo $value;
	if(!in_array($value,array(".",".."))){
		$timestamp = strtotime($value);
		$path = realpath($dir . DIRECTORY_SEPARATOR . $value);
		echo basename($path)."<br>";
		if(is_dir($path)){
			$dir_files = scandir($path);
			echo '<pre>'; print_r();
		}
		/*if(!is_dir($path)){
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
		}*/
	}
}
	return $results;

}

print_r(getDirContaints('D:\Work\xampp\htdocs\IGI\upload'));

function makedirs($dirpath, $mode = 0777){
	return is_dir($dirpath) || mkdir($dirpath, $mode, true);
}

?>