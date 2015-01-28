<?php
$sql1 = "SELECT COUNT(t.id) 
FROM trip t 
JOIN gender g ON t.gender = g.id 
JOIN user_type ut ON t.user_type = ut.id 
WHERE g.gender = 'female' AND ut.name = 'Subscriber'";
$fs_count;
$ms_count;
$us_count;
$top_start_stations = array();
$top_end_stations = array();
$by_counts = array();

//Count of trips taken by female Subscribers
$result = pg_query($db, $sql1);
	if (!$result) {
		echo "An error occurred.\n";
		exit;
	}
	while ($row = pg_fetch_row($result)) {
		$fs_count = $row[0];
	}
	// echo 'female count' . $fs_count;
$sql2 = "SELECT COUNT(t.id) 
FROM trip t 
JOIN gender g ON t.gender = g.id 
JOIN user_type ut ON t.user_type = ut.id 
WHERE g.gender = 'male' AND ut.name = 'Subscriber'";

//Count of trips taken by male Subscribers
$result = pg_query($db, $sql2);
	if (!$result) {
		echo "An error occurred.\n";
		exit;
	}
	while ($row = pg_fetch_row($result)) {
		$ms_count = $row[0];
	}
	// echo 'male count' . $ms_count;

//Count of trips taken by female Subscribers
$sql3 = "SELECT COUNT(t.id) 
FROM trip t 
JOIN gender g ON t.gender = g.id 
JOIN user_type ut ON t.user_type = ut.id 
WHERE g.gender = 'unknown' AND ut.name = 'Subscriber'";
$result = pg_query($db, $sql3);
	if (!$result) {
		echo "An error occurred.\n";
		exit;
	}
	while ($row = pg_fetch_row($result)) {
		$us_count = $row[0];
	}
	// echo 'unknown count' . $us_count;

$sql4 = "SELECT t.start_station, COUNT(t.start_station) AS station_count
FROM trip t
GROUP BY t.start_station
ORDER BY station_count DESC
LIMIT 5";

$result = pg_query($db, $sql4);
	if (!$result) {
		echo "An error occurred.\n";
		exit;
	}
	while ($row = pg_fetch_row($result)) {		
		$top_start_stations[] = array('id'=> $row[0], 'count'=>$row[1]);
	}
	// echo count($top_start_stations);
	// echo json_encode($top_start_stations);


$sql5 = "SELECT t.end_station, COUNT(t.start_station) AS station_count
FROM trip t
GROUP BY t.end_station
ORDER BY station_count DESC
LIMIT 5";

$result = pg_query($db, $sql5);
	if (!$result) {
		echo "An error occurred.\n";
		exit;
	}
	while ($row = pg_fetch_row($result)) {		
		$top_end_stations[] = array('id'=> $row[0], 'count'=>$row[1]);
	}
	// echo count($top_end_stations);
	// echo json_encode($top_end_stations);

$sql6 = "SELECT birthyear, COUNT(birthyear) AS by 
FROM trip 
GROUP BY birthyear 
ORDER BY by DESC 
LIMIT 10";

$result = pg_query($db, $sql6);
	if (!$result) {
		echo "An error occurred.\n";
		exit;
	}
	while ($row = pg_fetch_row($result)) {		
		$by_counts[] = array('by'=> $row[0], 'count'=>$row[1]);
	}


?>


