<?php
	ini_set ("display_errors", "1");
	$username = 'sijiay';
	$password = 'passcode';
	$host = 'localhost';
	$dbname = 'sijiay';	            
	$db = pg_connect("dbname=$dbname user=$username password=$password");
	if(!$db){
		echo "Error : Unable to open database\n";
	} else {
		// echo "Opened database successfully\n";
	}
	$stations = array();
	$response = array();
	// $sql = "SELECT * FROM station LIMIT 1"; 
	// $result = pg_query($db, $sql);
	// if (!$result) {
	// 	echo "An error occurred.\n";
	// 	exit;
	// }else{
	// 	echo "query problem";
	// }
	// while ($row = pg_fetch_row($result)) {
	// 	$stations[] = array('id'=> $row[0], 'lat'=> $row[3], 'long'=>$row[4]);
	// 	echo "id: $row[0]  lat: $row[3] long: $row[4]";
	// 	echo "<br />\n";
	// }
	// $response['stations'] = $stations;
	// $station_response =  json_encode($response);
	// echo "Operation done successfully\n";
	// $string = file_get_contents("neighborhoods.json");
	// $nb = json_decode($string,TRUE);
	// $temp_nb;
	// foreach($nb['neighborhoods'] as $key=>$val)
	// {
	// 	if($val['nickname'] == 'Central Park'){
	// 		$temp_nb = $val;
	// 		echo($val['name']);
	// 	}
	// }
?>