<?php
#EDIT THE FOLLOWING VARIABLES TO MATCH YOUR CONFIGURATION
$DBUSER = "" #THE USER FOR THE DATABASE
$DBPASS = "" #THE DATABASE USER'S PASSWORD
$DB_DATABASE = "" #THE NAME OF THE DATABASE ON THE SERVER
$DB_TABLE = "" #THE NAME OF THE TABLE IN THE DATABASE

#DO NOT EDIT ANYTHING PASS THIS POINT

if($_SERVER["REQUEST_METHOD"] != "POST") {
die("USE POST");
}

$DB = new mysqli("localhost",$DBUSER,$DBPASS,$DB_DATABASE);

function formatAndQuery() { #first argument should be the query. %sv for strings to be escaped, %s for string and $d for int. the rest of the arguments should be the values in order
	global $DB;
	$args  = func_get_args();
	$query = array_shift($args); #remove the first element of the array as its own variable
	$query = str_replace("%sv","'%s'",$query);
	foreach ($args as $key => $val)
	    {
	        $args[$key] = $DB->real_escape_string($val);
			$args[$key] = htmlspecialchars($val);
	    }
	$query  = vsprintf($query, $args);
	$result = $DB->query($query);
	if (!$result)
	{
	throw new Exception($DB->error." [$query]");
	}
	return $result;
}

echo(formatAndQuery('INSERT INTO %s (download,upload,ping,time) VALUES (%sv,%sv,%sv,%sv)',$_DB_TABLE,$_POST["download"],$_POST["upload"],$_POST["ping"],$_POST["timestamp"]));

?>
