<?php
namespace TeamAlpha\Web;
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/auth.php';
$dbconfig = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config/config.ini');
$host=$dbconfig['db_server'];
$db=$dbconfig['db_name'];
$user=$dbconfig['db_user'];
$pass=$dbconfig['db_password'];
$conn=mysqli_connect("$host","$user","$pass","$db");
// Declare use on objects to be used
use Exception;
use PDOException;
if (!Auth::Authenticate()) {
    Http::ReturnError(401, array('message' => 'Invalid API Key provided.'));    
    return;
}


$url = 'php://input'; // path to your JSON file
$data = file_get_contents($url); // put the contents of the file into a variable
$vals = json_decode($data); // decode the JSON feed

if(is_null($vals))
{
	header('HTTP/1.1 400 Bad Request');
	echo json_encode(array('message' => 'No contents to process'));
	
}
else
{	
	$id=$vals->id;
	$get = mysqli_query($conn, "SELECT COUNT(*) count FROM trip WHERE passengerid = $id LIMIT 1");
	$rv = mysqli_fetch_array($get);

	if ((int) $rv['count'] > 0) 
	{
		header('HTTP/1.1 400 Bad Request');
		echo json_encode(array('message' => 'Cannot delete passenger - associated trip records detected.'));
	}
	else 
	{
		//delete query
		$deletequery=mysqli_query($conn, "DELETE FROM passenger WHERE id = $id LIMIT 1")or die(mysqli_error());

		if(!$deletequery)
		{
			header('HTTP/1.1 400 Bad Request');
			echo json_encode(array('message' => 'Query Error'));			
		}
		else
		{
			header('HTTP/1.1 200 OK');
			echo json_encode(array('message' => 'Successfully deleted the account', 'passengerId' => $id));
		}
	}
}

?>
