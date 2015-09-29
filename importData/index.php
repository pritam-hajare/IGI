<?php
ini_set("display_errors",1);
require_once 'excel_reader2.php';
// load the registration class
// include the config
require_once('../config/config.php');
require_once('../classes/Keywords.php');

$data = new Spreadsheet_Excel_Reader("IGI.xls");
echo "Total Sheets in this xls file: ".count($data->sheets)."<br /><br />";
//print_r($data->boundsheets[0]['name']);die();
$html="<table border='1'>";

for($i=0;$i<count($data->sheets);$i++) // Loop to get all sheets in a file.

{ 
 if(isset($data->sheets[$i]['cells']))	
 if(count($data->sheets[$i]['cells'])>0) // checking sheet not empty

 {
	if($data->boundsheets[$i]['name'] == 'Keywords'){
		$Keywords = new Keywords();
		echo "Sheet Keywords:<br /><br />Total rows in sheet $i  ".count($data->sheets[$i]['cells'])."<br />";
		for($j=1;$j<=count($data->sheets[$i]['cells']);$j++) // loop used to get each row of the sheet
		{
			$html.="<tr>";
		
			for($k=1;$k<=count($data->sheets[$i]['cells'][$j]);$k++) // This loop is created to get data in a table format.
		
			{
				$html.="<td>";
				
				if(!empty($data->sheets[$i]['cells'][$j][$k])){
					$keyword = $data->sheets[$i]['cells'][$j][$k];
					$result = $Keywords->importKeyword($keyword);
				}
				$html.= "<b>".$data->sheets[$i]['cells'][$j][$k]."</b> $result";
		
				$html.="</td>";
		
			}
			
			$html.="</tr>";
			
		}
	}elseif($data->boundsheets[$i]['name'] == 'Tags'){
		echo "Sheet Tags:<br /><br />Total rows in sheet $i  ".count($data->sheets[$i]['cells'])."<br />";
		/*for($j=1;$j<=count($data->sheets[$i]['cells']);$j++) // loop used to get each row of the sheet
		{
			$html.="<tr>";
		
			for($k=1;$k<=count($data->sheets[$i]['cells'][$j]);$k++) // This loop is created to get data in a table format.
		
			{
				$html.="<td>";
		
				if(!empty($data->sheets[$i]['cells'][$j][$k])){
					$keyword = $data->sheets[$i]['cells'][$j][$k];
					$result = $Keywords->importKeyword($keyword);
				}
				$html.= "<b>".$data->sheets[$i]['cells'][$j][$k]."</b> $result";
		
				$html.="</td>";
		
			}
				
			$html.="</tr>";
				
		}*/
	}
 }
}
$html.="</table>";
echo $html;
//echo "<br />Data Inserted in dababase";

?>