<?php
// include the config
require_once('config/config.php');

// load the users class
require_once('classes/Files.php');

function getDirContaints($dir, $results= array(), $backDir = ""){

$allfiles = scandir($dir);
$files = new Files();
foreach($allfiles as $key => $value){
	if(!in_array($value,array(".",".."))){
		$timestamp = strtotime($value);
		$path = realpath($dir . DIRECTORY_SEPARATOR . $value);
		$uploadDirInfo = explode("_", basename($path));
		if(is_dir($path)){
			$dir_files = scandir($path);
			foreach ($dir_files as $k=>$v){
				if(!in_array($v,array(".",".."))){
					$pth = realpath($path . DIRECTORY_SEPARATOR . $v);
					if(!is_dir($pth)){
						$data['filename'] = basename($pth);
						$data['filepath'] = $path;
						$data['user_id'] = $uploadDirInfo['1'];
						$data['user_name'] = $uploadDirInfo['0'];
						$files->uploadBulkFiles($data);
					}
				}
			}
		}
	}
}
	return 'Files uploaded successfuly';

}

print_r(getDirContaints('D:\Work\xampp\htdocs\IGI\upload'));

?>