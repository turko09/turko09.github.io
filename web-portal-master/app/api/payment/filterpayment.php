<?php
namespace TeamAlpha\Web;
error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING);
require $_SERVER['DOCUMENT_ROOT'] . '/api/utils/auth.php';

// Declare use on objects to be used
use Exception;
use PDOException;
	// Check API Key
	if (!Auth::Authenticate()) {
		Http::ReturnError(401, array('message' => 'Invalid API Key provided.'));    
		return;
	}

$dbconfig = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config/config.ini');
$host = $dbconfig['db_server'];
$db = $dbconfig['db_name'];
$user = $dbconfig['db_user'];
$pass = $dbconfig['db_password'];

$conn = mysqli_connect("$host", "$user", "$pass", "$db");

$url = 'php://input'; // path to your JSON file
$data = file_get_contents($url); // put the contents of the file into a variable
$vals = json_decode($data); // decode the JSON feed

header('Content-Type: application/json; charset=UTF-8');

if (is_null($vals)) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(array('message' => 'No contents to process'));

} else {
    $from = $vals->from . ' 00:00:00';
    $to = $vals->to . ' 23:59:59';

    $addedfilter = "";
    if (property_exists($vals, 'passengerid')) {
        $passengerid = $vals->passengerid;
        $addedfilter = " AND tripid IN (SELECT id FROM trip WHERE passengerid = '$passengerid')";
    } else if (property_exists($vals, 'driverid')) {
        $driverid = $vals->driverid;
        $addedfilter = " AND tripid IN (SELECT id FROM trip WHERE vehicleid IN (SELECT id FROM vehicle WHERE driverid = '$driverid'))";
    }

    $query = "SELECT * FROM payment WHERE date BETWEEN '$from' and '$to'" . $addedfilter;

    $get = mysqli_query($conn, "$query");
    if (mysqli_num_rows($get) > 0) {
		
        $response = array();
        while ($sp = mysqli_fetch_array($get)) {
	    $payment="";
            $payment->id = "$sp[id]";
            $payment->tripid = "$sp[tripid]";
            $payment->date = "$sp[date]";
            $payment->amount = "$sp[amount]";
            $payment->mode = "$sp[mode]";

			array_push($response, $payment);
        }
        header('HTTP/1.1 201 Request Success');
		echo json_encode($response);
    } else {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(array('message' => 'No payment in the query'));
    }
}
