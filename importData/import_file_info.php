<?php
ini_set("display_errors",1);
require_once 'excel_reader2.php';
// load the registration class
// include the config
require_once('../config/config.php');

 $db = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
//require_once('../classes/Keywords.php');
//require_once('../classes/Files.php');

$data = new Spreadsheet_Excel_Reader("IGI_worksheet.xls");
echo "Total Sheets in this xls file: ".count($data->sheets)."<br /><br />";
//print_r($data->boundsheets[0]['name']);die();
$html="<table border='1'>";

for($i=0;$i<count($data->sheets);$i++) // Loop to get all sheets in a file.

{ 

//echo '<pre>';print_r($data->sheets[$i]['cells']);die();
 if(isset($data->sheets[$i]['cells']))	
 if(count($data->sheets[$i]['cells'])>0) // checking sheet not empty
 {
	//$Keywords = new Keywords();
	$query_user = $db->prepare('SELECT * FROM igi_files WHERE filename = :filename');
	$query_update = $db->prepare('UPDATE igi_files 
										SET 
											keywords = :keywords,
											tags = :tags,
											year = :year,
											month = :month,
											day = :day,
											updatedate = now()
										WHERE fileid = :fileid');
	//$fileObj = new Files();
	echo "IGI workSheet :<br /><br />Total rows in sheet $i  ".count($data->sheets[$i]['cells'])."<br />";
	for($j=2;$j<=count($data->sheets[$i]['cells']);$j++) // loop used to get each row of the sheet
	{
		//echo '<pre>';print_r($data->sheets[$i]['cells'][$j]);
		$filename = $data->sheets[$i]['cells'][$j][2].'.jpg';
		$fileid = '';
		$query_user->bindValue(':filename', $filename);
		$query_user->execute();
		$fileInfo = $query_user->fetch(PDO::FETCH_ASSOC);
		if(!empty($fileInfo)){
			if(isset($fileInfo['fileid']))
				$fileid = $fileInfo['fileid'];
			else
				continue;
		}
		
		if(isset($data->sheets[$i]['cells'][$j][3])){
			if(isset($data->sheets[$i]['cells'][$j][4])){
				$keywords = trim($data->sheets[$i]['cells'][$j][3].','.$data->sheets[$i]['cells'][$j][4]);
			}else{
				$keywords = trim($data->sheets[$i]['cells'][$j][3]);
			}
		}
    	$tags = isset($data->sheets[$i]['cells'][$j][5]) ? trim($data->sheets[$i]['cells'][$j][5]) : '';
    	$year = isset($data->sheets[$i]['cells'][$j][7]) ? trim($data->sheets[$i]['cells'][$j][7]) : '';
    	$month = isset($data->sheets[$i]['cells'][$j][8]) ? trim($data->sheets[$i]['cells'][$j][8]) : '';
    	$day = isset($data->sheets[$i]['cells'][$j][9]) ? trim($data->sheets[$i]['cells'][$j][9]) : '';
		$query_update->bindValue(':keywords', rtrim($keywords, ','));
		$query_update->bindValue(':tags', $tags);
		$query_update->bindValue(':year', $year);
		$query_update->bindValue(':month', $month);
		$query_update->bindValue(':day', $day);
		$query_update->bindValue(':fileid', $fileid);
		$html.="<tr>";
	
		$html.="<td>";
			
		//if(!empty($data->sheets[$i]['cells'][$j][$k])){
		if($fileid){
			if($query_update->execute())
			$html.= "<b>".$filename."</b> updated";
		}else{		
			$html.= "<b>".$filename."</b> could not find";
		}

		$html.="</td>";
		
		$html.="</tr>";
		
	}
 }
}
$html.="</table>";
echo $html;
//echo "<br />Data Inserted in dababase";

?>