<?php
	ini_set ("display_errors", "1");
	$username = 'sijiay';
	$password = 'passcode';
	$host = 'localhost';
	$dbname = 'sijiay';	            
	$db = pg_connect("dbname=$dbname user=$username password=$password");
	if(!$db){
		//echo "Error : Unable to open database\n";
	} else {
		//echo "Opened database successfully\n";
	}
	$lat_min;
	$lat_max;
	$long_min;
	$long_max;
	$station_response;
	$stations = array();
	$response = array();
	if ($_REQUEST["bounds"]){
		$bounds = $_REQUEST['bounds'];
		$lat_min = $bounds['southwest']['lat'];
		$lat_max = $bounds['northeast']['lat'];
		$long_min = $bounds['southwest']['lng'];
		$long_max = $bounds['northeast']['lng'];
		// echo $lat_min;
		// echo $lat_max;
		// echo $long_max;
		// echo $long_min;
	}
	$sql1 = "SELECT * FROM station 
		WHERE lat BETWEEN '$lat_min' AND '$lat_max'
		AND long BETWEEN '$long_max' AND '$long_min' 			
		LIMIT 100"; 
	$result = pg_query($db, $sql1);
	if (!$result) {	
		//echo "An error occurred.\n";
		exit;
	}else{
		//echo "query problem";
	}
	while ($row = pg_fetch_row($result)) {
		$stations[] = array('id'=> $row[0], 'name'=>$row[1], 'lat'=> $row[4], 'long'=>$row[5]);
	}
	$response['stations'] = $stations;
	$station_response =  json_encode($stations);

	echo $station_response;
	pg_close($db);
?>