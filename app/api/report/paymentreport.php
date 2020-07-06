<?php


require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/http.php';

error_reporting( E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING );
$dbconfig = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config/config.ini');
$host=$dbconfig['db_server'];
$db=$dbconfig['db_name'];
$user=$dbconfig['db_user'];
$pass=$dbconfig['db_password'];

$conn=mysqli_connect("$host","$user","$pass","$db");

$url = 'php://input'; // path to your JSON file
$data = file_get_contents($url); // put the contents of the file into a variable
$vals = json_decode($data); // decode the JSON feed

if(is_null($vals))
{
	 header('HTTP/1.1 400 Bad Request');
    echo json_encode(array('message' => 'No contents to process'));
	$query="SELECT * FROM payment";
	
}
else{
$from=$vals->from;
$to=$vals->to;
$query="SELECT * FROM payment WHERE
	date BETWEEN '$from' and '$to'";
}

	if (Auth::Authenticate()) {

	$get=mysqli_query($conn,"$query");
	if(mysqli_num_rows($get)>0)
	{
	while($sp=mysqli_fetch_array($get))
	{
		
		$payment->pdate = "$sp[date]";
		$payment->tripid = "$sp[tripid]";
		$payment->amount = "$sp[amount]";
		$payment->mode = "$sp[mode]";
		
		
		echo json_encode($payment);
	}
	header('HTTP/1.1 201 Request Success');
	}
	else{
		header('HTTP/1.1 400 Bad Request');
    echo json_encode(array('message' => 'No payment in the query'));
	}
	else{
	Http::ReturnError(401, array('message' => 'Invalid API Key provided.'));
	return;
	}

	
	


	



?>
