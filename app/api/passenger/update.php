<?php
namespace TeamAlpha\Web;
error_reporting( E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING );
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
// Check API Key
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
else{
$id=$vals->id;
$firstname=$vals->firstname;
$lastname=$vals->lastname;
$email=$vals->email;
$password=$vals->password;
$address=$vals->address;
$mobile=$vals->mobile;
$pmobile=$vals->panicmobile;
$creditcardnumber=$vals->$creditcardnumber;
$datemodified=date("Y-m-d H:i:s");

$checkexisting=mysqli_query($conn, "SELECT id,email,mobile,panicmobile FROM passenger WHERE id != $id && (email LIKE '$email'
|| email LIKE '$mobile' || panicmobile LIKE '$pmobile')");
if(mysqli_num_rows($checkexisting)>0)
{
	 header('HTTP/1.1 400 Bad Request');
    echo json_encode(array('message' => 'Email Or mobile used is currently registered try using another.'));
}
else{

if(count(json_decode($data,1))==0) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(array('message' => 'Passenger details are empty.'));
}
else{
//Insert Query
$qrys=mysqli_query($conn, "UPDATE passenger SET firstname = '$firstname', lastname = '$lastname',
email = '$email',password = '$password',address = '$address',mobile = '$mobile',
panicmobile = '$pmobile',datemodified = '$datemodified',creditcardnumber='$creditcardnumber' WHERE id = $id")or die(mysqli_error());

	if(!$qrys)
	{
		header('HTTP/1.1 400 Bad Request');
    echo json_encode(array('message' => 'Query Error'));
		
	}
	else
	{
	header('HTTP/1.1 200 OK');
    echo json_encode(array('message' => 'Successfully updated the record', 'passengerId' => $id));
	}
}
}
}
?>
