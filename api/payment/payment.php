<?php
namespace TeamAlpha\Web;
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/auth.php';
error_reporting( E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING );
// Declare use on objects to be used
use Exception;
use PDOException;
	// Check API Key
	if (!Auth::Authenticate()) {
		Http::ReturnError(401, array('message' => 'Invalid API Key provided.'));    
		return;
	}

$dbconfig = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config/config.ini');

$host=$dbconfig['db_server'];
$db=$dbconfig['db_name'];
$user=$dbconfig['db_user'];
$pass=$dbconfig['db_password'];


$url = 'php://input'; // path to your JSON file
$data = file_get_contents($url); // put the contents of the file into a variable
$vals = json_decode($data); // decode the JSON feed

if(is_null($vals))
{
	 header('HTTP/1.1 400 Bad Request');
    echo json_encode(array('message' => 'No contents to process'));
	
}
else{
	
$tripid=$vals->tripid;
$amount=$vals->amount;
$mode=$vals->mode;
$date=date("Y-m-d H:i:s");



if(count(json_decode($data,1))==0) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(array('message' => 'Payment details are empty.'));
}
else{
//Insert Query
$qrys=mysqli_query($conn, "INSERT INTO payment VALUES('','$date',$tripid,$amount,'$mode');")or die(mysqli_error());

	if(!$qrys)
	{
		header('HTTP/1.1 400 Bad Request');
    echo json_encode(array('message' => 'Query Error'));
		
	}
	else
	{
	header('HTTP/1.1 201 Created');
    echo json_encode(array('message' => 'Successfully recorded the payment', 'tripid' => $tripid));
	}
}
}


?>
