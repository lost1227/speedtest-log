<?php
#EDIT THE FOLLOWING VARIABLES TO MATCH YOUR CONFIGURATION
$DBUSER = "" #THE USER FOR THE DATABASE
$DBPASS = "" #THE DATABASE USER'S PASSWORD
$DB_DATABASE = "" #THE NAME OF THE DATABASE ON THE SERVER
$DB_TABLE = "" #THE NAME OF THE TABLE IN THE DATABASE
$TIMEZONE = "" # YOUR LOCAL TIMEZONE. SEE: http://php.net/manual/en/timezones.php

#DO NOT EDIT ANYTHING PASS THIS POINT
?>

<html>
<head>
<title>Speedtest Data</title>
<script src="Chart.bundle.min.js"></script>
<style>
#chartdiv {
    width: 70%;
    margin: auto;
    min-width: 400px;
    height: 80%;
    min-height: 400px;
}
</style>
</head>
<body>
<h1>Speedtest Data</h1>
<div id="chartdiv">
<canvas id="chart"></canvas>
</div>
<?php
$DB = new mysqli("localhost","jordanpo_ro",".AE7avQulO_N","jordanpo_speeddata");
if($DB->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$data = $DB->query('(SELECT * FROM data ORDER BY id DESC LIMIT 500) ORDER BY id ASC;');
$labels = "";
$upload = "";
$download = "";
$ping = "";
while($row = $data->fetch_assoc()) {
	$date = DateTime::createFromFormat('Y-m-d\TH:i:s.u',$row["time"],new DateTimeZone('UTC'));
	if($date == False) {
		echo(var_dump($row));
		die(var_dump(DateTime::getLastErrors()));
	}
	$date->setTimezone(new DateTimeZone($TIMEZONE));

	$labels = $labels.'"'.$date->format('n-j-y g:i A').'",';
	$upload = $upload.$row["upload"].', ';
	$download = $download.$row["download"].', ';
	$ping = $ping.$row["ping"].', ';
}
$labels = rtrim($labels,',');
$upload = rtrim($upload,', ');
$download = rtrim($download,', ');
$ping = rtrim($ping,', ');
?>
<script>
var data = {
	labels: [<?php echo($labels); ?>],
	datasets: [{
		label: "Download Speed",
		data: [<?php echo($download); ?>],
		fill: false,
		borderColor: "#006aff"
		},{
		label: "Upload Speed",
		data: [<?php echo($upload); ?>],
		fill: false,
		borderColor: "#0bc133"
		},{
		label: "Ping Times",
		data: [<?php echo($ping); ?>],
		fill: false,
		borderColor: "#af1515"
		}],
	};

var chart = new Chart(document.getElementById('chart'), {
	type: 'line',
	data: data,
	options: {
		responsive: true,
		maintainAspectRatio: false
	}
});
</script>
</body>
</html>
